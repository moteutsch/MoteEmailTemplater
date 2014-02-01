<?php

namespace Mote\EmailTemplater;

use Mote\EmailTemplater\Finder\FinderInterface;
use Mote\EmailTemplater\Processor\ProcessorInterface;

class Templater
{
    /** @var FinderInterface */
    private $finder;

    /** @var ProcessorInterface */
    private $processor;

    /** @var EmailConverter */
    private $converter;

    public function __construct(FinderInterface $finder, ProcessorInterface $processor, EmailConverter $converter)
    {
        $this->finder = $finder;
        $this->processor = $processor;
        $this->converter = $converter;
    }

    /**
     * @param string $templateName
     * @param array $params
     * @return Email
     *
     * @throws TemplateNotFoundException
     * @throws Processor\MissingParameterException
     * @throws Processor\InvalidTemplateException
     * @throws Processor\CannotProcessTemplateException
     */
    public function fromTemplate($templateName, array $params)
    {
        $template = $this->finder->find($templateName);
        if ($template === null) {
            throw new TemplateNotFoundException($templateName);
        }
        return $this->processor->process($template, $params)
            ->setConverter($this->converter);
    }
}
