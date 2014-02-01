<?php

namespace Mote\EmailTemplater\Finder;

use Mote\EmailTemplater\Template;

class JsonFile implements FinderInterface
{
    private static $REQUIRED_KEYS = array('type', 'encoding', 'subject');

    /** @var string */
    private $templateDirectory;

    /**
     * @param string $templateDirectory
     * @throws \InvalidArgumentException
     */
    public function __construct($templateDirectory)
    {
        $this->templateDirectory = realpath($templateDirectory);
        if (!$this->templateDirectory) {
            throw new \InvalidArgumentException(sprintf('Invalid path "%s"', $this->templateDirectory));
        }
    }

    public function find($templateName)
    {
        // TODO: InvalidTemplateException
        try {
            $msgFile = $this->templatePath($templateName);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
        if (!is_readable($msgFile)) {
            return null;
        }
        $jsonString = file_get_contents($msgFile);
        if ($jsonString === false) {
            return null;
        }
        $data = json_decode($jsonString, true);
        if ($data === null) {
            return null;
        }
        if (!$this->hasRequiredKeys($data)) {
            return null;
        }

        $hasText = isset($data['textBody']);
        $hasHtml = isset($data['htmlBody']);
        if (!$hasText && !$hasHtml) {
            return null;
        }
        // Document this path substition
        $data = $this->pathSubstitution($data, dirname($msgFile));
        return new Template($data['type'], $data['encoding'], $data['subject'],
            $hasText ? $data['textBody'] : null,
            $hasHtml ? $data['htmlBody'] : null);
    }

    private function pathSubstitution(array $data, $path)
    {
        if (!isset($data['pathSubstitution'])) {
            return $data;
        }
        return array_map(function ($value) use ($path) {
            return str_replace('{PATH}', $path, $value);
        }, $data);
    }

    private function hasRequiredKeys(array $data)
    {
        $missingKeys = array_diff(self::$REQUIRED_KEYS, array_keys($data));
        return empty($missingKeys);
    }

    private function templatePath($name)
    {
        $file = realpath(sprintf('%s/%s/message.json', $this->templateDirectory, $name));
        if (strpos($file, $this->templateDirectory) !== 0) {
            throw new \InvalidArgumentException();
        }
        return $file;
    }
}
