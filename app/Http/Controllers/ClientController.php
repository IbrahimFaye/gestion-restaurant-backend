<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\Validator;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { $client=Client::all();
        return response()->json($client,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=$request->validate(
            [
                'nom' => 'required|max:20',
                'prenom' => 'required|max:20',
                'telephone' => 'required|max:9',
            ]
        );

        $client=Client::create($validate);
        return response()->json($client,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            try {
            $client =  Client::findOrFail($id);
            $validated =  $request->validate(
                [
                    'nom' => 'required|max:20',
                    'prenom' => 'required|max:20',
                    'telephone' => 'required|max:20',
                    'etat'=> 'required|max:20'
                ]
            );
            $client->update($validated);
            return response()->json($client,200);
        }catch (ModelNotFoundException $ex){
            return response()->json(['error' => 'client introuvable'],404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $client =  Client::findOrFail($id);
            $client->delete();
            return response()->json(null,204);
        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'client introuvable'],404);
        }
    }
}
