<?php

namespace PouchScanner\Domain\Contracts;

use DateTime;

interface Repair
{
    public function getComment(): ?string;

    public function getRepair(): ?string;

    public function getUser(): ?string;

    public function getDateTime(): ?DateTime;
}
