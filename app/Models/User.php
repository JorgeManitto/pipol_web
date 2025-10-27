<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'name',
        'email',
        'password',
        'last_name',
        'role',
        'is_mentor',
        'avatar',
        'country',
        'city',
        'gender',
        'profession',
        'bio',
        'linkedin_url',
        'website',
        'hourly_rate',
        'currency',
        'paypal_email',
        'stripe_connect_id',
        'provider',
        'provider_id',
        'active',
        'bio_laboral',
        'session_complete',
        'average_rating',
        'years_of_experience',
    ];

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

    // User.php
    public function skills()
    {
        return $this->belongsToMany(Skills::class, 'mentor_skills', 'mentor_id', 'skill_id')
                    ->withPivot('experience_years')
                    ->withTimestamps();
    }

    public function sessionsAsMentor()
    {
        return $this->hasMany(Pipol_sessions::class, 'mentor_id');
    }

    public function sessionsAsMentee()
    {
        return $this->hasMany(Pipol_sessions::class, 'mentee_id');
    }

    public function transactionsAsPayer() {
        return $this->hasMany(Transaction::class, 'payer_id');
    }
    public function transactionsAsReceiver() {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }
    public function availabilities() {
        return $this->hasMany(Availabilitie::class, 'mentor_id');
    }
    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

}
