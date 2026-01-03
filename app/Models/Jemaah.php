<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Jemaah extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jemaah';

    protected $fillable = [
        'pendaftaran_id',
        'nama_jemaah',
        'no_tlp',
        'jadwal_override_id',
        'status_berkas',
        'pax',
        'biaya_tambahan',
        'status_pembayaran',
    ];

    protected $casts = [
        'biaya_tambahan' => 'integer',
        'pax' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Jemaah ' . match ($eventName) {
                'created' => 'baru ditambahkan',
                'updated' => 'telah diperbarui',
                'deleted' => 'telah dihapus',
                default => $eventName,
            });
    }

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class);
    }

    public function jadwalOverride()
    {
        return $this->belongsTo(JadwalKeberangkatan::class, 'jadwal_override_id');
    }

    public function cicilans()
    {
        return $this->hasMany(CicilanJemaah::class);
    }

    public function getTotalCicilanAttribute()
    {
        return $this->cicilans()->sum('nominal_cicilan');
    }

    public function getSisaTagihanAttribute()
    {
        $hargaPaket = $this->pendaftaran->jadwalKeberangkatan->paket->harga ?? 0;
        $totalBiaya = $hargaPaket + $this->biaya_tambahan;
        $totalBayar = $this->pendaftaran->dp + $this->total_cicilan;
        $sisa = max(0, $totalBiaya - $totalBayar);
        if ($sisa == 0 && $this->status_pembayaran != 'Lunas') {
            $this->update(['status_pembayaran' => 'Lunas']);
        }
        return $sisa;
    }

    public function dokumenJemaah()
    {
        return $this->hasMany(DokumenJemaah::class);
    }
}
