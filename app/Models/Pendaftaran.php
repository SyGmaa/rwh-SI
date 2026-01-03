<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pendaftaran extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pendaftaran';

    protected $fillable = [
        'jadwal_id',
        'nama_pendaftar',
        'no_tlp',
        'dp',
        'metode_bayar',
        'bukti_bayar',
        'tgl_daftar',
    ];

    protected $casts = [
        'dp' => 'integer',
        'tgl_daftar' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Pendaftaran ' . match ($eventName) {
                'created' => 'baru ditambahkan',
                'updated' => 'telah diperbarui',
                'deleted' => 'telah dihapus',
                default => $eventName,
            });
    }

    public function jadwalKeberangkatan()
    {
        return $this->belongsTo(JadwalKeberangkatan::class, 'jadwal_id');
    }

    public function jemaahs()
    {
        return $this->hasMany(Jemaah::class);
    }

    public function getTotalBiayaAttribute()
    {
        $hargaPaket = $this->jadwalKeberangkatan->paket->harga ?? 0;
        $totalBiayaTambahan = $this->jemaahs->sum('biaya_tambahan');
        return $hargaPaket + $totalBiayaTambahan;
    }

    public function getTotalBayarAttribute()
    {
        $totalCicilan = $this->jemaahs->sum('total_cicilan');
        return $this->dp + $totalCicilan;
    }

    public function getSisaTagihanAttribute()
    {
        return max(0, $this->total_biaya - $this->total_bayar);
    }
}
