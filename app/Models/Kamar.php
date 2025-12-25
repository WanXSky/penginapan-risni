<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kamar extends Model
{
    protected $table = 'kamars';

    protected $fillable = [
        'nama_kamar',
        'tipe',
        'harga',
        'deskripsi',
        'fasilitas',
        'preview_360',
        'status',
    ];

    protected $casts = [
        'harga' => 'integer',
    ];

    /**
     * Get all bookings for this room
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Check if room is available
     * Mengecek berdasarkan kolom status di database (tersedia/penuh)
     * 
     * @param string|null $checkinDate Format: Y-m-d (optional, untuk kompatibilitas)
     * @param string|null $checkoutDate Format: Y-m-d (optional)
     * @return bool
     */
    public function isAvailable($checkinDate = null, $checkoutDate = null): bool
    {
        // Cukup cek kolom status saja
        return $this->status === 'tersedia';
    }
}
