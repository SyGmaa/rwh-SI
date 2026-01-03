<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CicilanJemaah extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'cicilan_jemaah';

    protected $fillable = [
        'jemaah_id',
        'kode_cicilan',
        'nominal_cicilan',
        'tgl_bayar',
        'metode_bayar',
        'bukti_bayar',
    ];

    protected $casts = [
        'nominal_cicilan' => 'integer',
        'tgl_bayar' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->setDescriptionForEvent(fn(string $eventName) => 'Cicilan Jemaah ' . match ($eventName) {
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
}
