<?php
namespace Amir\Permission;
use Amir\Permission\Middleware\AuthRoles;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class LaravelPermissionServiceProvider extends ServiceProvider {
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\PermissionsGenerate::class,
                Commands\PermissionsClear::class,
            ]);
        }

        $router->aliasMiddleware('auth.role', AuthRoles::class);
    }
    public function register()
    {
    }
}
?>
