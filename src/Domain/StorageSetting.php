<?php

namespace PouchScanner\Domain;

/** Define the storage values */
class StorageSetting
{
    /**
     * @param string|null $storageDirectory The directory name to save all raw requests
     * @param string|null $downloadImageDirectory The directory name to save all images
     * @param string|null $storageDisk The disk to save all, example: local
     * @param bool $storageRequest If true, the requests will be saved
     * @param bool $downloadImages If true, the images will be saved
     */
    public function __construct(
        private readonly ?string $storageDirectory,
        private readonly ?string $downloadImageDirectory,
        private readonly ?string $storageDisk = 'local',
        private readonly bool $storageRequest = false,
        private readonly bool $downloadImages = false
    )
    {
    }

    /**
     * @return string|null
     */
    public function getStorageDirectory(): ?string
    {
        return $this->storageDirectory ?? null;
    }

    /**
     * @return string|null
     */
    public function getDownloadImageDirectory(): ?string
    {
        return $this->downloadImageDirectory ?? null;
    }

    /**
     * @return string|null
     */
    public function getStorageDisk(): ?string
    {
        return $this->storageDisk ?? null;
    }

    /**
     * @return bool
     */
    public function isStorageRequest(): bool
    {
        return $this->storageRequest;
    }

    /**
     * @return bool
     */
    public function isDownloadImages(): bool
    {
        return $this->downloadImages;
    }
}
