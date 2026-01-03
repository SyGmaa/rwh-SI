<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Paket extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'paket';

    protected $fillable = [
        'jenis_id',
        'nama_paket',
        'harga',
        'jml_hari',
        'keterangan',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'integer',
        'jml_hari' => 'integer',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Paket ' . match ($eventName) {
                'created' => 'baru ditambahkan',
                'updated' => 'telah diperbarui',
                'deleted' => 'telah dihapus',
                default => $eventName,
            });
    }

    public function jenisPaket()
    {
        return $this->belongsTo(JenisPaket::class, 'jenis_id');
    }

    public function jadwalKeberangkatan()
    {
        return $this->hasMany(JadwalKeberangkatan::class, 'paket_id');
    }
}
