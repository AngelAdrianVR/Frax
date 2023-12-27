<?php

namespace App\Http\Controllers;

use App\Models\EmergencyContact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function updatePersonal(Request $request, User $user)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->update($request->all());

        if ($request->photo) {
            $this->deleteProfilePhoto($user);
            $this->storeProfilePhoto($request, $user);
        }
    }

    public function storeProfilePhoto($request, User $user)
    {
        if ($request->file('photo')) {
            // Guarda la imagen en el sistema de archivos.
            $path = $request->file('photo')->store('public/profile-photos');
            // Elimina el prefijo 'public' de la ruta.
            $path = str_replace('public/', '', $path);
            // Actualiza la propiedad 'profile_photo_path' del usuario.
            $user->update([
                'profile_photo_path' => $path,
            ]);
        }
    }

    public function deleteProfilePhoto(User $user)
    {
        $currentPhoto = $user->profile_photo_path;

        if ($currentPhoto) {
            Storage::delete('public/' . $currentPhoto);
            $user->update([
                'profile_photo_path' => null,
            ]);
        }
    }
}
