<?php

namespace Mote\EmailTemplater\Processor;

class Handlebars implements ProcessorInterface
{
    public function process(\Mote\EmailTemplater\Template $template, array $parameterMap)
    {
        if (!$this->canProcess($template)) {
            throw new CannotProcessTemplateException();
        }
        return new \Mote\EmailTemplater\Email(
            $template->getEncoding(),
            $this->parseMarkdown($template->getSubject(), $parameterMap),
            $this->parseMarkdown($template->getTextBody(), $parameterMap),
            $this->parseMarkdown($template->getHtmlBody(), $parameterMap)
        );
    }

    private function parseMarkdown($text, array $params)
    {
        if ($text === null) {
            return null;
        }

        try {
            $engine = new \Handlebars\Handlebars();
            return $engine->render($text, $params);
        } catch (\Exception $e) {
            throw new ProcessingException();
        }
    }

    /**
     * @param \Mote\EmailTemplater\Template $template
     * @return bool
     */
    public function canProcess(\Mote\EmailTemplater\Template $template)
    {
        return $template->getType() === 'handlebars';
    }
}
