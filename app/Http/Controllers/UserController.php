<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $dataUser = User::paginate(5);
        return view('user.index', compact('dataUser'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $filename = null;

        if ($request->hasFile('profile_picture')) {
            // simpan path lengkap: "profiles/xxxx.png"
            $filename = $request->file('profile_picture')->store('profiles', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'profile_picture' => $filename,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }

    public function edit($id)
    {
        $dataUser = User::findOrFail($id);
        return view('user.edit', compact('dataUser'));
    }

    public function update(Request $request, $id)
    {
        $dataUsaer = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $filename = $dataUser->profile_picture;

        if ($request->hasFile('profile_picture')) {

            // hapus file lama
            if ($filename && Storage::disk('public')->exists($filename)) {
                Storage::disk('public')->delete($filename);
            }

            // upload baru → simpan path lengkap
            $filename = $request->file('profile_picture')->store('profiles', 'public');
        }

        $dataUser->update([
            'name' => $request->name,
            'profile_picture' => $filename,
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $dataUser = User::findOrFail($id);

        if ($dataUser->profile_picture && Storage::disk('public')->exists($dataUser->profile_picture)) {
            Storage::disk('public')->delete($dataUser->profile_picture);
        }

        $dataUser->delete();

        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully');
    }
}
