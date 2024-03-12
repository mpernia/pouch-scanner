<?php

namespace PouchScanner\Application\DataTransferObjects;

use DateTime;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\Pouch;
use PouchScanner\Domain\Contracts\RepairCollection;

class PouchDto implements Pouch
{
    private RepairCollection $repairs;
    private PillCollection $pills;


    /**
     * @param string|null $pouchId
     * @param bool $secondValidation
     * @param string|null $secondValidationBy
     * @param string|null $checkedBy
     * @param DateTime|null $checkedDateTime
     * @param string|null $pouchImageUrl
     * @param string|null $productionBox
     * @param DateTime|null $doseTime
     * @param string|null $visionState
     * @param string|null $visionMessage
     * @param RepairCollection|null $repairs
     * @param PillCollection|null $pills
     */
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
        ?RepairCollection $repairs = null,
        ?PillCollection $pills = null
    )
    {
        $this->repairs = $repairs ?? new RepairCollectionDto;
        $this->pills = $pills ?? new PillCollectionDto;
    }

    /**
     * @return string|null
     */
    public function getPouchId(): ?string
    {
        return $this->pouchId ?? null;
    }

    /**
     * @return bool
     */
    public function getSecondValidation(): bool
    {
        return $this->secondValidation;
    }

    /**
     * @return string|null
     */
    public function getSecondValidationBy(): ?string
    {
        return $this->secondValidationBy ?? null;
    }

    /**
     * @return string|null
     */
    public function getCheckedBy(): ?string
    {
        return $this->checkedBy ?? null;
    }

    /**
     * @return DateTime|null
     */
    public function getCheckedDateTime(): ?DateTime
    {
        return $this->checkedDateTime ?? null;
    }

    /**
     * @return string|null
     */
    public function getPouchImageUrl(): ?string
    {
        return $this->pouchImageUrl ?? null;
    }

    /**
     * @param string|null $pouchImageUrl
     * @return $this
     */
    public function setPouchImageUrl(?string $pouchImageUrl): static
    {
        $this->pouchImageUrl = $pouchImageUrl;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductionBox(): ?string
    {
        return $this->productionBox ?? null;
    }

    /**
     * @return DateTime|null
     */
    public function getDoseTime(): ?DateTime
    {
        return $this->doseTime ?? null;
    }

    /**
     * @return string|null
     */
    public function getVisionState(): ?string
    {
        return $this->visionState ?? null;
    }

    /**
     * @return string|null
     */
    public function getVisionMessage(): ?string
    {
        return $this->visionMessage ?? null;
    }

    /**
     * @return RepairCollection
     */
    public function getRepairs(): RepairCollection
    {
        return $this->repairs;
    }

    /**
     * @return PillCollection
     */
    public function getPills(): PillCollection
    {
        return $this->pills;
    }
}
