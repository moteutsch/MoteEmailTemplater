<?php

namespace Mote\EmailTemplater\ConverterToType;

use \Zend\Mail\Message as MailMessage;
use \Zend\Mime\Message as MimeMessage;
use \Zend\Mime\Part as MimePart;

class Zf2Message implements ConverterToTypeInterface
{
    // NOTE: Actually sending the result of convert() is untested: written based on this: http://akrabat.com/zend-framework-2/sending-an-html-with-text-alternative-email-with-zendmail

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
        $message->setEncoding($email->getEncoding())
            ->setSubject($email->getSubject())
            ->setBody($body);
        $message->getHeaders()
            ->get('content-type')->setType('multipart/alternative');

        return $message;
    }
}
