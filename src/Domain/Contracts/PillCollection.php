<?php

namespace PouchScanner\Domain\Contracts;

interface PillCollection
{
    /**
     * @param Pill ...$pills
     * @return void
     */
    public function push(...$pills): void;
}
