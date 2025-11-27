<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show the edit profile form
   public function edit($id)
{
    $user = User::findOrFail($id);
    return view('user.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name'  => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'password' => 'nullable|min:4',
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Upload foto baru jika ada
    if ($request->hasFile('profile_picture')) {

        // Hapus foto lama jika ada
        if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        // Simpan foto baru
        $filename = time() . '.' . $request->profile_picture->extension();
        $path = $request->profile_picture->storeAs('profile_pictures', $filename, 'public');

        $user->profile_picture = $path;
    }

    // Update field lainnya
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('user.index')->with('success', 'User updated successfully');
}
}
