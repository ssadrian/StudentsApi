<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

enum RoleNames: string
{
    case Admin = "Administrator";
    case Role1 = "Role1";
    case Role2 = "Role2";
    case Role3 = "Role3";
}
