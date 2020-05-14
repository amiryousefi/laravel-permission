# Laravel permission
An easy and flexible Laravel authorization and roles permission management

## Why we need a Laravel permission package
In many projects, we need to implement a role-based permissions management system for our users. Although Laravel has the best tools to manage users' permissions, I build this package to make it simpler, more flexible, and to avoid duplicate work in many web projects built on Laravel.

## How to use
The idea is to use this package as easy and as flexible as possible.
<br>
This package creates a list of all your routes and assigns these permissions list to user roles.
<br>
Although the `laravel-permission` package does most of the work, you could easily extend it and implement your authorization system.


### Installation
Start with installing the package through the composer. Run this command in your terminal:
```
$ composer require amir/laravel-permission
```

After that, you need to run the migration files:
```
$ php artisan migrate
```

### How to authorize user
This package adds a `role_id` to the `users` table.
Roles are stored in the `roles` table. You can assign a role to a user in your administrator panel or by creating a seed file.
<br>
Then, you only need to assign `auth.role` middleware to your routes.

### Assign a route to a role
Besides middleware and other route settings, you can use a `role` key in your route groups to assign a role to your routes.
<br>
You can put your routes for a role in a `Route` group like this:
```php
Route::group([
    'middleware' => 'auth.role',
    'prefix' => ...,
    'role' => 'admin',
    ...
],function (){
    ...
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/product', 'ProductController@index');
    ...
});
```
Of course, you can have as many as route groups like this.
<br>
Then you need to run this artisan command to register all permissions:
```
$ php artisan permissions:generate 
```
This command will register all permissions and assign permissions to the roles.
<br>
If you add a `fresh` option to this command, it will delete all data and generate fresh permissions data:
```
$ php artisan permissions:generate --fresh
```
<br>
Now only users with the proper role can access the route assigned to them.
<br>
Don't forget that this package does not handle assigning roles to the users. You need to handle this in your administration panel or anywhere else you handle your users.
<br>
Again, if you want to add permissions to the routes manually it is not necessary to add `role` key in your route group. You can easily assign permissions to the roles in your administration panel or create another seed file for that. 

### How to create roles
The `php artisan permissions:generate` command will make all roles defined in the routes if they are not exist.
<br>
Also, You can create a seeder to fill the `roles` table. It takes only a `name` field.
<br>
Your `RolesSeeser` file can look like this.
```php
Role::firstOrCreate(['name' => 'admin']);
Role::firstOrCreate(['name' => 'customer']);
```
Don't forget to import the `Role` model in your seeder.
```php
use Amir\Permission\Models\Role;
```

### How to clear permissions
To clear registered permissions you can run this command:
```
$ php artisan permissions:clear
```

You can use this command to clear all permissions data for a specific role
```
$ php artisan permissions:clear --roles role1 role2
```

To erase only permissions list, run `permissions:clear` command with this option:
```
$ php artisan permissions:clear --tables permissions
```

To clear all roles:
```
$ php artisan permissions:clear --tables roles
```

To clear only permissions role relation:
```
$ php artisan permissions:clear --tables permission_role
```
This command erases all permissions assigned to roles, so you can regenerate permissions

Also, you can use these options in combination:
```
$ php artisan permissions:clear --roles admin --tables permission_role
```


## About
I used this Laravel permission management method in my projects for a while. It made manging Laravel permission easy and flexible for me. I hope it helps you as well. All pull requests are welcome.
<br>
Most of the work is based on my article about [Laravel authorization and roles permission management](https://medium.com/swlh/laravel-authorization-and-roles-permission-management-6d8f2043ea20
)
