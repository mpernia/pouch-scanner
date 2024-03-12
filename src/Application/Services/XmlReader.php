<?php

namespace PouchScanner\Application\Services;

use Exception;
use PouchScanner\Domain\Contracts\PouchCollection;
use PouchScanner\Domain\Exceptions\FailedOpenFileException;
use PouchScanner\Domain\Exceptions\InvalidFileFormatException;
use PouchScanner\Domain\Exceptions\FailedActionException;

/**
 * Use tis class to read the response of the server in XML format
 */
class XmlReader
{
    protected array $xmlArrayContent = [];

    /**
     * @param string $xmlContent
     * @return array
     * @throws FailedActionException
     * @throws InvalidFileFormatException
     */
    public function read(string $xmlContent): array
    {
        if (!$this->validateXmlFormat($xmlContent)) {
            throw new InvalidFileFormatException;
        }
        try {
            $xmlContent = $this->stripTags($xmlContent);
            $xmlContent = simplexml_load_string($xmlContent);
        } catch (Exception $exception) {
            throw new InvalidFileFormatException;
        }
        try {
            $this->xmlArrayContent = json_decode(
                json: json_encode($xmlContent),
                associative: true
            );
        } catch (Exception $exception) {
            throw new FailedActionException($exception->getMessage());
        }
        return $this->xmlArrayContent;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->xmlArrayContent;
    }

    /**
     * @param string $content
     * @return string
     */
    protected function stripTags(string $content): string
    {
        return preg_replace_callback(
            pattern: '/(<|<\/|\s)([a-zA-Z])/',
            callback: function($tags) { return $tags[1] . strtolower($tags[2]);},
            subject: $content
        );
    }

    /**
     * @param string|null $xmlContent
     * @return bool
     */
    protected function validateXmlFormat(?string $xmlContent): bool
    {
        if (!$xmlContent) { return false; }
        libxml_use_internal_errors(true);
        simplexml_load_string($xmlContent);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        return empty($errors);
    }
}
