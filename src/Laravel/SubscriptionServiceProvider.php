<?php
namespace Mirbaagheri\Subscription\Laravel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Config;
use Mirbaagheri\Subscription\Emails\IlluminateEmailRepository;
use Mirbaagheri\Subscription\Types\IlluminateTypeRepository;
use Mirbaagheri\Subscription\Subscription;

class SubscriptionServiceProvider extends ServiceProvider {

    protected $config;

    public function boot()
    {
        $this->loadConfig();
        Validator::extend('emailStatus', function ($attribute, $value, $parameters, $validator) {

            if(is_string ($value))
            {
                $statusArray = $this->config['emails']['status'];
                if(array_key_exists(strtolower($value),$statusArray))
                    return true;
                return false;
            }
            else return false;
        },
            "Invalid status.\n".
            "You have to use the following values for status parameter:\n".
            implode(', ',array_keys($this->config['emails']['status']))."\n"
            );

        Validator::extend('typeStatus', function ($attribute, $value, $parameters, $validator) {

            if(is_string ($value))
            {
                $statusArray = $this->config['types']['status'];
                if(array_key_exists(strtolower($value),$statusArray))
                    return true;
                return false;
            }
            else return false;
        },
            "Invalid status.\n".
            "You have to use the following values for status parameter:\n".
            implode(', ',array_keys($this->config['types']['status']))."\n"
        );
    }

    public function register()
	{
	    $this->prepareResources();
	    $this->registerEmails();
        $this->registerTypes();
	    $this->registerSubscription();
	}

    private function loadConfig()
    {
        $this->config = Config::get('mirbaagheri.subscription');
    }

    protected function prepareResources()
    {
        // Publish config
        $config = realpath(__DIR__.'/../config/config.php');

        $this->mergeConfigFrom($config, 'mirbaagheri.subscription');

        $this->publishes([
            $config => config_path('mirbaagheri.subscription.php'),
        ], 'config');
    }

    protected function registerEmails()
    {
        $this->app->singleton('subscription.emails', function ($app) {
            $config = $app['config']->get('mirbaagheri.subscription');
            $model  = $config['emails']['model'];
            return new IlluminateEmailRepository($model);
        });
    }

    protected function registerTypes()
    {
        $this->app->singleton('subscription.types', function ($app) {
            $config = $app['config']->get('mirbaagheri.subscription');
            $model  = $config['types']['model'];
            return new IlluminateTypeRepository($model);
        });
    }

	public function registerSubscription()
    {
        $this->app->singleton('Subscription', function($app) {
            return new Subscription(
                $app['subscription.emails'],
                $app['subscription.types']
            );
        });
    }

    public function provides()
    {
        return [
            'subscription.emails',
            'subscription.types'
        ];
    }

}
