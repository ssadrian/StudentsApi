<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RoleNames;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $curso
     * @return Response|bool
     */
    public function view(User $user, User $curso)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $curso
     * @return Response|bool
     */
    public function update(User $user, User $curso)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $curso
     * @return Response|bool
     */
    public function delete(User $user, User $curso)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $curso
     * @return Response|bool
     */
    public function restore(User $user, User $curso)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $curso
     * @return Response|bool
     */
    public function forceDelete(User $user, User $curso)
    {
        $roles = $user::with("roles");
        return array_search(RoleNames::Admin, $roles->roles);
    }
}
