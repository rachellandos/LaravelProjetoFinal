<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchPar = request()->query('search') ? request()->query('search') : null;

        $query = User::select('id', 'name', 'email', 'photo');

        if ($searchPar) {
            $query->where('name', 'LIKE', "%{$searchPar}%")
                ->orWhere('email', 'LIKE', "%{$searchPar}%");
        }

        $users = $query->get();

        // dd( $usersFromDB);

        return view('users.allusers', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createUsers()
    {
        return view('users.createusers');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('userPhotos', $request->photo);
        }

        // depois de validados, inserir na bd
        User::create($request->all());

        return redirect()->route('users.all')->with('message', 'Utilizador criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editUser(string $id)
    {
        $userInfo = User::where('id', $id)->select('name', 'email', 'id', 'photo')->first();

        return view('users.edituser', compact('userInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required|max:50',
            'photo' => 'image'
        ]);

        if ($request->hasFile('photo')) {
            //armazenar no storage e guarda o caminho numa var

            $photo = Storage::putFile('userPhotos', $request->photo);
        } else {
            $user = User::where('id', $request->id)->first();
            $photo = $user->photo;
        }


        User::where('id', $request->id)->update([
            'name' => $request->name,
            'photo' => $photo,
            'updated_at' => now(),
        ]);

        return redirect()->route('users.all')->with('message', 'Utilizador actualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteUsers(string $id)
    {
        User::where('id', $id)->delete();

        return back();
    }
}
