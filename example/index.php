<?php

require_once './vendor/autoload.php';

use Mote\EmailTemplater as Et;

$templater = new Et\Templater(
    new Et\Finder\JsonFile(sprintf('%s/%s/', __DIR__, 'templates')),
    new Et\Processor\Composite(array(
        new Et\Processor\PhpFiles()
    )),
    new Et\EmailConverter(
        array(
            'zf2' => new Et\ConverterToType\Zf2Message(),
        ),
        'zf2'
    )
);

echo '<h1>Last dump should be filled out instance of \Zend\Mail\Message</h1>';
$email = $templater->fromTemplate(
    'happyBirthday',
    array(
        'name' => 'John Smith',
        'age' => '37',
    )
);
var_dump($email);
var_dump($email->convert());
