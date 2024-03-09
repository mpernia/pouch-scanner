<?php

namespace PouchScanner\Domain\Contracts;

interface Pill
{
    public function getMedicationId(): ?string;

    public function getAmount(): ?int;

    public function getDescription(): ?string;

    public function isDetected(): bool;

    public function getImage(): ?string;
}
