# PHP library for creating emails from templates

Entirely configurable. Can easily be made to work with any email-sending library.

NOTE: This library is still in development, and not fully tested. Should work fine, but you should test it yourself (and submit bug reports or fixes!).

## Usage for ZF2:

```php
<?php

use Mote\EmailTemplater as Et;

$templater = new Et\Templater(...);
$transport = new \Zend\Mail\Transport\Sendmail();
try {
    $zendMessage = $templater->fromTemplate(
        'myEmailTemplate',
        array(
            'templateParam1' => 'Something...',
            'templateParam2' => 'Something else...',
        )
    )->convert('zf2'); // Or just ->convert() if "zf2" is set in constructor as default
    $zendMessage->setFrom('admin@localhost')
        ->setTo('someone@somewhere.com');
    $transport->send($zendMessage);
} catch (Et\TemplateNotFoundException $e) {
    echo 'Could not find template';
} catch (Et\Processor\InvalidTemplateException $e) {
    echo 'The template found was invalid';
} catch (Et\Processor\ProcessingException $e) {
    echo 'Generic processing exception';
}
```

For full example, see `example/` folder

## TO-DO

+ Have (all) exceptions inherit from a catch-all (match as per ZF2 standards)
+ (Separate) ZF2 module built upon this
+ "@include FILE_NAME" support in JSON to have fields in separate files
