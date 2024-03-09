<?php

namespace PouchScanner\Application\Services;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use PouchScanner\Application\DataTransferObjects\PouchCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollDto;
use PouchScanner\Domain\Connection;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\PouchScannerInterface;
use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\Exceptions\InvalidResponseException;
use PouchScanner\Domain\Exceptions\FailedSaveFileException;
use PouchScanner\Domain\RollStatus;
use PouchScanner\Domain\StorageSetting;
//use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;/*
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;*/
use SimpleXMLElement;

/**
 * This class implements lorem ipsum
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

    public function login(): PouchScannerInterface
    {
        $body = sprintf(self::PAYLOAD, $this->connection->getUsername(), $this->connection->getPassword());
        $response = $this->sendRequest('Data/Export/Login', 'POST', $body);
        $this->xmlReader->read($response);
        $this->headers['Session'] = $this->xmlReader->getContent()['data'];
        return $this;
    }

    public function getNotInspectedRolls(int $daysBack = 1): RollCollection
    {
        $response = $this->sendRequest("Data/Export/GetNotInspectedRolls/{$daysBack}");
        $this->saveRequestIfConfigured($response);
        return $this->rollCreator->__invoke(
            data: $this->xmlReader->read($response),
            status: RollStatus::NOT_INSPECTED
        );
    }

    public function getInProgressRolls(int $daysBack = 1): RollCollection
    {
        $response = $this->sendRequest("Data/Export/GetInProgressRolls/{$daysBack}");
        $this->saveRequestIfConfigured($response);
        return $this->rollCreator->__invoke(
            data: $this->xmlReader->read($response),
            status: RollStatus::IN_PROGRESS
        );
    }

    public function getFinalizedRolls(int $daysBack = 1): RollCollection
    {
        $response = $this->sendRequest("Data/Export/GetFinalizedRolls/{$daysBack}");
        $this->saveRequestIfConfigured($response);
        return $this->rollCreator->__invoke(
            data: $this->xmlReader->read($response),
            status: RollStatus::FINALIZED
        );
    }

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
            pouches: $this->pouchCreator->__invoke($arrayContent),
            status: RollStatus::FINALIZED->value
        );
        return $roll->setPouches(
            $this->saveImageIfConfigured($roll->getPouches())
        );
    }

    private function saveRequestIfConfigured(string $request):void
    {
        if ($this->storage->isStorageRequest()) {
            $filename = sprintf(
                '%s/request-%s.xml',
                $this->storage->getStorageDirectory(),
                date('Y-m-d_H-i-s')
            );
            try {
                Storage::disk($this->storage->getStorageDisk())->put($filename, $request);
            } catch (Exception $exception) {
                throw new FailedSaveFileException($filename);
            }
        }
    }

    private function saveImageIfConfigured(?PouchCollection $pouches): ?PouchCollection
    {
        if (is_null($pouches)) {
            return null;
        }
        if ($this->storage->isDownloadImages()) {
            $editPuches = new PouchCollectionDto;
            foreach ($pouches as $pouch) {
                try {
                    $image = $pouch->getPouchImageUrl();
                    $imageFile = file_get_contents($image);
                    $extension = pathinfo($image, PATHINFO_EXTENSION);
                    $filename = sprintf('image-%s.%s', date('Y-m-d_H-i-s'), $extension);
                    $filepath = sprintf('%s/%s', $this->storage->getDownloadImageDirectory(), $filename);
                    Storage::disk($this->storage->getStorageDisk())->put($filepath, $imageFile);
                    $editPuches->push($pouch->setPouchImageUrl($filepath));
                } catch (Exception $e) {
                    $editPuches->push($pouch);
                }
            }
            return $editPuches;
        }
        return null;
    }

    /** @throws GuzzleException */
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

    private function url($uri = ''): string
    {
        $port = !in_array($this->connection->getPort(), [80, 443]) ? ':' . $this->connection->getPort() : '';
        $protocol  = $this->connection->getProtocol();
        $host = $this->connection->getHostname();
        return "{$protocol}://{$host}{$port}/{$uri}";
    }

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
