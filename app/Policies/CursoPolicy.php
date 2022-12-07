<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Curso;
use App\Models\RoleNames;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CursoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles)
            || array_search(RoleNames::Role1, $roles->roles);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Curso $curso
     * @return Response|bool
     */
    public function view(User $user, Curso $curso)
    {
        $roles = $user::with('roles');
        return array_search(RoleNames::Admin, $roles->roles)
            || array_search(RoleNames::Role1, $roles->roles);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        $roles = $user::with('roles');
        return array_search(RoleNames::Admin, $roles->roles)
            || array_search(RoleNames::Role2, $roles->roles)
            || array_search(RoleNames::Role3, $roles->roles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Curso $curso
     * @return Response|bool
     */
    public function update(User $user, Curso $curso)
    {
        $roles = $user::with('roles');
        return array_search(RoleNames::Admin, $roles->roles)
            || array_search(RoleNames::Role2, $roles->roles)
            || array_search(RoleNames::Role3, $roles->roles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Curso $curso
     * @return Response|bool
     */
    public function delete(User $user, Curso $curso)
    {
        $roles = $user::with('roles');
        return array_search(RoleNames::Admin, $roles->roles)
            || array_search(RoleNames::Role2, $roles->roles)
            || array_search(RoleNames::Role3, $roles->roles);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Curso $curso
     * @return Response|bool
     */
    public function restore(User $user, Curso $curso)
    {
        $roles = $user::with('roles');
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Curso $curso
     * @return Response|bool
     */
    public function forceDelete(User $user, Curso $curso)
    {
        $roles = $user::with('roles');
        return array_search(RoleNames::Admin, $roles->roles);
    }
}
