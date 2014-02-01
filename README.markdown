# PHP library for creating emails from templates

Entirely configurable. Can easily be made to work with any email-sending library.

## Usage for ZF2:

```
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
} catch (Et\Processor\MissingParameterException $e) {
    echo 'Could not find missing parameter';
} catch (Et\Processor\InvalidTemplateException $e) {
    echo 'The template found was invalid';
} catch (Et\Processor\CannotProcessTemplateException $e) {
    echo 'No one can parse the found template into an email.';
}
```

For full example, see `example/` folder

## TO-DO

+ Have exceptions inherit from a catch-all (match as per ZF2 standards)
+ (Separate) ZF2 module built upon this
+ Another processor (markdown, smarty, etc.)
