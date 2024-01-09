<?php

namespace App\Http\Forms\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PlusTimeIT\EasyForms\Base\ActionForm;
use PlusTimeIT\EasyForms\Elements\ActionButton;
use PlusTimeIT\EasyForms\Elements\Alert;
use PlusTimeIT\EasyForms\Elements\Button;
use PlusTimeIT\EasyForms\Elements\Icon;
use PlusTimeIT\EasyForms\Elements\ProcessResponse;
use PlusTimeIT\EasyForms\Elements\Tooltip;
use PlusTimeIT\EasyForms\Enums\AlertTriggers;
use PlusTimeIT\EasyForms\Enums\AlertTypes;
use PlusTimeIT\EasyForms\Traits\Transformable;

final class ResetCache extends ActionForm
{
    use Transformable;

    public function __construct()
    {
        parent::__construct();

        return $this
            ->setName('Action\ResetCache')
            ->setTitle('Reset Cached Data')
            ->setInline(true);
    }

    public function actions(): array
    {
        return [
            ActionButton::make()
                ->setIdentifier('cache')
                ->setName('Reset Cached Data')
                ->setButton(
                    Button::make()
                        ->setType('action')
                        ->setColor('primary')
                        ->setText('Reset Data')
                        ->setAppendIcon(
                            Icon::make()->setIcon('mdi-stethoscope')->setTooltip(Tooltip::make()->setText('Reset all the data back to the initial 5 users'))->setColor('white')
                        )
                )
                ->setCallback('resetCache')
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
        if (!$request->action || !collect(self::make()->actions())->where('identifier', $request->action)) {
            return ProcessResponse::make()->failed()->data('Don\'t mess with the actions yo!');
        }

        return self::{$request->action}($request);
    }

    public static function resetCache(request $request)
    {
        Cache::forget('users');

        return ProcessResponse::make()->success()->data('Cache reset')->redirect('reload');
    }
}
