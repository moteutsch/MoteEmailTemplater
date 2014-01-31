<?php

namespace Mote\EmailTemplater\Finder;

interface FinderInterface
{
    /**
     * @param string $templateName
     * @return \Mote\EmailTemplater\Template|null
     */
    public function find($templateName);
}
