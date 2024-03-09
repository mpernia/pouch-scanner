<?php

namespace PouchScanner\Application\Services;

use DateTime;
use PouchScanner\Application\DataTransferObjects\PillCollectionDto;
use PouchScanner\Application\DataTransferObjects\PillDto;
use PouchScanner\Application\DataTransferObjects\PouchCollectionDto;
use PouchScanner\Application\DataTransferObjects\PouchDto;
use PouchScanner\Application\DataTransferObjects\RepairCollectionDto;
use PouchScanner\Application\DataTransferObjects\RepairDto;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\RepairCollection;

class PouchCreator
{
    public function __invoke(array $data): PouchCollection
    {
        $pouches = $data['pouches']['pouch'];
        $puchCollection = new PouchCollectionDto();
        foreach ($pouches as $pouch) {
            $repairs = count($pouch['repairs']) > 0 ? $this->getRepairCollection($pouch['repairs']) : null;
            $pills = count($pouch['pills']) > 0 ? $this->getPillCollection($pouch['pills']) : null;
            $pouchDto = new PouchDto(
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
            $puchCollection->push($pouchDto);
        }
        return $puchCollection;
    }

    public function attributes(array $data): object
    {
        return (object)$data['pouches']['@attributes'];
    }

    private function getRepairCollection(array $data): RepairCollection
    {
        $repairCollection = new RepairCollectionDto;
        foreach ($data as $repair) {
            $repairCollection->push(
                new RepairDto(
                    comment: $data['repair']['comment'],
                    repair: $data['repair']['repair'],
                    user: $data['repair']['user'],
                    dateTime: is_string($data['repair']['dateTime']) ? new DateTime($data['repair']['dateTime']) : null,
                )
            );
        }
        return $repairCollection;
    }

    private function getPillCollection(array $data): PillCollection
    {
        $pillCollection = new PillCollectionDto;
        foreach ($data as $pill) {
            $pillCollection->push(
                new PillDto(
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
