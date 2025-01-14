<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'email',
        'verification_code',
        'password',
        'user_type',
        'restricted_steps'
    ];


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
        'user_id' => 'integer',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'restricted_steps' => 'integer',
        'verification_code' => 'integer',
    ];

    public function getUserPaymentDetails()
    {
        return $this->hasMany(UserPaymentDetails::class, 'user_id', 'id');
    }
    public function getUserPaymentDetailsOne()
    {
        return $this->hasone(UserPaymentDetails::class, 'user_id', 'id');
    }
    public function getUserDetails()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }
    public function getCaseCounts()
    {
        return $this->hasOne(CaseCounts::class, 'user_id', 'id');
    }
    public function getRatings()
    {
        return $this->hasMany(CustomerFeedback::class, 'attorney_id', 'id');
    }
    public function getFirstApplicationDetails()
    {
        return $this->hasOne(CaseDetail::class, 'user_id', 'id')->oldest();
    }
    public function getAttorneyType()
    {
        return $this->hasMany(AttorneyType::class, 'user_id', 'id');
    }
    public function getInterestedAttorney()
    {
        return $this->hasOne(CaseAttornies::class, 'attorney_id', 'id');
    }
    public function getAttorneyApplication()
    {
        return $this->hasOne(AttorneyApplication::class, 'user_id', 'id');
    }
    public function getCustomerPaymentDetails()
    {
        return $this->hasOne(UserPaymentDetails::class, 'user_id', 'id');
    }
    public function getAttorneyPaymentDetails()
    {
        return $this->hasOne(UserPaymentDetails::class, 'user_id', 'id');
    }
    public function getPaymentPlan()
    {
        return $this->hasOne(PaymentPlan::class, 'customer_id', 'id')
        ->where('status', 'Enabled')
        ->where('payment_status','PartiallyPaid');
    }

}
