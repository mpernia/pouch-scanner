<?php

namespace PouchScanner\Domain\Contracts;

interface PouchCollection
{
    /**
     * @return string|null
     */
    public function getPatientRollId(): ?string;

    /**
     * @param string|null $patientRollId
     * @return PouchCollection
     */
    public function setPatientRollId(?string $patientRollId): PouchCollection;

    /**
     * @return string|null
     */
    public function getBatchId(): ?string;

    /**
     * @param string $batchId
     * @return PouchCollection
     */
    public function setBatchId(string $batchId): PouchCollection;

    /**
     * @return string|null
     */
    public function getPatientId(): ?string;

    /**
     * @param string $patientId
     * @return PouchCollection
     */
    public function setPatientId(string $patientId): PouchCollection;

    /**
     * @param Pouch ...$pouches
     * @return void
     */
    public function push(...$pouches): void;
}
