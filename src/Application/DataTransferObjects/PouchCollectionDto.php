<?php

namespace PouchScanner\Application\DataTransferObjects;

use PouchScanner\Domain\Contracts\Pouch;
use PouchScanner\Domain\Contracts\PouchCollection;
use Illuminate\Support\Collection;

class PouchCollectionDto extends Collection implements PouchCollection
{
    /**
     * @param Pouch[] $items
     * @param string|null $batchId
     * @param string|null $patientId
     */
    public function __construct(
        array $items = [],
        private ?string $patientRollId = null,
        private ?string $batchId = null,
        private ?string $patientId = null
    )
    {
        parent::__construct($items);
    }

    public function getPatientRollId(): ?string
    {
        return $this->patientRollId ?? null;
    }

    public function setPatientRollId(?string $patientRollId): PouchCollection
    {
        $this->patientRollId = $patientRollId;
        return $this;
    }

    public function getBatchId(): ?string
    {
        return $this->batchId ?? null;
    }

    public function setBatchId(string $batchId): PouchCollection
    {
        $this->batchId = $batchId;
        return $this;
    }

    public function getPatientId(): ?string
    {
        return $this->patientId ?? null;
    }

    public function setPatientId(string $patientId): PouchCollection
    {
        $this->patientId = $patientId;
        return $this;
    }

    /**
     * @param Pouch ...$pouches
     * @return void
     */
    public function push(...$pouches): void
    {
        foreach ($pouches as $pouch) {
            if (!$pouch instanceof Pouch) {
                throw new \InvalidArgumentException('Only instances of Pouch can be added to PouchCollection.');
            }
            parent::push($pouch);
        }
    }
}
