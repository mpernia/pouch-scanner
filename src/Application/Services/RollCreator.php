<?php

namespace PouchScanner\Application\Services;

use PouchScanner\Application\DataTransferObjects\RollCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollDto;
use PouchScanner\Domain\Contracts\RollCollection;

class RollCreator
{
    public function __invoke(array $data): ?RollCollection
    {
        if(!isset($data['data']['patientRoll'])){
            $rollCollection = new RollCollectionDto;
            return $rollCollection;
        }
        $rolls = $data['data']['patientRoll'];
        $rollCollection = new RollCollectionDto;
        foreach ($rolls as $roll) {
            $rollCollection->push(
                New RollDto(
                    patientRoll: $roll['id'],
                    batchId: $roll['batchId'],
                    patientId: $roll['patientId']
                )
            );
        }
        return $rollCollection;
    }
}
