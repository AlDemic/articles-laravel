<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Article;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nick',
        'email',
        'password',
        'avatar',
        'rank_id'
    ];

    //HAS MANY
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function сomments()
    {
        return $this->hasMany(Comment::class);
    }

    public function decisions()
    {
        return $this->hasMany(Decision::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    //get approved power by rank
    public function approvedPower() : int
    {
        return $this->rank->approved_power;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
