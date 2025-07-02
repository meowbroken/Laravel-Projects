<?php

namespace App\Http\Controllers\Api; 

use Illuminate\Http\Request;
use App\Models\Libretto;

class LibrettoController extends Controller
{
    public function index()
    {
        return Libretto::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return Libretto::create($request->all());
    }

    public function show($id)
    {
        return Libretto::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $libretto = Libretto::findOrFail($id);
        $libretto->update($request->all());

        return $libretto;
    }

    public function destroy($id)
    {
        $libretto = Libretto::findOrFail($id);
        $libretto->delete();

        return response()->noContent();
    }
}