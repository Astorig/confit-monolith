<?php

/*
 * This file is part of Laravel ClickHouse Migrations.
 *
 * (c) Anton Komarev <anton@komarev.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Providers;

use ClickHouseDB\Client as ClickhouseClient;
use App\Console\Commands\ClickhouseMigrateCommand;
use App\Console\Commands\MakeClickhouseMigrationCommand;
use Database\Factories\ClickhouseClientFactory;
use Database\Clickhouse\Migration\MigrationCreator;
use Database\Clickhouse\Migration\MigrationRepository;
use Database\Clickhouse\Migration\Migrator;
use Illuminate\Contracts\Config\Repository as AppConfigRepositoryInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

final class ClickhouseServiceProvider extends ServiceProvider
{
    private const CONFIG_FILE_PATH = __DIR__ . '/../config/clickhouse.php';

    public function register(): void
    {
        $this->app->singleton(
            ClickhouseClient::class,
            static function (Application $app): ClickhouseClient {
                $appConfigRepository = $app->get(AppConfigRepositoryInterface::class);
                $connectionConfig = $appConfigRepository->get('clickhouse.connection', []);

                $clickhouse = new ClickhouseClientFactory($connectionConfig);

                return $clickhouse->create();
            }
        );

        $this->app->singleton(
            Migrator::class,
            static function (Application $app): Migrator {
                $client = $app->get(ClickhouseClient::class);
                $filesystem = $app->get(Filesystem::class);
                $configRepository = $app->get(AppConfigRepositoryInterface::class);
                $table = $configRepository->get('clickhouse.migrations.table');

                $repository = new MigrationRepository(
                    $client,
                    $table,
                );

                return new Migrator(
                    $client,
                    $repository,
                    $filesystem,
                );
            }
        );

        $this->app->singleton(
            MigrationCreator::class,
            static function (Application $app): MigrationCreator {
                return new MigrationCreator(
                    $app->get(Filesystem::class),
                    $app->basePath('stubs')
                );
            }
        );
    }

    public function boot(): void
    {
        $this->configure();
        $this->registerConsoleCommands();
        $this->registerPublishes();
    }

    private function configure(): void
    {
        if (!$this->app->configurationIsCached()) {
            $this->mergeConfigFrom(
                self::CONFIG_FILE_PATH,
                'clickhouse'
            );
        }
    }

    private function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    ClickhouseMigrateCommand::class,
                    MakeClickhouseMigrationCommand::class,
                ]
            );
        }
    }

    private function registerPublishes(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    self::CONFIG_FILE_PATH => $this->app->configPath('clickhouse.php'),
                ],
                'config'
            );
        }
    }
}
