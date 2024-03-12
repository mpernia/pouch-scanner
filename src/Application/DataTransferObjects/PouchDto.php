<?php

namespace PouchScanner\Application\DataTransferObjects;

use DateTime;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\Pouch;
use PouchScanner\Domain\Contracts\RepairCollection;

class PouchDto implements Pouch
{
    public function __construct(
        private readonly ?string $pouchId = null,
        private readonly bool $secondValidation = false,
        private readonly ?string $secondValidationBy = null,
        private readonly ?string $checkedBy = null,
        private readonly ?DateTime $checkedDateTime = null,
        private ?string $pouchImageUrl = null,
        private readonly ?string $productionBox = null,
        private readonly ?DateTime $doseTime = null,
        private readonly ?string $visionState = null,
        private readonly ?string $visionMessage = null,
        private readonly ?RepairCollection $repairs = null,
        private readonly ?PillCollection $pills = null
    )
    {
    }

    public function getPouchId(): ?string
    {
        return $this->pouchId ?? null;
    }

    public function getSecondValidation(): bool
    {
        return $this->secondValidation;
    }

    public function getSecondValidationBy(): ?string
    {
        return $this->secondValidationBy ?? null;
    }

    public function getCheckedBy(): ?string
    {
        return $this->checkedBy ?? null;
    }

    public function getCheckedDateTime(): ?DateTime
    {
        return $this->checkedDateTime ?? null;
    }

    public function getPouchImageUrl(): ?string
    {
        return $this->pouchImageUrl ?? null;
    }

    public function setPouchImageUrl(?string $pouchImageUrl): static
    {
        $this->pouchImageUrl = $pouchImageUrl;
        return $this;
    }

    public function getProductionBox(): ?string
    {
        return $this->productionBox ?? null;
    }

    public function getDoseTime(): ?DateTime
    {
        return $this->doseTime ?? null;
    }

    public function getVisionState(): ?string
    {
        return $this->visionState ?? null;
    }

    public function getVisionMessage(): ?string
    {
        return $this->visionMessage ?? null;
    }

    public function getRepairs(): ?RepairCollection
    {
        return $this->repairs;
    }

    public function getPills(): ?PillCollection
    {
        return $this->pills;
    }
}
