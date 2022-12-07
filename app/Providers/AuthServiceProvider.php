<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Curso;
use App\Models\Student;
use App\Models\Profesor;
use App\Policies\CursoPolicy;
use App\Policies\ProfesorPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Curso::class => CursoPolicy::class,
        Profesor::class => ProfesorPolicy::class,
        Student::class => StudentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
