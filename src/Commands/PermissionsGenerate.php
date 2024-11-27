<?php

namespace Amir\Permission\Commands;

use Amir\Permission\Models\Permission;
use Amir\Permission\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class PermissionsGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:generate {--fresh}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates permissions based on your routes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = $this->options();

        if ($options['fresh']) {
            Permission::query()->delete();
            Role::query()->delete();
        }

        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route){
            $action = $route->getActionname();

            if ($action == "Closure")
                {
                    continue;
                }
            }

            $name = $route->getName();
            $permission = Permission::updateOrCreate(
                ['name'=>$name],
                ['action'=>$action]
            );

            if (key_exists('role', $route->action)) {
                $roles = $route->action['role'];

                if (is_array($roles)) {
                    foreach ($roles as $role) {
                        $role = Role::firstOrCreate(['name'=> $role]);

                        $role->permissions()->syncWithoutDetaching($permission->id);
                    }
                } else {
                    $role = Role::firstOrCreate(['name'=> $roles]);

                    $role->permissions()->syncWithoutDetaching($permission->id);
                }
            }
        }
    }
}
