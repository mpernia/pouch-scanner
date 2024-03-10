<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\Exceptions\InvalidInstanceOfCollectionException;
use Illuminate\Support\Collection;

class RollCollectionDto extends Collection implements RollCollection
{

    /**
     * @param Roll ...$rolls
     * @return void
     */
    public function push(...$rolls): void
    {
        foreach ($rolls as $roll) {
            if (!$roll instanceof Roll) {
                throw new InvalidInstanceOfCollectionException('Only instances of Pouch can be added to RollCollection.');
            }
            parent::push($roll);
        }
    }
}
