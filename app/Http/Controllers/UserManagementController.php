<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Team; // Import Team model
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Import DB
use Illuminate\Support\Facades\Notification;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user-management.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user-management.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,user'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            // Create a personal team for the user
            $this->createTeam($user);

            // Send Notification
            $admins = User::all(); // Or filter by role if needed
            $message = "User baru telah didaftarkan: " . $user->name . " (" . $user->role . ")";
            $url = route('user-management.index');
            Notification::send($admins, new SystemNotification($message, $url));
        });

        return redirect()->route('user-management.index')->with('success', 'User created successfully.');
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $userManagement)
    {
        return view('admin.user-management.edit', compact('userManagement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $userManagement)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userManagement->id)],
            'role' => ['required', 'string', 'in:admin,user'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', 'min:8'],
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $userManagement->update($data);

        return redirect()->route('user-management.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $userManagement)
    {
        $userManagement->delete();
        return redirect()->route('user-management.index')->with('success', 'User deleted successfully.');
    }
}
