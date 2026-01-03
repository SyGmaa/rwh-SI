<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity;

class ActivityLogSpatie extends Activity
{
    public function getIconForEvent()
    {
        switch (true) {
            // Login/Logout
            case $this->description === 'Logged in':
                return 'sign-in-alt';
            case $this->description === 'Logged out':
                return 'power-off';
            case $this->description === 'Login failed':
                return 'exclamation-triangle';

                // Jemaah related activities
            case str_contains($this->description, 'baru ditambahkan') && $this->subject_type === \App\Models\Jemaah::class:
                return 'user-plus';
            case str_contains($this->description, 'telah diperbarui') && $this->subject_type === \App\Models\Jemaah::class:
                return 'user-edit';
            case str_contains($this->description, 'telah dihapus') && $this->subject_type === \App\Models\Jemaah::class:
                return 'user-times';

                // Pendaftaran related activities
            case str_contains($this->description, 'baru ditambahkan') && $this->subject_type === \App\Models\Pendaftaran::class:
                return 'user-plus';
            case str_contains($this->description, 'telah diperbarui') && $this->subject_type === \App\Models\Pendaftaran::class:
                return 'user-edit';
            case str_contains($this->description, 'telah dihapus') && $this->subject_type === \App\Models\Pendaftaran::class:
                return 'user-times';

                // DokumenJemaah related activities
            case str_contains($this->description, 'baru ditambahkan') && $this->subject_type === \App\Models\DokumenJemaah::class:
                return 'file-upload';
            case str_contains($this->description, 'telah diperbarui') && $this->subject_type === \App\Models\DokumenJemaah::class:
                return 'file-signature';
            case str_contains($this->description, 'telah dihapus') && $this->subject_type === \App\Models\DokumenJemaah::class:
                return 'file-excel';

                // CicilanJemaah related activities
            case str_contains($this->description, 'baru ditambahkan') && $this->subject_type === \App\Models\CicilanJemaah::class:
                return 'money-bill-wave';
            case str_contains($this->description, 'telah diperbarui') && $this->subject_type === \App\Models\CicilanJemaah::class:
                return 'cash-register';
            case str_contains($this->description, 'telah dihapus') && $this->subject_type === \App\Models\CicilanJemaah::class:
                return 'receipt';

                // Paket related activities
            case str_contains($this->description, 'baru ditambahkan') && $this->subject_type === \App\Models\Paket::class:
                return 'box-open';
            case str_contains($this->description, 'telah diperbarui') && $this->subject_type === \App\Models\Paket::class:
                return 'archive';
            case str_contains($this->description, 'telah dihapus') && $this->subject_type === \App\Models\Paket::class:
                return 'trash';

                // Generic CRUD
            case str_contains($this->description, 'created'):
                return 'plus';
            case str_contains($this->description, 'updated'):
                return 'edit';
            case str_contains($this->description, 'deleted'):
                return 'trash';
            case str_contains($this->description, 'restored'):
                return 'undo';

            default:
                return 'tasks';
        }
    }
}
