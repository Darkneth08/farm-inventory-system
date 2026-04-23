<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'role_name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public static function resolveId(?string $roleName): ?int
    {
        if (empty($roleName)) {
            return null;
        }

        return static::query()
            ->where('role_name', $roleName)
            ->value('id');
    }
}
