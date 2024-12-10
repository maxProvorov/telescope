<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\MethodEnum;

class UserSetting extends Model
{
    protected $fillable = ['user_id', 'method'];

    protected $casts = [
        'method' => MethodEnum::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
