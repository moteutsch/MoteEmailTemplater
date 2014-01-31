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
     * @throws CannotProcessTemplateException Will be thrown if {@see
     * canProcess} returns false
     */
    public function process(Template $template, array $parameterMap);

    /**
     * @param \Mote\EmailTemplater\Template $template
     * @return bool
     */
    public function canProcess(\Mote\EmailTemplater\Template $template);
}
