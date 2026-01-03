<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class JadwalKeberangkatan extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jadwal_keberangkatan';

    protected $fillable = [
        'paket_id',
        'tgl_berangkat',
        'kuota',
        'total_kuota',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tgl_berangkat' => 'date',
        'kuota' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Jadwal Keberangkatan ' . match ($eventName) {
                'created' => 'baru ditambahkan',
                'updated' => 'telah diperbarui',
                'deleted' => 'telah dihapus',
                default => $eventName,
            });
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function pendaftaran()
    {
        return $this->hasMany(Pendaftaran::class, 'jadwal_id');
    }
}
