<?php

namespace PouchScanner\Application\Services;

use PouchScanner\Application\DataTransferObjects\RollCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollDto;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\RollStatus;

/**
 * Use this class to create a Roll.
 * The structure of this class is:
 * @property  string|null $patientRoll
 * @property string|null $batchId
 * @property string|null $patientId
 * @property string $status
 * @property PouchCollection|null $pouches
 */
class RollCreator
{
    /**
     * @param array $data
     * @param RollStatus $status
     * @return RollCollection
     */
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
