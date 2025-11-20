<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    protected $fillable = [
      'name',
      'token',
      'abilities',
      'expires_at',
      'ip_address',
      'user_agent',
    ];


    protected $casts = [
      'abilities' => 'json',
      'last_used_at' => 'datetime',
      'expires_at' => 'datetime',
      'ip_address' => 'string',
      'user_agent' => 'string',
    ];

    protected $hidden = [
      'token',
      'ip_address',
      'user_agent',
    ];

    // Tokens activos (no expirados)
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }
    
    // Tokens expirados
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }
    
    // Tokens usados recientemente
    public function scopeRecentlyUsed($query, $days = 7)
    {
        return $query->where('last_used_at', '>=', now()->subDays($days));
    }
}
