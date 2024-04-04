<?php

namespace App\Observers;

use App\Models\User;

class CustomerObserver
{
    public function creating(User $user): void
    {
        $request = Request();

        if ($request->profile) {
            $user->username = $request->profile['number_id'];
            $user->password = $request->profile['number_id'];
        }
    }
}
