<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPCode extends Model
{
    use HasFactory;
    protected $table = 'otp_codes';

    protected $fillable = [
        'email',
        'code',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function validateCode(string $code): bool
    {
        return $this->code === $code && $this->delete();
    }

    public static function createCode(string $email, int $digits = 6, int $minutes = 3): static
    {
        if ($otp = static::findByEmail($email)) {
            $otp->delete();
        }
        return static::create([
            'email' => $email,
            'code' => str_pad(random_int(0, 10 ** $digits - 1), $digits, '0', STR_PAD_LEFT),
            'expires_at' => now()->addMinutes($minutes),
        ]);
    }

    public static function findByEmail(string $email): ?static
    {
        if ($otp = static::where('email', $email)->first()) {
            if ($otp->expires_at->isPast()) {
                $otp->delete();
                return null;
            }
            return $otp;
        }
        return null;
    }
}
