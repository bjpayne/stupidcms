<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model
{
    public static function for(User $user) : UserAvatar|null
    {
        $model = (new self)
            ->where('user_id', $user->id)
            ->first();

        return $model;
    }
}
