<?php

namespace Mote\EmailTemplater;

use Mote\EmailTemplater\ConverterToType\ConverterToTypeInterface;

class EmailConverter
{
    const DEFAULT_TYPE = null;

    /** @var ConverterToTypeInterface[] */
    private $converters;

    /** @var string|null */
    private $defaultType;

    /**
     * @param ConverterToTypeInterface[] $toTypeConverters
     * @param string|null $defaultType
     */
    public function __construct(array $toTypeConverters, $defaultType = null)
    {
        $this->converters = $toTypeConverters;
        $this->defaultType = $defaultType;
    }

    /**
     * @param Email $email
     * @param string $toType
     * @return mixed An email representation {@see ConverterToTypeInterface::convert}
     *
     * @throws MissingConverterForTypeException
     * @throws MissingDefaultTypeException
     */
    public function convert(Email $email, $toType = self::DEFAULT_TYPE)
    {
        $toType = $this->typeWithDefault($toType);
        if (!isset($this->converters[$toType])) {
            throw new MissingConverterForTypeException($toType);
        }
        $converter = $this->converters[$toType];
        return $converter->convert($email);
    }

    private function typeWithDefault($toType)
    {
        if ($toType !== self::DEFAULT_TYPE) {
            return $toType;
        }
        if ($this->defaultType === null) {
            throw new MissingDefaultTypeException();
        }
        return $this->defaultType;
    }
}
