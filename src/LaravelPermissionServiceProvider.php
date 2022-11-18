<?php
namespace Amir\Permission;
use Amir\Permission\Middleware\AuthRoles;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;

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
        Blade::directive('can_access', function ($expression) {
            return "&lt;?php if ({Auth::user()->permission->contains('name',$expression)}) : ?&gt;";
        });

        Blade::directive('endcan_access', function ($expression) {
            return '&lt;?php endif; ?&gt;';
        });
    }
    public function register()
    {
    }
}
?>
