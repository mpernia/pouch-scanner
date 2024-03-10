<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Pill;

class PillDto implements Pill
{
    /**
     * @param string|null $medicationId
     * @param int|null $amount
     * @param string|null $description
     * @param bool $detected
     * @param string|null $image
     */
    public function __construct(
        private readonly ?string $medicationId = null,
        private readonly ?int $amount = null,
        private readonly ?string $description = null,
        private readonly bool $detected = false,
        private readonly ?string $image = null
    )
    {

    }

    /**
     * @return string|null
     */
    public function getMedicationId(): ?string
    {
        return $this->medicationId ?? null;
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount ?? null;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description ?? null;
    }

    /**
     * @return bool
     */
    public function isDetected(): bool
    {
        return $this->detected;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image ?? null;
    }
}
