<?php

namespace App\Providers;

use App\BlowfishEncrypter;
use Illuminate\Encryption\MissingAppKeyException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // 5.5.3.5. インターフェースと具象クラスのバインド
        $this->app->bind(
            \App\DataProvider\PublisherRepositoryInterface::class,
            \App\DataProvider\PublisherRepository::class,
        );

        $this->app->singleton(
            'encrypter',
            function ($app) {
                $config = $app->make('config')->get('app');

                return new BlowfishEncrypter($this->parsekey($config));
            }
        );
    }

    protected function parsekey(array $config)
    {
        if (Str::startsWith($key = $this->key($config), $prefix = 'base64:')) {
            $key = base64_decode(Str::after($key, $prefix));
        }

        return $key;
    }

    protected function key(array $config)
    {
        return tap(
            $config['key'],
            function ($key) {
                if (empty($key)) {
                    throw new MissingAppKeyException;
                }
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
