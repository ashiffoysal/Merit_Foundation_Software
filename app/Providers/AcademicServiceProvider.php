<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

/**
 * Teacher / Parent / Student / Lesson modules.
 *
 * No role / status permission checks: every logged-in admin can view, create,
 * edit and delete. Access is still limited to logged-in admins by the
 * `auth:admin` middleware on the routes.
 *
 * The two gates are kept (always allow) because the controllers, form requests
 * and Blade @can directives reference them — to add role rules later, change only this file.
 */
class AcademicServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Gate::define('academic.manage', fn ($user = null) => true);
        Gate::define('academic.delete', fn ($user = null) => true);
    }
}
