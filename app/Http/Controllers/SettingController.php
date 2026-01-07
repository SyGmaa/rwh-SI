<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method', 'company_logo']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->hasFile('company_logo')) {
            $request->validate([
                'company_logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path = $request->file('company_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'company_logo'], ['value' => $path]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function backup()
    {
        $tables = [];
        $result = DB::select('SHOW TABLES');

        foreach ($result as $row) {
            $rowArray = (array)$row;
            $tables[] = reset($rowArray);
        }

        $sql = "-- RWH-SI Database Backup\n";
        $sql .= "-- Generated at: " . date('Y-m-d H:i:s') . "\n\n";

        foreach ($tables as $table) {
            $result = \DB::select("SHOW CREATE TABLE $table");
            $sql .= "\n\n" . $result[0]->{'Create Table'} . ";\n\n";

            $rows = \DB::table($table)->get();
            foreach ($rows as $row) {
                $sql .= "INSERT INTO $table VALUES(";
                $values = [];
                foreach ((array)$row as $value) {
                    if (is_null($value)) {
                        $values[] = "NULL";
                    } else {
                        $values[] = "'" . addslashes($value) . "'";
                    }
                }
                $sql .= implode(",", $values) . ");\n";
            }
        }

        $dbName = config('database.connections.mysql.database');
        $fileName = 'backup_' . $dbName . '_' . date('Ymd_His') . '.sql';

        // Send Notification
        $users = User::all();
        $message = "Database backup berhasil dibuat: " . $fileName;
        Notification::send($users, new SystemNotification($message));

        return response($sql)
            ->withHeaders([
                'Content-Type' => 'application/sql',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]);
    }
}
