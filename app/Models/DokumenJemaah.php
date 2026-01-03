<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DokumenJemaah extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'dokumen_jemaah';

    protected $fillable = [
        'jemaah_id',
        'jenis_id',
        'file_path',
        'tanggal_upload',
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Dokumen Jemaah ' . match ($eventName) {
                'created' => 'baru ditambahkan',
                'updated' => 'telah diperbarui',
                'deleted' => 'telah dihapus',
                default => $eventName,
            });
    }

    public function jemaah()
    {
        return $this->belongsTo(Jemaah::class);
    }

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'jenis_id');
    }
}
