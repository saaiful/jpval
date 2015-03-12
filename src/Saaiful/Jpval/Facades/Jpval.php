<?php namespace Saaiful\Jpval\Facades;
use Illuminate\Support\Facades\Facade;
class Jpval extends Facade
{
	
	/**
	* Get the registered name of the component.
	*
	* @return string
	*/
	protected static function getFacadeAccessor() {
        return 'Jpval';
    }
}
