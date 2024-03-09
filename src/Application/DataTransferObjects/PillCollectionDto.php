<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Pill;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\Pouch;
use Illuminate\Support\Collection;

class PillCollectionDto extends Collection implements PillCollection
{
    /**
     * @param Pill[] $pills
     */
    public function __construct($pills = [])
    {
        parent::__construct($pills);
    }

    /**
     * @param Pill ...$pills
     * @return void
     */
    public function push(...$pills): void
    {
        foreach ($pills as $pill) {
            if (!$pill instanceof Pill) {
                throw new \InvalidArgumentException('Only instances of Pouch can be added to PouchCollection.');
            }
            parent::push($pill);
        }
    }
}
