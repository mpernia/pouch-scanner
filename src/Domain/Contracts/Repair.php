<?php

namespace PouchScanner\Domain\Contracts;

use DateTime;

interface Repair
{
    /**
     * @return string|null
     */
    public function getComment(): ?string;

    /**
     * @return string|null
     */
    public function getRepair(): ?string;

    /**
     * @return string|null
     */
    public function getUser(): ?string;

    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime;
}
