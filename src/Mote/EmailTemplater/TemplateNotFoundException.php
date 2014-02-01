<?php

namespace Mote\EmailTemplater;

class TemplateNotFoundException extends \Exception
{
    /**
     * @param string $templateName
     */
    public function __construct($templateName)
    {
        parent::__construct(sprintf('Template "%s" not found', $templateName));
    }
}
