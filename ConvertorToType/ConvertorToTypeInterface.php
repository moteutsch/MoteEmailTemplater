<?php

namespace Mote\EmailTemplater\ConverterToType;

interface ConverterToTypeInterface
{
    /**
     * @param \Mote\EmailTemplater\Email $email
     * @return mixed Some representation of an email
     */
    public function convert(\Mote\EmailTemplater\Email $email);
}
