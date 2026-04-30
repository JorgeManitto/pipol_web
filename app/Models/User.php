<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
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

        'birth_date',
        'workingNow',
        'currentPosition',
        'lastPosition',
        'companies',
        'sectors',
        'education',
        'languages',
        'seniority',
        'profile_level',
        'is_register_end',
        'skills',
        'linkedin_id',
        'documentPhoto',
        'selfie',
        'view_count',
        'stripe_account_id',
        'stripe_connect_status',
        'mentor_amount',
        'transfer_status',
        'stripe_transfer_id',
        'transferred_at',
        'weekly_hours_available',
        'timezone',
        'origin',
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
            'origin' => 'string',
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

    public function reviewsGiven() {
        return $this->hasMany(Reviews::class, 'mentee_id');
    }

    public function reviewsReceived() {
        return $this->hasMany(Reviews::class, 'mentor_id');
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    public function countViewProfile() : int {
        return $this->view_count;
    }
    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }
    public function transactionsReceived()
    {
        return $this->hasMany(Transaction::class, 'receiver_id');
    }
    
    public function transactionsPaid()
    {
        return $this->hasMany(Transaction::class, 'payer_id');
    }

    public function isFraccionalProfessional(): bool
    {
        return $this->role === 'fraccional_professional';
    }

    public function isFraccionalCompany(): bool
    {
        return $this->role === 'fraccional_company';
    }

    public function isFraccional(): bool
    {
        return in_array($this->role, ['fraccional_professional', 'fraccional_company']);
    }

    // Constantes para evitar typos
    public const ROLE_FRACCIONAL_PROFESSIONAL = 'fraccional_professional';
    public const ROLE_FRACCIONAL_COMPANY      = 'fraccional_company';

    // Relaciones para contar badges en el menú
    public function fraccionalEngagementsAsCompany()
    {
        return $this->hasMany(\App\Models\Fraccional\Engagement::class, 'company_id');
    }

    public function fraccionalEngagementsAsProfessional()
    {
        return $this->hasMany(\App\Models\Fraccional\Engagement::class, 'professional_id');
    }
    public function isFromFraccional(): bool
    {
        return $this->origin === 'fraccional';
    }

    public function isFromMentoria(): bool
    {
        return $this->origin === 'mentoria';
    }
}
