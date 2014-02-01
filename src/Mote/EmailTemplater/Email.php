<?php

namespace Mote\EmailTemplater;

/**
 * Immutable representation of a parsed email
 */
class Email
{
    /** @var string */
    private $encoding;

    /** @var string */
    private $subject;

    /** @var string|null */
    private $textBody;

    /** @var string|null */
    private $htmlBody;

    /** @var EmailConverter */
    private $converter;

    /**
     * @param string $encoding
     * @param string $subject
     * @param string|null $textBody
     * @param string|null $htmlBody
     */
    public function __construct( $encoding, $subject, $textBody, $htmlBody)
    {
        $this->encoding   = $encoding;
        $this->subject    = $subject;
        $this->textBody   = $textBody;
        $this->htmlBody   = $htmlBody;
    }

    /**
     * @param EmailConverter $converter
     * @return Email
     */
    public function setConverter(EmailConverter $converter)
    {
        $this->converter  = $converter;
        return $this;
    }

    /**
     * @param string|EmailConverter::DEFAULT_TYPE $toType
     * @return mixed An email representation {@see ConverterToTypeInterface::convert}
     *
     * @throws MissingConverterForTypeException
     * @throws MissingDefaultTypeException
     */
    public function convert($toType = EmailConverter::DEFAULT_TYPE)
    {
        if ($this->converter === null) {
            throw new MissingConverterForTypeException('all types');
        }
        return $this->converter->convert($this, $toType);
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
