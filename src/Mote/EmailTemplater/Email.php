<?php

namespace Mote\EmailTemplater;

class Email
{
    /** @var EmailConverter */
    private $converter;

    public function __construct(EmailConverter $converter)
    {
        $this->converter = $converter;
        // TODO: Implement
    }

    /**
     * @param string|EmailConverter::DEFAULT_TYPE $toType
     * @return mixed An email representation {@see ConverterToTypeInterface::convert}
     *
     * @throws MissingConverterForTypeException
     * @throws MissingDefaultTypeException
     */
    public function convert($toType = EmailConverter::DEFAULT_TYPE)
    {
        return $this->converter->convert($this, $toType);
    }

    // TODO: Implement getters--is immutable
}
