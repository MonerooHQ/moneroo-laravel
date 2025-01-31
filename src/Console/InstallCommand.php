<?php

namespace Moneroo\Laravel\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Moneroo\Laravel\Providers\MonerooServiceProvider;

final class InstallCommand extends Command
{
    protected $signature = 'moneroo:install';

    protected $description = 'Install the Moneroo Laravel Package';

    public function handle(): void
    {
        $this->info('Installing Moneroo Laravel Package...');

        $this->info('Publishing configuration...');

        if (! $this->configExists()) {
            $this->publishConfiguration();
            $this->info('Published configuration');
        } elseif ($this->shouldOverwriteConfig()) {
            $this->info('Overwriting configuration file...');
            $this->publishConfiguration($force = true);
        } else {
            $this->info('Existing configuration was not overwritten');
        }

        $this->info('Moneroo Laravel Package installed successfully.');
    }

    /**
     * Updates the environment file with the basic configuration.
     */
    public function updateEnvironmentFile(): void
    {
        if (File::exists($env = app()->environmentFile())) {
            $contents = File::get($env);

            if (! Str::contains($contents, 'MONEROO_SECRET_KEY=')) {
                File::append(
                    $env,
                    PHP_EOL . 'MONEROO_SECRET_KEY=' . 'your-secret-key' . PHP_EOL,
                );
                $this->info('Added MONEROO_SECRET_KEY to your .env file');
                $this->info('Please update the value with your Moneroo Secret Key');
            } else {
                $this->info('MONEROO_SECRET_KEY already exists in your .env file');
            }
        }
    }

    private function configExists(): bool
    {
        return File::exists(config_path('moneroo-laravel.php'));
    }

    private function shouldOverwriteConfig(): bool
    {
        return $this->confirm(
            'Config file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishConfiguration($forcePublish = false): void
    {
        $params = [
            '--provider' => MonerooServiceProvider::class,
            '--tag'      => 'config',
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }
        $this->call('vendor:publish', $params);
        $this->updateEnvironmentFile();
    }
}
