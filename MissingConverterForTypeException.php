<?php

namespace Mote\EmailTemplater;

class MissingConverterForTypeException extends \Exception
{
    /**
     * @param string $toType
     */
    public function __construct($toType)
    {
        parent::__construct(sprinf('Missing coverter for type "%s"', $toType));
    }
}
