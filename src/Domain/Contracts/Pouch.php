<?php

namespace PouchScanner\Domain\Contracts;

use DateTime;

interface Pouch
{
    public function getPouchId(): ?string;

    public function getSecondValidation(): bool;

    public function getSecondValidationBy(): ?string;

    public function getCheckedBy(): ?string;

    public function getCheckedDateTime(): ?DateTime;

    public function getPouchImageUrl(): ?string;

    public function getProductionBox(): ?string;

    public function getDoseTime(): ?DateTime;

    public function getVisionState(): ?string;

    public function getVisionMessage(): ?string;
}
