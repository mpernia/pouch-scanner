<?php

namespace PouchScanner\Infrastructure\Providers;

use PouchScanner\Application\DataTransferObjects\RollCollectionDto;
use PouchScanner\Application\DataTransferObjects\PouchCollectionDto;
use PouchScanner\Application\DataTransferObjects\RepairCollectionDto;
use PouchScanner\Application\DataTransferObjects\PillCollectionDto;
use PouchScanner\Application\DataTransferObjects\RollDto;
use PouchScanner\Application\DataTransferObjects\PouchDto;
use PouchScanner\Application\DataTransferObjects\RepairDto;
use PouchScanner\Application\DataTransferObjects\PillDto;
use PouchScanner\Application\Services\PouchScanner;
use PouchScanner\Domain\Contracts\PouchScannerInterface;
use PouchScanner\Domain\Contracts\RollCollection;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Contracts\RepairCollection;
use PouchScanner\Domain\Contracts\PillCollection;
use PouchScanner\Domain\Contracts\Roll;
use PouchScanner\Domain\Contracts\Pouch;
use PouchScanner\Domain\Contracts\Repair;
use PouchScanner\Domain\Contracts\Pill;
use Illuminate\Support\ServiceProvider;

class PouchScannerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('PouchScanner', function () {
            return new PouchScanner;
        });
        $this->app->bind(PouchScannerInterface::class, function () : PouchScanner {
            return new PouchScanner;
        });
        $this->app->bind(RollCollection::class, function () : RollCollectionDto {
            return new RollCollectionDto;
        });
        $this->app->bind(PouchCollection::class, function () : PouchCollectionDto {
            return new PouchCollectionDto;
        });
        $this->app->bind(RepairCollection::class, function () : RepairCollectionDto {
            return new RepairCollectionDto;
        });
        $this->app->bind(PillCollection::class, function () : PillCollectionDto {
            return new PillCollectionDto;
        });
        $this->app->bind(Roll::class, function () : RollDto {
            return new RollDto;
        });
        $this->app->bind(Pouch::class, function () : PouchDto {
            return new PouchDto;
        });
        $this->app->bind(Repair::class, function () : RepairDto {
            return new RepairDto;
        });
        $this->app->bind(Pill::class, function () : PillDto {
            return new PillDto;
        });
    }
    public function boot(): void
    {
        $configPath = __DIR__ . '/../Config/pouch-scanner.php';
        $this->publishes([$configPath => config_path('pouch-scanner.php')], 'pouch-scanner-config');
        $this->mergeConfigFrom($configPath, 'pouch-scanner');
    }

    public function provides(): array
    {
        return [
            PouchScanner::class,
            'PouchScanner',
        ];
    }
}
