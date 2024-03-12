<?php

namespace PouchScanner\Application\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use PouchScanner\Application\DataTransferObjects\PillCollectionDto;
use PouchScanner\Application\DataTransferObjects\PillDto;
use PouchScanner\Application\DataTransferObjects\PouchCollectionDto;
use PouchScanner\Application\DataTransferObjects\PouchDto;
use PouchScanner\Application\DataTransferObjects\RepairCollectionDto;
use PouchScanner\Application\DataTransferObjects\RepairDto;
use PouchScanner\Application\DataTransferObjects\RollCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollDto;
use PouchScanner\Domain\Connection;
use PouchScanner\Domain\Contracts\Pill;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\Pouch;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\PouchScannerInterface;
use PouchScanner\Domain\Contracts\Repair;
use PouchScanner\Domain\Contracts\RepairCollection;
use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\Exceptions\InvalidInstanceOfCollectionException;
use PouchScanner\Domain\Exceptions\InvalidResponseException;
use PouchScanner\Domain\Exceptions\FailedSaveFileException;
use PouchScanner\Domain\Exceptions\FailedActionException;
use PouchScanner\Domain\Exceptions\InvalidFileFormatException;
use PouchScanner\Domain\RollStatus;
use PouchScanner\Domain\StorageSetting;
use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use SimpleXMLElement;

/**
 * This class implements all the methods of the PouchScanner facade
 * you can call any of these methods in your application
 */
class PouchScanner implements PouchScannerInterface
{
    private const PAYLOAD = '<?xml version="1.0" encoding="UTF-8"?><Content><Username>%s</Username><Password>%s</Password></Content>';
    private readonly RollCreator $rollCreator;
    private readonly PouchCreator $pouchCreator;
    private Client $client;
    private Connection $connection;
    private StorageSetting $storage;
    private XmlReader $xmlReader;
    private array $headers;
    private array $images = [];

    public function __construct()
    {
        $this->client = new Client();
        $this->headers = config('pouch-scanner.http.headers');
        $this->xmlReader = new XmlReader;
        $this->rollCreator = new RollCreator;
        $this->pouchCreator = new PouchCreator;
    }

    /**
     * @param Roll ...$rolls
     * @return RollCollection
     * @throws InvalidInstanceOfCollectionException
     */
    public function rollCollection(...$rolls): RollCollection
    {
        $rollCollection = new RollCollectionDto;
        if (count($rolls) > 0){
            $rollCollection->push(...$rolls);
        }
        return  $rollCollection;
    }

    /**
     * @param Pouch ...$pouches
     * @return PouchCollection
     * @throws InvalidInstanceOfCollectionException
     */
    public function pouchCollection(...$pouches): PouchCollection
    {
        $pouchCollection = new PouchCollectionDto;
        if (count($pouches) > 0){
            $pouchCollection->push(...$pouches);
        }
        return  $pouchCollection;
    }

    /**
     * @param Pill ...$pills
     * @return PillCollection
     * @throws InvalidInstanceOfCollectionException
     */
    public function pillCollection(...$pills): PillCollection
    {
        $pillCollection = new PillCollectionDto;
        if (count($pills) > 0) {
            $pillCollection->push(...$pills);
        }
        return  $pillCollection;
    }

    /**
     * @param Repair ...$repairs
     * @return RepairCollection
     * @throws InvalidInstanceOfCollectionException
     */
    public function repairCollection(...$repairs): RepairCollection
    {
        $repairCollection = new RepairCollectionDto;
        if (count($repairs) > 0) {
            $repairCollection->push(...$repairs);
        }
        return  $repairCollection;
    }

    /**
     * @param string|null $patientRoll
     * @param string|null $batchId
     * @param string|null $patientId
     * @param string|null $status
     * @param PouchCollection|null $pouches
     * @return Roll
     */
    public function roll(
        ?string $patientRoll = null,
        ?string $batchId = null,
        ?string $patientId = null,
        ?string $status = null,
        ?PouchCollection $pouches = null
    ): Roll
    {
        return new RollDto(
            patientRoll: $patientRoll,
            batchId: $batchId,
            patientId: $patientId,
            status: $status ?? RollStatus::NOT_INSPECTED->value,
            pouches: $pouches
        );
    }

