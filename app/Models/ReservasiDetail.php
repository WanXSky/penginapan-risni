<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservasiDetail extends Model
{
    protected $table = 'reservasi_details';

    protected $fillable = [
        'reservasi_id',
        'kamar_id',
        'jumlah_malam',
        'harga_per_malam',
        'subtotal',
    ];

    protected $casts = [
        'harga_per_malam' => 'integer',
        'subtotal' => 'integer',
    ];

    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class);
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class);
    }
}
