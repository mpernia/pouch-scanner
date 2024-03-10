<?php

namespace PouchScanner\Application\DataTransferObjects;

use DateTime;
use PouchScanner\Domain\Contracts\Repair;

class RepairDto implements Repair
{
    /**
     * @param string|null $comment
     * @param string|null $repair
     * @param string|null $user
     * @param DateTime|null $dateTime
     */
    public function __construct(
        private readonly ?string $comment = null,
        private readonly ?string $repair = null,
        private readonly ?string $user = null,
        private readonly ?DateTime $dateTime = null
    )
    {
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment ?? null;
    }

    /**
     * @return string|null
     */
    public function getRepair(): ?string
    {
        return $this->repair ?? null;
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user ?? null;
    }

    /**
     * @return DateTime|null
     */
    public function getDateTime(): ?DateTime
    {
        return $this->dateTime ?? null;
    }
}
