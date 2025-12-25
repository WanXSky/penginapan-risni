<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    protected $table = 'metode_pembayaran';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'nomor_rekening',
        'nama_rekening',
        'nama_bank',
        'qr_code',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
    
    public function getAccountNumberAttribute()
    {
        return $this->nomor_rekening;
    }
    
    public function getAccountNameAttribute()
    {
        return $this->nama_rekening;
    }
    
    public function getBankNameAttribute()
    {
        return $this->nama_bank;
    }
}
