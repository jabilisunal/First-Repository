<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Application';

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle(): bool
    {
        Artisan::call('clear-compiled');
        $this->info('1. Compiled services and packages files removed!');

        // if (App::environment('local')) {
        //Artisan::call('optimize');
        $this->info('2. Configuration cache cleared!');
        $this->info('3. Configuration cached successfully!');
        $this->info('4. Route cache cleared!');
        $this->info('5. Routes cached successfully!');
        $this->info('6. Files cached successfully!');
        //}

        Artisan::call('key:generate');
        $this->info('7. Application key set successfully.');

        Artisan::call('db:seed --class=DropDatabaseSeeder');
        $this->info('8. Dropped Database');

        // Migrate Database
        Artisan::call('migrate:fresh');
        $this->info('9. Migrate Database');

        // Seed Database
        Artisan::call('db:seed');
        $this->info('10. Seed Database');

        // Seed Database
        Artisan::call('permission:cache-reset');
        $this->info('11. Reset permission cache');

        // Storage folder linked
        Artisan::call('storage:link');
        $this->info('12. Storage folder linked');

        // Routers refresh
        Artisan::call('route:clear');
        $this->info('13. Routers refresh');

        // Caches clear
        Artisan::call('cache:clear');
        $this->info('13. Caches clear');

        // Storage/App/Media folder delete
        if (file_exists(storage_path('app/media'))) {
            delTree(storage_path('app/media'));
        }

        // Storage/App/Large/Media folder delete
        if (file_exists(storage_path('app/large/media'))) {
            delTree(storage_path('app/large/media'));
        }

        // Storage/App/Medium/Media folder delete
        if (file_exists(storage_path('app/medium/media'))) {
            delTree(storage_path('app/medium/media'));
        }

        // Storage/App/Smalls/Media folder delete
        if (file_exists(storage_path('app/smalls/media'))) {
            delTree(storage_path('app/smalls/media'));
        }

        // Storage/App/Icons/Media folder delete
        if (file_exists(storage_path('app/icons/media'))) {
            delTree(storage_path('app/icons/media'));
        }

        $this->info('14. Media files cleared');

        //$env = DotenvEditor::load();
        // $env->setKey('APP_ENV', 'production');
        // $env->setKey('APP_DEBUG', 'false');
        // $env->setKey('APP_CACHE', 'true');
        // $env->setKey('APP_URL', url('/'));
        //$env->setKey('APP_INSTALL', 'true');
        //$env->save();

        $this->info('15. Application installed');

        return true;
    }
}
