<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Pill;

class PillDto implements Pill
{
    public function __construct(
        private readonly ?string $medicationId = null,
        private readonly ?int $amount = null,
        private readonly ?string $description = null,
        private readonly bool $detected = false,
        private readonly ?string $image = null
    )
    {

    }

    public function getMedicationId(): ?string
    {
        return $this->medicationId ?? null;
    }

    public function getAmount(): ?int
    {
        return $this->amount ?? null;
    }

    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    public function isDetected(): bool
    {
        return $this->detected;
    }

    public function getImage(): ?string
    {
        return $this->image ?? null;
    }
}
