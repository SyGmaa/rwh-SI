<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class JenisDokumen extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jenis_dokumen';

    protected $fillable = [
        'nama_jenis',
        'deskripsi',
        'wajib_upload',
        'is_active',
    ];

    protected $casts = [
        'wajib_upload' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Jenis Dokumen ' . match ($eventName) {
                'created' => 'baru ditambahkan',
                'updated' => 'telah diperbarui',
                'deleted' => 'telah dihapus',
                default => $eventName,
            });
    }
}
