<?php

namespace PouchScanner\Domain\Contracts;

interface Pill
{
    /**
     * @return string|null
     */
    public function getMedicationId(): ?string;

    /**
     * @return int|null
     */
    public function getAmount(): ?int;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return bool
     */
    public function isDetected(): bool;

    /**
     * @return string|null
     */
    public function getImage(): ?string;
}
