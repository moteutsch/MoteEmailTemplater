<?php

namespace Mote\EmailTemplater\ConverterToType;

interface ConverterToTypeInterface
{
    /**
     * Will not set "to" or "from" address on result if the result representation is supposed to have
     * set--it will have to be set by the client after-the-fact. The result of this method is only
     * the email itself, not any other details.
     *
     * @param \Mote\EmailTemplater\Email $email
     * @return mixed Some representation of an email
     */
    public function convert(\Mote\EmailTemplater\Email $email);
}
