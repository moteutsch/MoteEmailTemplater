<?php

namespace Mote\EmailTemplater\Processor;

class PhpFiles implements ProcessorInterface
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
    public function process(Template $template, array $parameterMap)
    {
        if (!$this->canProcess()) {
            throw new CannotProcessTemplateException();
        }
        $path = $template->hasHtmlBody() ? $template->getHtmlBody() : $template->getTextBody();
        // TODO: Maybe return EmailWithoutConverter here and Email in Templater? That way it will reflect the actual state of the convert() method
        return new \Mote\EmailTemplater\Email(
            $template->getEncoding(),
            $template->getSubject() === $path ? $this->parsePhpFile('subject', $path) : $template->getSubject(),
            $template->hasHtmlBody() ? $this->parsePhpFile('htmlBody', $path) : null,
            $template->hasTextBody() ? $this->parsePhpFile('textBody', $path) : null
        );
    }

    private function parsePhpFile($file, $inPath, array $params)
    {
        $fullPath = realpath(sprintf('%s/%s.phtml', rtrim($inPath, '/\\'), $file));
        if ($fullPath === false) {
            throw new InvalidTemplateException();
        }
        return $this->includeFile($fullPath, $params);
    }

    /**
     * Used to limit the values the view can see
     */
    private function includeFile($fullPath, array $params)
    {
        ob_start();
        $wasSuccessful = @include $fullPath;
        $result = ob_get_clean();
        if (!$wasSuccessful) {
            throw new InvalidTemplateException();
        }
        return $result;
    }

    /**
     * @param \Mote\EmailTemplater\Template $template
     * @return bool
     */
    public function canProcess(\Mote\EmailTemplater\Template $template)
    {
        // TODO: type property
        return $template->getType() === 'phpFiles';
    }
}
