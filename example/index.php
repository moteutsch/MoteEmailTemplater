<?php

require_once './vendor/autoload.php';

use Mote\EmailTemplater as Et;

$templater = new Et\Templater(
    new Et\Finder\JsonFile(sprintf('%s/%s/', __DIR__, 'templates')),
    new Et\Processor\Composite(array(
        new Et\Processor\Handlebars(),
        new Et\Processor\PhpFiles(),
    )),
    new Et\EmailConverter(
        array(
            'zf2' => new Et\ConverterToType\Zf2Message(),
        ),
        'zf2'
    )
);

echo '<h1>Dumps of filled out instances of \Zend\Mail\Message</h1>';

echo '<h2>Template: "1-hello-world"</h2>';
$email = $templater->fromTemplate(
    '1-hello-world',
    array(
        'name' => 'John Smith',
        'days' => array(
            'Monday', 'Tuesday', 'Wendesday', 'Thursday',
            'Friday', 'Saturday', 'Sunday',
        ),
    )
);

echo '<pre>';
var_dump($email);
var_dump($email->convert());
echo '</pre>';

echo '<h2>Template: "2-happy-birthday"</h2>';
$email = $templater->fromTemplate(
    '2-happy-birthday',
    array(
        'name' => 'John Smith',
        'age' => '37',
    )
);

echo '<pre>';
var_dump($email);
var_dump($email->convert());
echo '</pre>';
