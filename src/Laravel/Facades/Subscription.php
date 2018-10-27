<?php
namespace Mirbaagheri\Subscription\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Subscription extends Facade {


	protected static function getFacadeAccessor()
    {
        return 'Subscription';
    }

}