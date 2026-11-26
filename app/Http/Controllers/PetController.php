<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchPar = request()->query('search') ? request()->query('search') : null;

        $query = Pet::approvalStatus('approved')->status('perdido')->select(
            'id',
            'name',
            'description',
            'city',
            'species',
            'photo',
            'status'
        );

        if ($searchPar) {
            $query->where('name', 'LIKE', "%{$searchPar}%")
                ->orWhere('species', 'LIKE', "%{$searchPar}%");
        }

        $pets = $query->get();

        return view('pets.allpets', compact('pets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPets()
    {
        return view('pets.createpets');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePets(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'species' => 'required|string',
            'description' => 'string',
            'city' => 'required|string',
            'photo' => 'image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('photo')) {
            $photo = Storage::putFile('petPhotos', $request->photo);
        }

        // depois de validados, inserir na bd
        Pet::create([
            'name' => $request->name,
            'species' => $request->species,
            'description' => $request->description,
            'city' => $request->city,
            'photo' => isset($photo) ? $photo : null,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('pets.all')->with('message', 'A tua publicação será revista e publicada caso seja aprovada!');
    }

    /**
     * Display the specified resource.
     */
    public function showPets(string $id)
    {
        $pet = Pet::findOrFail($id);

        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editPets(string $id)
    {
        $pet = Pet::where('pets.id', $id)
            ->join('users', 'pets.user_id', '=', 'users.id')
            ->select(
                'pets.id',
                'pets.name',
                'pets.description',
                'pets.city',
                'pets.species',
                'pets.photo',
                'pets.status',
                'pets.approval_status',
                'pets.created_at',
                'pets.user_id',
                'pets.approval_status',
                'users.name as user_name',
            )
            ->first();

        return view('pets.editpets', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePets(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'species' => 'required|string',
            'description' => 'string',
            'status' => 'string|in:perdido,encontrado',
            'city' => 'required|string',
            'photo' => 'image|mimes:jpg,jpeg,png'
        ]);

        if ($request->hasFile('photo')) {
            //armazenar no storage e guarda o caminho numa var
            $photo = Storage::putFile('petPhotos', $request->photo);
        } else {
            $pet = Pet::where('id', $request->id)->first();
            $photo = $pet->photo;
        }


        Pet::where('id', $request->id)->update([
            'name' => $request->name,
            'species' => $request->species,
            'description' => $request->description,
            'city' => $request->city,
            'status' => $request->status,
            'photo' => $photo,
            'user_id' => Auth::user()->id,
            'approval_status' => 'pending',
            'updated_at' => now(),
        ]);

        return redirect()->route('pets.all')->with('message', 'O seu pedido de alteração foi enviado para revisão e será aprovado assim que possível!');
    }

    public function myPets()
{
    $pets = Pet::where('user_id', Auth::id())->get();

    return view('pets.mypets', compact('pets'));
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pet::where('id', $id)->delete();

        return back();
    }
}