    /**
     * @param string|null $pouchId
     * @param bool $secondValidation
     * @param string|null $secondValidationBy
     * @param string|null $checkedBy
     * @param DateTime|null $checkedDateTime
     * @param string|null $pouchImageUrl
     * @param string|null $productionBox
     * @param DateTime|null $doseTime
     * @param string|null $visionState
     * @param string|null $visionMessage
     * @param RepairCollection|null $repairs
     * @param PillCollection|null $pills
     * @return Pouch
     */
    public function pouch(
        ?string $pouchId = null,
        bool $secondValidation = false,
        ?string $secondValidationBy = null,
        ?string $checkedBy = null,
        ?DateTime $checkedDateTime = null,
        ?string $pouchImageUrl = null,
        ?string $productionBox = null,
        ?DateTime $doseTime = null,
        ?string $visionState = null,
        ?string $visionMessage = null,
        ?RepairCollection $repairs = null,
        ?PillCollection $pills = null
    ): Pouch
    {
        return new PouchDto(
            pouchId: $pouchId,
            secondValidation: $secondValidation,
            secondValidationBy: $secondValidationBy,
            checkedBy: $checkedBy,
            checkedDateTime: $checkedDateTime,
            pouchImageUrl: $pouchImageUrl,
            productionBox: $productionBox,
            doseTime: $doseTime,
            visionState: $visionState,
            visionMessage: $visionMessage,
            repairs: $repairs,
            pills: $pills
        );
    }

    /**
     * @param string|null $comment
     * @param string|null $repair
     * @param string|null $user
     * @param DateTime|null $dateTime
     * @return Repair
     */
    public function repair(
        ?string $comment = null,
        ?string $repair = null,
        ?string $user = null,
        ?DateTime $dateTime = null
    ): Repair
    {
        return new RepairDto(
            comment: $comment,
            repair: $repair,
            user: $user,
            dateTime: $dateTime,
        );
    }

    /**
     * @param string|null $medicationId
     * @param int|null $amount
     * @param string|null $description
     * @param bool $detected
     * @param string|null $image
     * @return Pill
     */
    public function pill(
        ?string $medicationId = null,
        ?int $amount = null,
        ?string $description = null,
        bool $detected = false,
        ?string $image = null
    ): Pill
    {
        return new PillDto(
            medicationId: $medicationId,
            amount: $amount,
            description: $description,
            detected: $detected,
            image: $image,
        );
    }

    /**
     * @param Connection|null $connection
     * @param StorageSetting|null $storage
     * @return PouchScannerInterface
     */
    public function configure(
        ?Connection $connection = null,
        ?StorageSetting $storage = null
    ): PouchScannerInterface
    {
        $this->connection = $connection ?? new Connection(
            hostname: config('pouch-scanner.connection.host'),
            username: config('pouch-scanner.connection.username'),
            password: config('pouch-scanner.connection.password'),
            protocol: config('pouch-scanner.connection.protocol'),
            port: config('pouch-scanner.connection.port'),
        );
        $this->storage = $storage ?? new StorageSetting(
            storageDirectory: config('pouch-scanner.storage.requests-dir'),
            downloadImageDirectory: config('pouch-scanner.storage.images-dir'),
            storageDisk: config('pouch-scanner.storage.disk'),
            storageRequest: config('pouch-scanner.storage.requests'),
            downloadImages: config('pouch-scanner.storage.images'),
        );
        return $this;
    }

    /**
     * @return PouchScannerInterface
     * @throws GuzzleException
     * @throws FailedActionException
     * @throws InvalidFileFormatException
     * @throws InvalidResponseException
     */
    public function login(): PouchScannerInterface
    {
        $body = sprintf(self::PAYLOAD, $this->connection->getUsername(), $this->connection->getPassword());
        $response = $this->sendRequest('Data/Export/Login', 'POST', $body);
        $this->xmlReader->read($response);
        $this->headers['Session'] = $this->xmlReader->getContent()['data'];
        return $this;
    }

    /**
     * @param int $daysBack
     * @return RollCollection
     * @throws FailedSaveFileException
     * @throws GuzzleException
     * @throws FailedActionException
     * @throws InvalidFileFormatException
     * @throws InvalidResponseException
     * @throws InvalidInstanceOfCollectionException
     */
    public function getNotInspectedRolls(int $daysBack = 1): RollCollection
    {
        $response = $this->sendRequest("Data/Export/GetNotInspectedRolls/{$daysBack}");
        $this->saveRequestIfConfigured($response);
        return $this->rollCreator->__invoke(
            data: $this->xmlReader->read($response),
            status: RollStatus::NOT_INSPECTED
        );
    }

    /**
     * @param int $daysBack
     * @return RollCollection
     * @throws FailedSaveFileException
     * @throws GuzzleException
     * @throws FailedActionException
     * @throws InvalidFileFormatException
     * @throws InvalidResponseException
     * @throws InvalidInstanceOfCollectionException
     */
    public function getInProgressRolls(int $daysBack = 1): RollCollection
    {
        $response = $this->sendRequest("Data/Export/GetInProgressRolls/{$daysBack}");
        $this->saveRequestIfConfigured($response);
        return $this->rollCreator->__invoke(
            data: $this->xmlReader->read($response),
            status: RollStatus::IN_PROGRESS
        );
    }

