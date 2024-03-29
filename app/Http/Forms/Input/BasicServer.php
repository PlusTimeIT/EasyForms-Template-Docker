<?php

namespace App\Http\Forms\Input;

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

final class BasicServer extends InputForm
{
    use Transformable;

    public function __construct()
    {
        parent::__construct();

        return $this
            ->setName('Input\BasicServer')
            ->setTitle('BasicServer Title');
    }

    public function alerts(): array
    {
        return [
            Alert::make()
                ->setType(AlertTypes::Info)
                ->setColor('purple')
                ->setTrigger(AlertTriggers::AfterLoad)
                ->setText('Loaded - This is a sticky alert that shows when a form has been loaded.'),
            Alert::make()
                ->setType(AlertTypes::Error)
                ->setTrigger(AlertTriggers::FailedValidation)
                ->setAutoCloseTimer(2500)
                ->setText('Failed Validation - This alert shows when validation errors are present (will disappear in 2.5 seconds).')
                ->setIcon(
                    Icon::make()->setSize('small')->setIcon('mdi-rocket')
                ),
            Alert::make()
                ->setType(AlertTypes::Error)
                ->setTrigger(AlertTriggers::FailedProcessing)
                ->setClosable(true)
                ->setText('Failed Processing - This alert shows if the processing fails - Response: <response-data>'),
            Alert::make()
                ->setType(AlertTypes::Success)
                ->setTrigger(AlertTriggers::SuccessProcessing)
                ->setClosable(true)
                ->setText('Successful Processing - This alert shows on successful processing [Prominent] - Response: <response-data>'),
            Alert::make()
                ->setType(AlertTypes::Info)
                ->setTrigger(AlertTriggers::Cancelled)
                ->setClosable(true)
                ->setText('Cancelled - This alert shows when a form has been cancelled.'),
            Alert::make()
                ->setType(AlertTypes::Warning)
                ->setTrigger(AlertTriggers::FormReset)
                ->setClosable(true)
                ->setText('Reset - This alert shows when a form has been reset.'),
        ];
    }

    public function buttons(): array
    {
        return [
            Button::make()
                ->setType('process')
                ->setColor('primary')
                ->setText('Login')
                ->setPrependIcon(
                    Icon::make()
                        ->setIcon('mdi-login')
                        ->setColor('secondary')
                        ->setTooltip(
                            Tooltip::make()->setText('Process Form')
                        )
                )
                ->setOrder(0),
            Button::make()
                ->setType('cancel')
                ->setColor('red')
                ->setText('Cancel Form')
                ->setOrder(1)
                ->setPrependIcon(
                    Icon::make()
                        ->setIcon('mdi-cancel')
                        ->setColor('accent')
                        ->setTooltip(
                            Tooltip::make()->setText('Click here to cancel the form')
                        )
                ),
            Button::make()
                ->setType('reset')
                ->setColor('secondary')
                ->setText('Reset Form')
                ->setOrder(2)
                ->setPrependIcon(
                    Icon::make()
                        ->setIcon('mdi-refresh')
                        ->setColor('pink')
                        ->setTooltip(
                            Tooltip::make()->setText('Click here to reset the form')
                        )
                ),

        ];
    }

    public function fields(): array
    {
        return [
            TextField::make()
                ->setName('username')
                ->setOrder(0)
                ->setClearable(true)
                ->setHelp('OH OH')
                ->setLabel('Username')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
            PasswordField::make()
                ->setName('password')
                ->setOrder(1)
                ->setLabel('Password')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
        ];
    }

    public static function load(request $request): LoadResponse
    {
        // we can just set this to preFill if we want to load by axios later
        return LoadResponse::make()->success()->form((new self())->preFill());
    }

    public function preFill(): self
    {
        // populate fields with data
        $data = [
            'username' => 'Pre-populated Username',
        ];
        return $this->populateFields($data);
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
