<?php

namespace Mote\EmailTemplater\ConverterToType;

class Zf2Message implements ConverterToTypeInterface
{
    /**
     * @param \Mote\EmailTemplater\Email $email
     * @return \Zend\Mail\Message Some representation of an email
     */
    public function convert(\Mote\EmailTemplater\Email $email)
    {
        // TODO: Impelment
        // http://framework.zend.com/manual/2.1/en/modules/zend.mail.introduction.html
    }
}
