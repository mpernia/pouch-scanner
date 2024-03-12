<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Pill;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Exceptions\InvalidInstanceOfCollectionException;
use Illuminate\Support\Collection;

class PillCollectionDto extends Collection implements PillCollection
{
    /**
     * @param Pill[] $pills
     */
    public function __construct(array $pills = [])
    {
        parent::__construct($pills);
    }

    /**
     * @param Pill ...$pills
     * @return void
     * @throws InvalidInstanceOfCollectionException
     */
    public function push(...$pills): void
    {
        foreach ($pills as $pill) {
            if (!$pill instanceof Pill) {
                throw new InvalidInstanceOfCollectionException('Only instances of Pouch can be added to PouchCollection.');
            }
            parent::push($pill);
        }
    }
}
