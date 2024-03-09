<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Repair;
use PouchScanner\Domain\Contracts\RepairCollection;
use Illuminate\Support\Collection;

class RepairCollectionDto extends Collection implements RepairCollection
{
    /**
     * @param Repair[] $repairs
     */
    public function __construct($repairs = [])
    {
        parent::__construct($repairs);
    }

    /**
     * @param Repair ...$repairs
     * @return void
     */
    public function push(...$repairs): void
    {
        foreach ($repairs as $repair) {
            if (!$repair instanceof Repair) {
                throw new \InvalidArgumentException('Only instances of Pouch can be added to RepairCollection.');
            }
            parent::push($repair);
        }
    }
}
