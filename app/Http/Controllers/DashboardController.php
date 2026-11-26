<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $searchPar = request()->query('search') ? request()->query('search') : null;

        // if ($searchPar) {
        //     $query->where('name', 'LIKE', "%{$searchPar}%")
        //         ->orWhere('species', 'LIKE', "%{$searchPar}%");
        // }

        $petsPending = Pet::approvalStatus('pending')->select('id', 'name', 'city', 'status', 'description', 'species', 'photo', 'created_at', 'approval_status')
            ->get();

        $searchPar = request()->query('search') ? request()->query('search') : null;

        $query = Pet::select('id', 'name', 'city', 'status', 'description', 'species', 'photo', 'created_at', 'approval_status');

        if ($searchPar) {
            $query->where('name', 'LIKE', "%{$searchPar}%")
                ->orWhere('species', 'LIKE', "%{$searchPar}%");
        }

        $pets = $query->get();

        return view('dashboard.home', compact('petsPending', 'pets'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function showPets(string $id)
    {
        $pet = Pet::findOrFail($id);

        return view('dashboard.showPet', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function approve(string $id)
    {
        Pet::findOrFail($id)->update(['approval_status' => 'approved']);

        return redirect()->route('dashboard')->with('message', 'Pedido aprovado.');
    }

    public function reject(string $id)
    {
        abort_unless(Auth::user()->user_type == User::TYPE_ADMIN, 403);

        Pet::findOrFail($id)->update(['approval_status' => 'rejected']);

        return redirect()->route('dashboard')->with('message', 'Pedido rejeitado.');
    }

    /**
     * Update the specified resource in storage.
     */

    public function editPetsD(string $id)
    {
        $pet = Pet::where('id', $id)
            ->select(
                'id',
                'name',
                'description',
                'city',
                'species',
                'photo',
                'status',
                'approval_status',
                'created_at',
                'user_id',
                'approval_status',
            )
            ->first();

        return view('dashboard.editpets', compact('pet'));
    }

    public function updatePetsD(Request $request)
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
            'approval_status' => 'approved',
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('message', 'A modificação foi concluida!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deletePetsD(string $id)
    {
        Pet::where('id', $id)->delete();

        return back();
    }
}
