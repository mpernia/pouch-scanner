<?php

namespace PouchScanner\Domain\Contracts;

interface Roll
{
    /**
     * @return string|null
     */
    public function getPatientRoll(): ?string;

    /**
     * @return string|null
     */
    public function getBatchId(): ?string;

    /**
     * @return string|null
     */
    public function getPatientId(): ?string;

    /**
     * @return PouchCollection
     */
    public function getPouches(): PouchCollection;

    /**
     * @param PouchCollection $pouches
     * @return Roll
     */
    public function setPouches(PouchCollection $pouches): Roll;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return Roll
     */
    public function setStatus(string $status): Roll;
}
