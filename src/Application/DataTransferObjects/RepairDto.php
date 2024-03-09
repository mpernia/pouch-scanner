<?php

namespace PouchScanner\Application\DataTransferObjects;

use DateTime;
use PouchScanner\Domain\Contracts\Repair;

class RepairDto implements Repair
{
    public function __construct(
        private readonly ?string $comment = null,
        private readonly ?string $repair = null,
        private readonly ?string $user = null,
        private readonly ?DateTime $dateTime = null
    )
    {
    }

    public function getComment(): ?string
    {
        return $this->comment ?? null;
    }

    public function getRepair(): ?string
    {
        return $this->repair ?? null;
    }

    public function getUser(): ?string
    {
        return $this->user ?? null;
    }

    public function getDateTime(): ?DateTime
    {
        return $this->dateTime ?? null;
    }
}
