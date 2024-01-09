<?php

namespace App\Http\Forms\Input\User;

use Illuminate\Http\Request;
use PlusTimeIT\EasyForms\Base\InputForm;
use PlusTimeIT\EasyForms\Elements\Alert;
use PlusTimeIT\EasyForms\Elements\Button;
use PlusTimeIT\EasyForms\Elements\Icon;
use PlusTimeIT\EasyForms\Elements\LoadResponse;
use PlusTimeIT\EasyForms\Elements\ProcessResponse;
use PlusTimeIT\EasyForms\Elements\RuleItem;
use PlusTimeIT\EasyForms\Elements\Tooltip;
use PlusTimeIT\EasyForms\Enums\AlertTriggers;
use PlusTimeIT\EasyForms\Enums\AlertTypes;
use PlusTimeIT\EasyForms\Fields\PasswordField;
use PlusTimeIT\EasyForms\Fields\TextField;
use PlusTimeIT\EasyForms\Traits\Transformable;

final class Login extends InputForm
{
    use Transformable;

    public function __construct()
    {
        parent::__construct();

        return $this
            ->setName('Input\Login')
            ->setTitle('Login Title');
    }

    public function alerts(): array
    {
        return [
            Alert::make()
                ->setType(AlertTypes::Info)
                ->setColor('orange')
                ->setTrigger(AlertTriggers::AfterLoad)
                ->setText('Use the details you created in the previous form.'),
            Alert::make()
                ->setType(AlertTypes::Error)
                ->setTrigger(AlertTriggers::FailedValidation)
                ->setAutoCloseTimer(2500)
                ->setText('We must pass the required fields.')
                ->setIcon(
                    Icon::make()->setSize('small')->setIcon('mdi-rocket')
                ),
            Alert::make()
                ->setType(AlertTypes::Error)
                ->setTrigger(AlertTriggers::FailedProcessing)
                ->setClosable(true)
                ->setText('Error: <response-data>'),
            Alert::make()
                ->setType(AlertTypes::Success)
                ->setTrigger(AlertTriggers::SuccessProcessing)
                ->setClosable(true)
                ->setText('<response-data>'),
        ];
    }

    public function buttons(): array
    {
        return [
            Button::make()
                ->setType('process')
                ->setColor('primary')
                ->setText('Login')
                ->setOrder(0),

        ];
    }

    public function fields(): array
    {
        return [
            TextField::make()
                ->setName('username')
                ->setOrder(0)
                ->setClearable(true)
                ->setHelp('Enter username created in previous form')
                ->setLabel('Username')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
            PasswordField::make()
                ->setName('password')
                ->setOrder(1)
                ->setLabel('Password')
                ->setHelp('Enter password created in previous form')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
        ];
    }

    public static function process(request $request): ProcessResponse
    {
        //request has been validated, so we know what we have.
        $username = $request->username;

        //run checks
        if ($username !== 'Pre-populated Username') {
            return ProcessResponse::make()->failed()->data('Wrong username silly, use the preloaded one');
        }

        return ProcessResponse::make()->success()->data('Yay you logged in!');
    }
}
