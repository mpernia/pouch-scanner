<?php

namespace PouchScanner\Application\DataTransferObjects;

use Illuminate\Support\Collection;
use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\Contracts\RollCollection;
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
                throw new \InvalidArgumentException('Only instances of Pouch can be added to RollCollection.');
            }
            parent::push($roll);
        }
    }
}
