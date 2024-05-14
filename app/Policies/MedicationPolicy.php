<?php

namespace App\Policies;

use App\Models\Medication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MedicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Medication $medication): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'owner';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Medication $medication): bool
    {
        return in_array($user->role, ['owner', 'manager', 'cashier']); // Owner, Manager, and Cashier can update records
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Medication $medication): bool
    {
        return in_array($user->role, ['owner', 'manager']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Medication $medication): bool
    {
        return in_array($user->role, ['owner', 'manager']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Medication $medication): bool
    {
        return $user->role === 'owner'; // Only the owner can permanently delete records
    }
}