    /**
     * @param int $daysBack
     * @return RollCollection
     * @throws FailedSaveFileException
     * @throws GuzzleException
     * @throws FailedActionException
     * @throws InvalidFileFormatException
     * @throws InvalidResponseException
     * @throws InvalidInstanceOfCollectionException
     */
    public function getFinalizedRolls(int $daysBack = 1): RollCollection
    {
        $response = $this->sendRequest("Data/Export/GetFinalizedRolls/{$daysBack}");
        $this->saveRequestIfConfigured($response);
        return $this->rollCreator->__invoke(
            data: $this->xmlReader->read($response),
            status: RollStatus::FINALIZED
        );
    }

    /**
     * @param int|string $rollId
     * @return Roll
     * @throws FailedSaveFileException
     * @throws GuzzleException
     * @throws FailedActionException
     * @throws InvalidFileFormatException
     * @throws InvalidResponseException
     * @throws Exception
     */
    public function getRoll(int|string $rollId): Roll
    {
        $response = $this->sendRequest("Data/Export/GetRoll/{$rollId}");
        $this->saveRequestIfConfigured($response);
        $arrayContent = $this->xmlReader->read($response);
        $attributes = $this->pouchCreator->attributes($arrayContent);
        $roll = new RollDto(
            patientRoll: $rollId,
            batchId: $attributes->batchId,
            patientId: $attributes->patientId,
            status: RollStatus::FINALIZED->value,
            pouches: $this->pouchCreator->__invoke($arrayContent)
        );
        return $roll->setPouches(
            $this->saveImageIfConfigured($roll->getPouches())
        );
    }

    /**
     * @param string $request
     * @return void
     * @throws FailedSaveFileException
     */
    private function saveRequestIfConfigured(string $request):void
    {
        if ($this->storage->isStorageRequest()) {
            $filename = sprintf(
                '%s/request-%s.xml',
                $this->storage->getStorageDirectory(),
                now()->format('Y-m-d_H-i-s')
            );
            try {
                Storage::disk($this->storage->getStorageDisk())->put($filename, $request);
            } catch (Exception $exception) {
                throw new FailedSaveFileException($filename);
            }
        }
    }

    /**
     * @param PouchCollection|null $pouches
     * @return PouchCollection|null
     * @throws InvalidInstanceOfCollectionException
     */
    private function saveImageIfConfigured(?PouchCollection $pouches): ?PouchCollection
    {
        if (is_null($pouches)) {
            return null;
        }
        if ($this->storage->isDownloadImages()) {
            $editPuches = new PouchCollectionDto;
            foreach ($pouches as $pouch) {
                try {
                    $imageUrl = $pouch->getPouchImageUrl();
                    $imageContent = file_get_contents($imageUrl);
                    $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
                    $filename = sprintf('image-%s.%s', now()->format('Y-m-d_H-i-s'), $extension);
                    $filepath = sprintf('%s/%s', $this->storage->getDownloadImageDirectory(), $filename);

                    Storage::disk($this->storage->getStorageDisk())->put($filepath, $imageContent);
                    $editPuches->push($pouch->setPouchImageUrl($filepath));
                } catch (Exception $e) {
                    $editPuches->push($pouch);
                }
            }
            return $editPuches;
        }
        return null;
    }

    /** @throws GuzzleException
     * @throws InvalidResponseException
     */
    private function sendRequest(string $uri, ?string $method = null, string $body = ''): string
    {
        $method = is_null($method) ? config('pouch-scanner.http.verb') : $method;
        $request = new Request($method, $this->url($uri), $this->headers, $body);
        try {
            $res = $this->client->sendAsync($request, $this->options())->wait();
            return $res->getBody();
        } catch (Exception $exception) {
            throw new InvalidResponseException($exception->getMessage());
        }
    }

    /**
     * @param string $uri
     * @return string
     */
    private function url(string $uri = ''): string
    {
        $port = !in_array($this->connection->getPort(), [80, 443]) ? ':' . $this->connection->getPort() : '';
        $protocol  = $this->connection->getProtocol();
        $host = $this->connection->getHostname();
        return "{$protocol}://{$host}{$port}/{$uri}";
    }

    /**
     * @return array
     */
    private function options(): array
    {
        return [
            'exceptions' => config('pouch-scanner.http.exceptions'),
            'timeout' => config('pouch-scanner.http.timeout'),
            'verify' => config('pouch-scanner.http.verify_ssl'),
            'http_errors' => true,
        ];
    }
}
