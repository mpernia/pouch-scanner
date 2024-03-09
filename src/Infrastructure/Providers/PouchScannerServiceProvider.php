<?php

namespace PouchScanner\Infrastructure\Providers;

use PouchScanner\Application\DataTransferObjects;
use PouchScanner\Application\Services\PouchScanner;
use PouchScanner\Domain\Contracts;
use Illuminate\Support\ServiceProvider;

class PouchScannerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('PouchScanner', function () {
            return new PouchScanner;
        });
        $this->app->bind(Contracts\PouchScannerInterface::class, function () {
            return new PouchScanner;
        });
        $this->app->bind(Contracts\RollCollection::class, function () {
            return new DataTransferObjects\RollCollectionDto;
        });
        $this->app->bind(Contracts\PouchCollection::class, function () {
            return new DataTransferObjects\PouchCollectionDto;
        });
        $this->app->bind(Contracts\RepairCollection::class, function () {
            return new DataTransferObjects\RepairCollectionDto;
        });
        $this->app->bind(Contracts\PillCollection::class, function () {
            return new DataTransferObjects\PillCollectionDto;
        });
        $this->app->bind(Contracts\Roll::class, function () {
            return new DataTransferObjects\RollDto;
        });
        $this->app->bind(Contracts\Pouch::class, function () {
            return new DataTransferObjects\PouchDto;
        });
        $this->app->bind(Contracts\Repair::class, function () {
            return new DataTransferObjects\RepairDto;
        });
        $this->app->bind(Contracts\Pill::class, function () {
            return new DataTransferObjects\PillDto;
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
            Contracts\Roll::class,
            'ROLL',
        ];
    }
}
