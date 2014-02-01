<?php

namespace Mote\EmailTemplater\ConverterToType;

use ZendMail;
use ZendMimeMessage as MimeMessage;
use ZendMimePart as MimePart;

class Zf2Message implements ConverterToTypeInterface
{
    // NOTE: Untested: written based on this: http://akrabat.com/zend-framework-2/sending-an-html-with-text-alternative-email-with-zendmail

    /**
     * Will not have "from" and "to" information set on result Message.
     *
     * @param \Mote\EmailTemplater\Email $email
     * @return \Zend\Mail\Message Some representation of an email
     */
    public function convert(\Mote\EmailTemplater\Email $email)
    {
        $body = new MimeMessage();
        if ($email->hasTextBody()) {
            $textPart = new MimePart($email->getTextBody());
            $textPart->type = 'text/plain';
            $body->addPart($textPart);
        }
        if ($email->hasHtmlBody()) {
            $htmlPart = new MimePart($email->getHtmlBody());
            $htmlPart->type = 'text/html';
            $body->addPart($htmlPart);
        }

        $message = new MailMessage();
        $message->setSubject($subject)
            ->setEncoding($email->getEncoding())
            ->setBody($email->getBody());
        $message->getHeaders()
            ->get('content-type')->setType('multipart/alternative');

        return $message;
    }
}
