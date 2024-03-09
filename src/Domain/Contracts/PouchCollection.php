<?php

namespace PouchScanner\Domain\Contracts;

interface PouchCollection
{
    public function getPatientRollId(): ?string;

    public function setPatientRollId(?string $patientRollId): PouchCollection;

    public function getBatchId(): ?string;

    public function setBatchId(string $batchId): PouchCollection;

    public function getPatientId(): ?string;

    public function setPatientId(string $patientId): PouchCollection;

    /**
     * @param Pouch ...$pouches
     * @return void
     */
    public function push(...$pouches): void;
}
