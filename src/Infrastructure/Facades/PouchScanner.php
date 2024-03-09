<?php

namespace PouchScanner\Infrastructure\Facades;

use Illuminate\Support\Facades\Facade;
use PouchScanner\Domain\Connection;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\PouchScannerInterface;
use PouchScanner\Domain\StorageSetting;

/**
 * Facade methods description
 *
 * @method static PouchScannerInterface configure(?Connection $configuration = null, ?StorageSetting $storage = null)
 * @method static PouchScannerInterface login()
 * @method static RollCollection getNotInspectedRolls(int $daysBack = 1)
 * @method static RollCollection getInProgressRolls(int $daysBack = 1);
 * @method static RollCollection getFinalizedRolls(int $daysBack = 1);
 * @method static PouchCollection getRoll(int|string $rollId);
 */
class PouchScanner extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'PouchScanner';
    }
}
