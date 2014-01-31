<?php

namespace Mote\EmailTemplater\Processor;

class Composite implements ProcessorInterface
{
    /** @var ProcessorInterface[] */
    private $processors;

    /**
     * @param ProcessorInterface[] $processors
     */
    public function __construct(array $processors)
    {
        $this->processors = $processors;
    }

    public function process(Template $template, array $parameterMap)
    {
        foreach ($this->processors as $processor) {
            if ($processor->canProcess($template)) {
                return $processor->process($template, $parameterMap);
            }
        }
        throw new CannotProcessTemplateException();
    }

    public function canProcess(\Mote\EmailTemplater\Template $template)
    {
        foreach ($this->processors as $processor) {
            if ($processor->canProcess($template)) {
                return true;
            }
        }
        return false;
    }
}
