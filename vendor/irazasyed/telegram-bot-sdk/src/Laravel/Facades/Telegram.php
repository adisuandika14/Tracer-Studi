<?php

namespace Telegram\Bot\Laravel\Facades;

use Telegram\Bot\BotsManager;
use Illuminate\Support\Facades\Facade;


class Telegram extends Facade
{

    protected static function getFacadeAccessor()
    {
        return BotsManager::class;
    }
}

