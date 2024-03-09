<?php

namespace PouchScanner\Domain\Contracts;

interface Roll
{
    public function getPatientRoll(): ?string;
    public function getBatchId(): ?string;
    public function getPatientId(): ?string;
}
