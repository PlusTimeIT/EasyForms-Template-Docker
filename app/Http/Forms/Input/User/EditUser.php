<?php

namespace App\Http\Forms\Input\User;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use PlusTimeIT\EasyForms\Base\InputForm;
use PlusTimeIT\EasyForms\Elements\Alert;
use PlusTimeIT\EasyForms\Elements\Button;
use PlusTimeIT\EasyForms\Elements\Icon;
use PlusTimeIT\EasyForms\Elements\LoadResponse;
use PlusTimeIT\EasyForms\Elements\ProcessResponse;
use PlusTimeIT\EasyForms\Elements\RuleItem;
use PlusTimeIT\EasyForms\Elements\SelectItem;
use PlusTimeIT\EasyForms\Elements\Tooltip;
use PlusTimeIT\EasyForms\Enums\AlertTriggers;
use PlusTimeIT\EasyForms\Enums\AlertTypes;
use PlusTimeIT\EasyForms\Fields\AutoCompleteField;
use PlusTimeIT\EasyForms\Fields\PasswordField;
use PlusTimeIT\EasyForms\Fields\SelectField;
use PlusTimeIT\EasyForms\Fields\TextField;
use PlusTimeIT\EasyForms\Traits\Transformable;

final class EditUser extends InputForm
{
    use Transformable;

    public function __construct()
    {
        parent::__construct();

        return $this
            ->setName('Input\User\EditUser')
            ->setTitle('Edit User');
    }

    public function alerts(): array
    {
        return [
            Alert::make()
                ->setType(AlertTypes::Error)
                ->setTrigger(AlertTriggers::FailedValidation)
                ->setAutoCloseTimer(2500)
                ->setText('Please fix the validation errors below')
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
            Alert::make()
                ->setType(AlertTypes::Info)
                ->setTrigger(AlertTriggers::Cancelled)
                ->setClosable(true)
                ->setText('Your edits have been cancelled'),
            Alert::make()
                ->setType(AlertTypes::Warning)
                ->setTrigger(AlertTriggers::FormReset)
                ->setClosable(true)
                ->setText('We have reset the form for you.'),
        ];
    }

    public function buttons(): array
    {
        return [
            Button::make()
                ->setType('process')
                ->setColor('primary')
                ->setText('Update')
                ->setPrependIcon(
                    Icon::make()
                        ->setIcon('mdi-user')
                        ->setColor('secondary')
                        ->setTooltip(
                            Tooltip::make()->setText('Update a user to cache')
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

    public static function load(request $request): LoadResponse
    {
        // we can just set this to preFill if we want to load by axios later
        return LoadResponse::make()->success()->form((new self())->preFill($request->id));
    }

    public function preFill($userId): self
    {
        // populate fields with data
        $user = (new UserController)->get($userId);
        if (!$user) return $this->populateFields();

        // dont want to preload password - so unset it
        unset($user->password);
        return $this->populateFields((array) $user);
    }

    public function fields(): array
    {
        return [
            TextField::make()
                ->setName('first_name')
                ->setOrder(0)
                ->setPlaceholder('Edit the first name')
                ->setHelp('Enter your name so we can greet you')
                ->setLabel('First Name')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
            TextField::make()
                ->setName('username')
                ->setOrder(0)
                ->setPlaceholder('Enter a username')
                ->setHelp('Edit username for login')
                ->setLabel('Username')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
            PasswordField::make()
                ->setName('password')
                ->setOrder(1)
                ->setPlaceholder('Enter a password')
                ->setLabel('Password')
                ->setRules([
                    // removed requirement of password field, ultimately making it optional
                ]),
            TextField::make()
                ->setName('email')
                ->setOrder(3)
                ->setPlaceholder('Enter an email')
                ->setHelp('This doesnt do anything, just here to show you an email field')
                ->setLabel('Email')
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                    RuleItem::make()->setName('email')->setValue(true),
                ]),
            SelectField::make()
                ->setName('status')
                ->setOrder(4)
                ->setPlaceholder('Select a status')
                ->setLabel('Status')
                ->setItemValue('id')
                ->setItemTitle('value')
                ->setItems([
                    SelectItem::make()->setId(0)->setValue('Active'),
                    SelectItem::make()->setId(1)->setValue('Inactive'),
                ])
                ->setRules([
                    RuleItem::make()->setName('required')->setValue(true),
                ]),
        ];
    }

    public static function process(request $request): ProcessResponse
    {
        // since we aren't populating any of the fields, we only need to create the process function

        //request has been validated already, so we know what we have.
        $updated = (new UserController)->update($request);
        //run checks
        if (!$updated) {
            return ProcessResponse::make()->failed()->data('Failed to update user');
        }

        return ProcessResponse::make()->success()->data('User updated successfully');
    }
}
