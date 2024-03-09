<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\Roll;

class RollDto implements Roll
{
    public function __construct(
        private readonly ?string $patientRoll = null,
        private readonly ?string $batchId = null,
        private readonly ?string $patientId = null,
        private ?PouchCollection $pouches = null,
    )
    {
    }

    public function getPatientRoll(): ?string
    {
        return $this->patientRoll ?? null;
    }

    public function getBatchId(): ?string
    {
        return $this->batchId ?? null;
    }

    public function getPatientId(): ?string
    {
        return $this->patientId ?? null;
    }

    public function getPouches(): ?PouchCollection
    {
        return $this->pouches;
    }

    public function setPouches(?PouchCollection $pouches): static
    {
        $this->pouches = $pouches;
        return $this;
    }
}
