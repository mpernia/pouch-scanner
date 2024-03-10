<?php

namespace PouchScanner\Domain\Contracts;

use DateTime;

interface Pouch
{
    /**
     * @return string|null
     */
    public function getPouchId(): ?string;

    /**
     * @return bool
     */
    public function getSecondValidation(): bool;

    /**
     * @return string|null
     */
    public function getSecondValidationBy(): ?string;

    /**
     * @return string|null
     */
    public function getCheckedBy(): ?string;

    /**
     * @return DateTime|null
     */
    public function getCheckedDateTime(): ?DateTime;

    /**
     * @return string|null
     */
    public function getPouchImageUrl(): ?string;

    /**
     * @return string|null
     */
    public function getProductionBox(): ?string;

    /**
     * @return DateTime|null
     */
    public function getDoseTime(): ?DateTime;

    /**
     * @return string|null
     */
    public function getVisionState(): ?string;

    /**
     * @return string|null
     */
    public function getVisionMessage(): ?string;

    /**
     * @return PillCollection
     */
    public function getPills(): PillCollection;

    /**
     * @return RepairCollection
     */
    public function getRepairs(): RepairCollection;
}
