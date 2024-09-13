<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Log;

class BurgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $burgers = Burger::where('etat','1')->get();
        return response()->json($burgers->map(function ($burger) {
            $burger->imageUrl = asset('images/'.$burger->photo); // Génère l'URL complète de l'image
            return $burger;
        }),200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:20|unique:burgers',
            'prix' => 'required',
            'photo' => 'required',
            'description' => 'required|string',
            'etat' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            Log::info('Fichier reçu : ' . $file->getClientOriginalName());
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;
            $file->move(public_path('images'), $fileName);
            $validatedData['photo'] = $fileName;
        } else {
            Log::error('Aucun fichier reçu dans la requête');
            return response()->json(['message' => 'Photo non fournie'], 422);
            }

        $burger = Burger::create($validatedData);

        return response()->json($burger, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $burger = Burger::findOrFail($id);
        return response()->json($burger, 201);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $burger =  Burger::findOrFail($id);
            $validatedData = $request->validate([
                'nom' => 'required|string|max:20|unique:burgers',
                'prix' => 'required',
                'photo' => 'required',
                'description' => 'required|string',
                'etat' => 'nullable|string',
            ]);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                Log::info('Fichier reçu : ' . $file->getClientOriginalName());
                $extension = $file->getClientOriginalExtension();
                $fileName = time() . '.' . $extension;
                $file->move(public_path('images'), $fileName);
                $validatedData['photo'] = $fileName;
            } else {
                Log::error('Aucun fichier reçu dans la requête');
                return response()->json(['message' => 'Photo non fournie'], 422);
            }
            $burger->update($validatedData);
            return response()->json($burger,200);
        }catch (ModelNotFoundException $ex){
            return response()->json(['error' => 'client introuvable'],404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
   /* public function destroy(string $id)
    {
        try {
            $burger =  Burger::findOrFail($id);
            $burger->delete();
            return response()->json(null,204);
        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'burger introuvable'],404);
        }
    }*/
    public function destroy(string $id){

        try {
            $burger = Burger::findOrFail($id);
            $burger->etat = 0;
            $burger->save();
            return response()->json($burger, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'burger not found'], 404);
        }
    }
}
