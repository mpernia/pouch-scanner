<?php

namespace PouchScanner\Infrastructure\Facades;

use DateTime;
use Illuminate\Support\Facades\Facade;
use PouchScanner\Domain\Connection;
use PouchScanner\Domain\Contracts\Pill;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\Pouch;
use PouchScanner\Domain\Contracts\Repair;
use PouchScanner\Domain\Contracts\RepairCollection;
use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\PouchScannerInterface;
use PouchScanner\Domain\RollStatus;
use PouchScanner\Domain\StorageSetting;

/**
 * PouchScanner Facade methods description:
 * @method static RollCollection rollCollection(Roll ...$rolls)
 * @method static PouchCollection pouchCollection(Pouch...$pouchs)
 * @method static PillCollection pillCollection(Pill...$pills)
 * @method static RepairCollection repairCollection(Repair...$repairs)
 * @method static Roll roll(?string $patientRoll = null, ?string $batchId = null, ?string $patientId = null, ?string $status = null, ?PouchCollection $pouches = null)
 * @method static Pouch pouch(?string $pouchId = null, bool $secondValidation = false, ?string $secondValidationBy = null, ?string $checkedBy = null, ?DateTime $checkedDateTime = null, ?string $pouchImageUrl = null, ?string $productionBox = null, ?DateTime $doseTime = null, ?string $visionState = null, ?string $visionMessage = null, ?RepairCollection $repairs = null, ?PillCollection $pills = null)
 * @method static Repair repair(?string $comment = null, ?string $repair = null, ?string $user = null, ?DateTime $dateTime = null)
 * @method static Pill pill(?string $medicationId = null, ?int $amount = null, ?string $description = null, bool $detected = false, ?string $image = null)
 * @method static PouchScannerInterface configure(?Connection $configuration = null, ?StorageSetting $storage = null)
 * @method static PouchScannerInterface login()
 * @method static RollCollection getNotInspectedRolls(int $daysBack = 1)
 * @method static RollCollection getInProgressRolls(int $daysBack = 1);
 * @method static RollCollection getFinalizedRolls(int $daysBack = 1);
 * @method static PouchCollection getRoll(int|string $rollId);
 *
 * @example  You can call any of these methods in your application like this example:
 * PouchScanner::getRoll(rollId: $rollId);
 */
class PouchScanner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'PouchScanner';
    }
}
