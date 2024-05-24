<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dekanat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DekanatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Dekanat/Index',[
            'dekanat' => Dekanat::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:dekanats,nama',
            'desc' => 'required|string'
        ]);

        Dekanat::create([
            'nama' => $request->nama,
            'desc' => $request->desc
        ]);

        return Redirect::route('dekanat.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dekanat $dekanat)
    {
        $request->validate([
            'nama' => 'string',
            'desc' => 'string'
        ]);

        $dekanat->update([
            'nama' => $request->nama,
            'desc' => $request->desc
        ]);

        return Redirect::route('dekanat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dekanat = Dekanat::find($id);
        $dekanat->delete();
        return Redirect::route('dekanat.index');
    }
}
