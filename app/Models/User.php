<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=[];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function answer()
    {
        return $this->hasMany(UserAnswer::class);
    }
    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function soical_new()
    {
        return $this->hasMany(NewSocial::class, 'user_id');
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id');
    }
    public function mailMessages()
    {
        return $this->hasMany(MailMessage::class, 'user_id');
    }
    

    public function soical()
    {
        return $this->hasOne(MarkterSoical::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id')->withTrashed();
    }
    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function packege()
    {
        return $this->belongsTo(Package::class);
    }

   

}
