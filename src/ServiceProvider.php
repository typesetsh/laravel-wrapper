<?php
/**
 * @copyright Copyright (c) 2020 Jacob Siefer
 *
 * @see LICENSE
 */
declare(strict_types=1);

namespace Typesetsh\LaravelWrapper;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support;
use typesetsh\UriResolver;

class ServiceProvider extends Support\ServiceProvider implements DeferrableProvider
{
    const CONFIG_PATH = __DIR__.'/../config/typesetsh.php';

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'typesetsh');

        $this->registerPdfRenderer();
    }

    protected function registerPdfRenderer(): void
    {
        $this->app->singleton('typesetsh', function ($app) {
            $allowedDirectories = $app['config']['typesetsh.allowed_directories'] ?? [];
            $allowProtocols = $app['config']['typesetsh.allowed_protocols'] ?? [];
            $cacheDir = $app['config']['typesetsh.cache_dir'] ?? null;
            $timeout = $app['config']['typesetsh.timeout'] ?? 15;

            $schemes = [];
            if ($allowProtocols) {
                $http = new UriResolver\Http($cacheDir, $timeout);
                foreach ($allowProtocols as $protocol) {
                    $schemes[$protocol] = $http;
                }
            }
            if ($allowedDirectories) {
                $schemes['file'] = new UriResolver\File($allowedDirectories);
            }

            return new Typesetsh(new UriResolver($schemes));
        });

        $this->app->singleton('typesetsh.pdf', function ($app) {
            return new Pdf\Factory($app['typesetsh'], $app['view']);
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['typesetsh', 'typesetsh.pdf'];
    }
}
