<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    protected $table = 'reservasis';

    protected $fillable = [
        'user_id',
        'kamar_id',
        'nama_lengkap',
        'email',
        'no_telp',
        'alamat',
        'check_in',
        'check_out',
        'total_harga',
        'status',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total_harga' => 'decimal:2'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function details()
    {
        return $this->hasMany(ReservasiDetail::class);
    }

    public function generateBookingId()
    {
        return 'RES-' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}
