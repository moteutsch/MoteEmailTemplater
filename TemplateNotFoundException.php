<?php

namespace Mote\EmailTemplater;

class TemplateNotFoundException extends \Exception
{
    /**
     * @param string $templateName
     */
    public function __construct($templateName)
    {
        parent::__construct(sprinf('Template "%s" not found', $templateName));
    }
}
