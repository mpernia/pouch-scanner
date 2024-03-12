<?php

namespace PouchScanner\Application\Services;

use Exception;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Exceptions\FailedOpenFileException;
use PouchScanner\Domain\Exceptions\InvalidFileFormatException;

class XmlReader
{
    protected array $xmlArrayContent;

    public function read(string $xmlContent): array
    {
        try {
            $xmlContent = $this->stripTags($xmlContent);
            $xmlContent = simplexml_load_string($xmlContent);
        } catch (Exception $exception) {
            throw new InvalidFileFormatException;
        }
        $this->xmlArrayContent = json_decode(
            json: json_encode($xmlContent),
            associative: true
        );
        return $this->xmlArrayContent;
    }

    public function getContent(): array
    {
        return $this->xmlArrayContent;
    }

    protected function stripTags(string $content): string
    {
        return preg_replace_callback(
            pattern: '/(<|<\/|\s)([a-zA-Z])/',
            callback: function($tags) { return $tags[1] . strtolower($tags[2]);},
            subject: $content
        );
    }

    public function attributes(): object
    {
        return (object)$this->xmlArrayContent['pouches']['@attributes'];
    }
    public function pouches(): array
    {
        $pouches = [];
        foreach ($this->xmlArrayContent['pouches']['pouch'] as $pouche) {
            $pouches[] = (object)$pouche;
        }
        return $pouches;
    }
}
