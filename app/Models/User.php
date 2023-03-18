<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Attributes\SearchUsingFullText;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'profession',
        'avatar',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'professions' => AsEnumCollection::class.':'.Profession::class,
        'profession' => Profession::class,
        'email_verified_at' => 'datetime',
    ];

    #[SearchUsingFulltext(['name', 'email', 'profession'])]
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'profession' => $this->profession,
        ];
    }
}
