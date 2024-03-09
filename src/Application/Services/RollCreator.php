<?php

namespace PouchScanner\Application\Services;

use PouchScanner\Application\DataTransferObjects\RollCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollDto;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\RollStatus;

class RollCreator
{
    public function __invoke(array $data, RollStatus $status): RollCollection
    {
        $rolls = $data['data']['patientRoll'];
        $rollCollection = new RollCollectionDto;
        foreach ($rolls as $roll) {
            $rollCollection->push(
                New RollDto(
                    patientRoll: $roll['@attributes']['id'],
                    batchId: $roll['@attributes']['batchId'],
                    patientId: $roll['@attributes']['patientId'],
                    status: $status->value
                )
            );
        }
        return $rollCollection;
    }
}