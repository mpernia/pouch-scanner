<?php

namespace PouchScanner\Domain\Contracts;

interface Roll
{
    public function getPatientRoll(): ?string;

    public function getBatchId(): ?string;
    
    public function getPatientId(): ?string;

    public function getPouches(): ?PouchCollection;

    public function setPouches(?PouchCollection $pouches): Roll:
    
    public function getStatus(): string;
    
    public function setStatus(string $status): Roll
}
