<?php

namespace App\Features\User;

use App\Models\User;

class GetMyProfileFeature
{
    public function handle(): User
    {
        return auth()->user();
    }
}
