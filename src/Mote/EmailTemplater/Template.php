<?php

namespace Mote\EmailTemplater;

/**
 * Immutable representation of an email template
 */
class Template
{
    /** @var string */
    private $encoding;

    /** @var string */
    private $subject;

    /** @var string|null */
    private $textBody;

    /** @var string|null */
    private $htmlBody;

    /**
     * @param string $encoding
     * @param string $subject
     * @param string|null $textBody
     * @param string|null $htmlBody
     */
    public function __construct($encoding, $subject, $textBody, $htmlBody)
    {
        $this->encoding   = $encoding;
        $this->subject    = $subject;
        $this->textBody   = $textBody;
        $this->htmlBody   = $htmlBody;
    }

    /** @return string */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /** @return string */
    public function getSubject()
    {
        return $this->subject;
    }

    /** @return string */
    public function getHtmlBody()
    {
        return $this->encoding;
    }

    /** @return string */
    public function getTextBody()
    {
        return $this->encoding;
    }

    /** @return bool */
    public function hasHtmlBody()
    {
        return $this->htmlBody !== null;
    }

    /** @return bool */
    public function hasTextBody()
    {
        return $this->textBody !== null;
    }
}
