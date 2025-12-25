<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';

    protected $fillable = [
        'reservasi_id',
        'metode',
        'jumlah',
        'bukti_bayar',
        'status',
        'verified_at',
        'verified_by'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'verified_at' => 'datetime'
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
