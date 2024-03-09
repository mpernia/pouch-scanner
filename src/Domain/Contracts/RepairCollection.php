<?php

namespace PouchScanner\Domain\Contracts;

interface RepairCollection
{
    /**
     * @param Repair ...$repairs
     * @return void
     */
    public function push(...$repairs): void;
}
