<?php
/**
 * Copyright (c) 2020 Jacob Siefer
 * See LICENSE bundled with this package for license details.
 */
declare(strict_types=1);

namespace Typesetsh\LaravelWrapper;

use Illuminate\Contracts;
use Illuminate\Support;
use Typesetsh\UriResolver;

class ServiceProvider extends Support\ServiceProvider implements Contracts\Support\DeferrableProvider
{
    public const CONFIG_PATH = __DIR__.'/../config/typesetsh.php';

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'typesetsh');

        $this->registerPdfRenderer();
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'typesetsh');
        $this->publishes([
            self::CONFIG_PATH => base_path('config/typesetsh.php'),
        ]);
    }

    protected function registerPdfRenderer(): void
    {
        $this->app->singleton('typesetsh', function (Contracts\Foundation\Application $app) {
            $allowedDirectories = $app['config']['typesetsh.allowed_directories'] ?? [];
            $baseDir = $app['config']['typesetsh.base_dir'] ?? '';
            $allowProtocols = $app['config']['typesetsh.allowed_protocols'] ?? [];
            $cacheDir = $app['config']['typesetsh.cache_dir'] ?? null;
            $timeout = (int) ($app['config']['typesetsh.timeout'] ?? 15);
            $downloadLimit = (int) ($app['config']['typesetsh.download_limit'] ?? 1024 * 1024 * 5);
            $pdfVersion = (string) ($app['config']['typesetsh.pdf_version'] ?? '1.6');

            $schemes = [];
            $schemes['data'] = new UriResolver\Data($cacheDir);

            if ($allowProtocols) {
                $http = new UriResolver\Http($cacheDir, $timeout, $downloadLimit);
                foreach ($allowProtocols as $protocol) {
                    $schemes[$protocol] = $http;
                }
            }
            if ($allowedDirectories) {
                $schemes['file'] = new UriResolver\File($allowedDirectories);
            }

            return new Typesetsh(new UriResolver($schemes, $baseDir), null, $pdfVersion);
        });

        $this->app->singleton('typesetsh.pdf', function (Contracts\Foundation\Application $app) {
            $debug = $app->hasDebugModeEnabled() && ($app['config']['typesetsh.debug'] ?? true);

            return new Pdf\Factory($app['typesetsh'], $app['view'], $debug);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return list<string>
     */
    public function provides(): array
    {
        return ['typesetsh', 'typesetsh.pdf'];
    }
}
