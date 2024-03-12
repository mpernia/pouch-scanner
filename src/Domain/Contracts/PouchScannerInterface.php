<?php

namespace PouchScanner\Domain\Contracts;

use PouchScanner\Domain\Connection;
use PouchScanner\Domain\StorageSetting;

interface PouchScannerInterface
{
    /**
     * another description here
     * @param string $text
     * @return void
     */
    public function configure(?Connection $connection = null, ?StorageSetting $storage = null): PouchScannerInterface;
    public function login(): PouchScannerInterface;
    public function getNotInspectedRolls(int $daysBack = 1);

    public function getInProgressRolls(int $daysBack = 1);

    public function getFinalizedRolls(int $daysBack = 1);

    public function getRoll(int|string $rollId);
}
