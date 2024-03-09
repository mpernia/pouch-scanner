<?php

namespace PouchScanner\Domain\Contracts;

interface RollCollection
{
    /**
     * @param Roll ...$rolls
     * @return void
     */
    public function push(...$rolls): void;
}
