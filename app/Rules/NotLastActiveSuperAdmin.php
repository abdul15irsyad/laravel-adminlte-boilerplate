<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class NotLastActiveSuperAdmin implements Rule
{
    private $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::findOrFail($this->id);
        $super_admins = User::where('id','<>',$user->id)->where('user_status','Y')->whereHas('role',fn($query) => $query->where('role_slug','super-admin'))->get();
        return !($user->user_status == 'Active' && $value == 'Suspend' && $super_admins->count() == 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is must be at least 1 active Super Admin';
    }
}
