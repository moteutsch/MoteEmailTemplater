<?php

namespace Mote\EmailTemplater\Processor;

interface ProcessorInterface
{
    /**
     * @param \Mote\EmailTemplater\Template $template
     * @param array $parameterMap
     * @return \Mote\EmailTemplater\Email
     *
     * @throws MissingParameterException
     * @throws InvalidTemplateException
     * @throws CannotProcessTemplateException Will be thrown if {@see canProcess} returns false
     * @throws ProcessingException The other exceptions inherit form this one, but this may also be thrown
     */
    public function process(\Mote\EmailTemplater\Template $template, array $parameterMap);

    /**
     * @param \Mote\EmailTemplater\Template $template
     * @return bool
     */
    public function canProcess(\Mote\EmailTemplater\Template $template);
}
