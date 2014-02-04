<?php

namespace Mote\EmailTemplater\Finder;

use Mote\EmailTemplater\Template;

/**
 * Class for "finding" JSON formatted templates.
 *
 * It contains two extra features:
 *
 * 1) It contains the extra feature of substituting "{PATH}" in all fields with the
 * directory where the JSON template was found, on condition that there is a key
 * "pathsubstitution" in the JSON template. The directory will not include a
 * tailing slash.
 *
 * <example>
 * {
 *     "pathSubstitution": "1",
 *     "subject": "{PATH}",
 *     // ...
 * }
 * </example>
 *
 * This is mainly used by the {@see \Mote\EmailTemplater\Processor\PhpFiles} processor.
 *
 * 2) It contains the feature of resolving "@include X" values inside a field
 * by loading the contents of file "X". If a field begins with "@include ", it
 * must be escaped like "\@include blah". (This is true if "@include" has a
 * trailing space. "@includeTest", for example, needn't be escaped.)
 */
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
        // TODO: Should throw exceptions instead of returning null, I think.
        // TODO: InvalidTemplateException
        try {
            $msgFile = $this->templatePath($templateName);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
        $jsonString = @file_get_contents($msgFile);
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
        try {
            return new Template($data['type'], $data['encoding'],
                $this->includeResolver($data['subject']),
                $hasText ? $this->includeResolver($data['textBody']) : null,
                $hasHtml ? $this->includeResolver($data['htmlBody']) : null
            );
        } catch (\RuntimeException $e) {
            return null; // Should throw exception, according to above TODO
        }
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

    private function includeResolver($field)
    {
        $pos = strpos($field, '@include ');
        if ($pos === 1 && $field[0] === '\\') { // If starts with "\@include ", return same string without the escape "\"
            return substr($field, 1);
        }
        if ($pos !== 0) {
            return $field;
        }
        $path = substr($field, 9);
        $content = @file_get_contents($path);
        if ($content === false) {
            throw new \RuntimeException();
        }
        return $content;
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
