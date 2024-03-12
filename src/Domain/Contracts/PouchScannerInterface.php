<?php

namespace PouchScanner\Domain\Contracts;

use PouchScanner\Domain\Connection;
use PouchScanner\Domain\RollStatus;
use PouchScanner\Domain\StorageSetting;
use DateTime;

interface PouchScannerInterface
{
    /**
     * @param Roll ...$rolls
     * @return RollCollection
     */
    public function rollCollection(...$rolls): RollCollection;

    /**
     * @param Pouch ...$pouches
     * @return PouchCollection
     */
    public function pouchCollection(...$pouches): PouchCollection;

    /**
     * @param Pill ...$pills
     * @return PillCollection
     */
    public function pillCollection(...$pills): PillCollection;

    /**
     * @param Repair ...$repairs
     * @return RepairCollection
     */
    public function repairCollection(...$repairs): RepairCollection;

    /**
     * @param string|null $patientRoll
     * @param string|null $batchId
     * @param string|null $patientId
     * @param string|null $status
     * @param PouchCollection|null $pouches
     * @return Roll
     */
    public function roll(
        ?string $patientRoll = null,
        ?string $batchId = null,
        ?string $patientId = null,
        ?string $status = null,
        ?PouchCollection $pouches = null
    ): Roll;


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
     * @return Pouch
     */
    public function pouch(
        ?string $pouchId = null,
        bool $secondValidation = false,
        ?string $secondValidationBy = null,
        ?string $checkedBy = null,
        ?DateTime $checkedDateTime = null,
        ?string $pouchImageUrl = null,
        ?string $productionBox = null,
        ?DateTime $doseTime = null,
        ?string $visionState = null,
        ?string $visionMessage = null,
        ?RepairCollection $repairs = null,
        ?PillCollection $pills = null
    ): Pouch;

    /**
     * @param string|null $comment
     * @param string|null $repair
     * @param string|null $user
     * @param DateTime|null $dateTime
     * @return Repair
     */
    public function repair(
        ?string $comment = null,
        ?string $repair = null,
        ?string $user = null,
        ?DateTime $dateTime = null
    ): Repair;

    /**
     * @param string|null $medicationId
     * @param int|null $amount
     * @param string|null $description
     * @param bool $detected
     * @param string|null $image
     * @return Pill
     */
    public function pill(
        ?string $medicationId = null,
        ?int $amount = null,
        ?string $description = null,
        bool $detected = false,
        ?string $image = null
    ): Pill;


    /**
     * another description here
     * @param Connection|null $connection
     * @param StorageSetting|null $storage
     * @return PouchScannerInterface
     */
    public function configure(?Connection $connection = null, ?StorageSetting $storage = null): PouchScannerInterface;

    /**
     * @return PouchScannerInterface
     */
    public function login(): PouchScannerInterface;

    /**
     * @param int $daysBack
     * @return RollCollection
     */
    public function getNotInspectedRolls(int $daysBack = 1): RollCollection;

    /**
     * @param int $daysBack
     * @return RollCollection
     */
    public function getInProgressRolls(int $daysBack = 1): RollCollection;

    /**
     * @param int $daysBack
     * @return RollCollection
     */
    public function getFinalizedRolls(int $daysBack = 1): RollCollection;

    /**
     * @param int|string $rollId
     * @return Roll
     */
    public function getRoll(int|string $rollId): Roll;
}
