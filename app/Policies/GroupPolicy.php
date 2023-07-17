<?php

namespace App\Policies;

class GroupPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(): bool
    {
        return true;
    }
}
