<?php

namespace App\Http\Forms\Action\User;

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use PlusTimeIT\EasyForms\Base\ActionForm;
use PlusTimeIT\EasyForms\Controllers\Users;
use PlusTimeIT\EasyForms\Elements\ActionButton;
use PlusTimeIT\EasyForms\Elements\ActionIcon;
use PlusTimeIT\EasyForms\Elements\Alert;
use PlusTimeIT\EasyForms\Elements\Button;
use PlusTimeIT\EasyForms\Elements\Icon;
use PlusTimeIT\EasyForms\Elements\ProcessResponse;
use PlusTimeIT\EasyForms\Elements\Tooltip;
use PlusTimeIT\EasyForms\Enums\AlertTriggers;
use PlusTimeIT\EasyForms\Enums\AlertTypes;
use PlusTimeIT\EasyForms\Traits\Transformable;

final class ListActions extends ActionForm
{
    use Transformable;

    public function __construct()
    {
        parent::__construct();

        return $this
            ->setName('Action\User\ListActions')
            ->setTitle('Action Form with conditional icons')
            ->setInline(true);
    }

    public function actions(): array
    {
        return [
            ActionIcon::make()
                ->setIdentifier('edit')
                ->setName('Edit User')
                ->setIcon(
                    Icon::make()
                        ->setColor('primary')
                        ->setIcon('mdi-pencil')
                )
                ->setCallback('edit')
                ->setOrder(0),
            ActionIcon::make()
                ->setIdentifier('delete')
                ->setName('Delete User')
                ->setIcon(
                    Icon::make()
                        ->setColor('primary')
                        ->setIcon('mdi-trash-can')
                )
                ->setCallback('delete')
                ->setOrder(0),
        ];
    }


    public function alerts(): array
    {
        return [
            Alert::make()
                ->setTrigger(AlertTriggers::FailedProcessing)
                ->setType(AlertTypes::Error)
                ->setColor('red')
                ->setProminent(true)
                ->setBorder('bottom')
                ->setClosable(true)
                ->setText('Processing Failed!'),
            Alert::make()
                ->setTrigger(AlertTriggers::SuccessProcessing)
                ->setType(AlertTypes::Success)
                ->setColor('green')
                ->setProminent(true)
                ->setBorder('top')
                ->setClosable(true)
                ->setText('Processing Successful!'),
        ];
    }

    public static function process(request $request): ProcessResponse
    {
        if (!$request->form_action || !collect(self::make()->actions())->where('identifier', $request->form_action)) {
            return ProcessResponse::make()->failed()->data('Don\'t mess with the actions yo!');
        }

        return self::{$request->form_action}($request);
    }


    public static function edit(request $request)
    {
        if (!(new UserController)->get($request->id)) {
            return ProcessResponse::make()
                ->failed()
                ->data('Unknown user')
                ->redirect('reload');
        }
        return ProcessResponse::make()
            ->success()
            ->data('User found.')
            ->redirect('/#/users/edit/' . $request->id);
    }


    public static function delete(request $request)
    {
        (new UserController)->delete($request->id);

        return ProcessResponse::make()
            ->success()
            ->data('Successfully deleted user')
            ->redirect('reload');
    }
}
