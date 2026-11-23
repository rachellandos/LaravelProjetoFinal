<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $petsPending = Pet::approvalStatus('pending')->select('id', 'name', 'city', 'status', 'description', 'species', 'photo', 'created_at','approval_status')
        ->get();

        $searchPar = request()->query('search') ? request()->query('search') : null;

        $query = Pet::select('id', 'name', 'city', 'status', 'description', 'species', 'photo', 'created_at','approval_status');

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
