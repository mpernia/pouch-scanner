<?php

namespace PouchScanner\Application\Services;

use DateTime;
use Exception;
use PouchScanner\Infrastructure\Facades\PouchScanner;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\RepairCollection;

/**
 * Use this class to create a collection of Pouches.
 * The structure of the one Pouch is:
 * @property  string|null $pouchId
 * @property bool $secondValidation
 * @property string|null $secondValidationBy
 * @property string|null $checkedBy
 * @property DateTime|null $checkedDateTime
 * @property string|null $pouchImageUrl
 * @property string|null $productionBox
 * @property DateTime|null $doseTime
 * @property string|null $visionState
 * @property string|null $visionMessage
 * @property RepairCollection|null $repairs
 * @property PillCollection|null $pills 
 */
class PouchCreator
{
    /**
     * @param array $data
     * @return PouchCollection
     * @throws \Exception
     */
    public function __invoke(array $data): PouchCollection
    {
        $pouches = $data['pouches']['pouch'];
        $pouchCollection = PouchScanner::pouchCollection();
        foreach ($pouches as $pouch) {
            $repairs = count($pouch['repairs']) > 0 ? $this->getRepairCollection($pouch['repairs']) : null;
            $pills = count($pouch['pills']) > 0 ? $this->getPillCollection($pouch['pills']) : null;
            $pouchDto = PouchScanner::pouch(
                pouchId: $pouch['pouchId'],
                secondValidation: $pouch['secondValidation'],
                secondValidationBy:$pouch['secondValidationBy'],
                checkedBy: $pouch['checkedBy'],
                checkedDateTime: is_string($pouch['checkedDateTime']) ? new DateTime($pouch['checkedDateTime']) : null,
                pouchImageUrl: $pouch['pouchImageUrl'],
                productionBox: $pouch['productionBox'],
                doseTime: is_string($pouch['doseTime']) ? new DateTime($pouch['doseTime']) : null,
                visionState: $pouch['visionState'],
                visionMessage: $pouch['visionMessage'],
                repairs: $repairs,
                pills: $pills
            );
            $pouchCollection->push($pouchDto);
        }
        return $pouchCollection;
    }

    /**
     * @param array $data
     * @return object
     */
    public function attributes(array $data): object
    {
        return (object)$data['pouches']['@attributes'];
    }

    /**
     * @param array $data
     * @return RepairCollection
     * @throws Exception
     */
    private function getRepairCollection(array $data): RepairCollection
    {
        $repairCollection = PouchScanner::repairCollection();
        foreach ($data as $repair) {
            $repairCollection->push(
                PouchScanner::repair(
                    comment: $repair['comment'],
                    repair: $repair['repair'],
                    user: $repair['user'],
                    dateTime: is_string($repair['dateTime']) ? new DateTime($repair['dateTime']) : null,
                )
            );
        }
        return $repairCollection;
    }

    /**
     * @param array $data
     * @return PillCollection
     */
    private function getPillCollection(array $data): PillCollection
    {
        $pillCollection = PouchScanner::pillCollection();
        foreach ($data as $pill) {
            $pillCollection->push(
                PouchScanner::pill(
                    medicationId: $pill['medicationId'],
                    amount: (int)$pill['amount'],
                    description: $pill['description'],
                    detected: (bool)$pill['detected'],
                    image: is_string($pill['image'],) ? $pill['image'] : null
                )
            );
        }
        return $pillCollection;
    }
}
