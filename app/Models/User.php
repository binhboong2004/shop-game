<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'balance',
        'avatar',
        'level',
        'discount_rate',
        'status',
        'is_verified',
        'activation_token',
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

    public function accounts() { return $this->hasMany(Account::class, 'seller_id'); }
    public function purchases() { return $this->hasMany(Account::class, 'buyer_id'); }
    public function deposits() { return $this->hasMany(Deposit::class); }
    public function withdrawals() { return $this->hasMany(Withdrawal::class, 'agent_id'); }
    public function articles() { return $this->hasMany(Article::class, 'author_id'); }
    public function tickets() { return $this->hasMany(Ticket::class, 'user_id'); }
    public function assignedTickets() { return $this->hasMany(Ticket::class, 'assigned_to'); }
    public function orders() { return $this->hasMany(Order::class, 'buyer_id'); }
    public function sales() { return $this->hasMany(Order::class, 'seller_id'); }
    public function ticketReplies() { return $this->hasMany(TicketReply::class); }
    public function wheelHistories() { return $this->hasMany(WheelHistory::class); }
    public function carts() { return $this->hasMany(Cart::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }
}
