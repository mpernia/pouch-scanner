<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\RollStatus;

class RollDto implements Roll
{
    private PouchCollection $pouches;

    /**
     * @param string|null $patientRoll
     * @param string|null $batchId
     * @param string|null $patientId
     * @param string $status
     * @param PouchCollection|null $pouches
     */
    public function __construct(
        private readonly ?string $patientRoll = null,
        private readonly ?string $batchId = null,
        private readonly ?string $patientId = null,
        private string $status = RollStatus::NOT_INSPECTED->value,
        ?PouchCollection $pouches = null
    )
    {
        $this->pouches = $pouches ?? new PouchCollectionDto;
    }

    /**
     * @return string|null
     */
    public function getPatientRoll(): ?string
    {
        return $this->patientRoll ?? null;
    }

    /**
     * @return string|null
     */
    public function getBatchId(): ?string
    {
        return $this->batchId ?? null;
    }

    /**
     * @return string|null
     */
    public function getPatientId(): ?string
    {
        return $this->patientId ?? null;
    }

    /**
     * @return PouchCollection
     */
    public function getPouches(): PouchCollection
    {
        return $this->pouches;
    }

    /**
     * @param PouchCollection $pouches
     * @return $this
     */
    public function setPouches(PouchCollection $pouches): static
    {
        $this->pouches = $pouches;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }
}
