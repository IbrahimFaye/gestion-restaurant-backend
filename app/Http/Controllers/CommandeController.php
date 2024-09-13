<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::all();
        return response()->json($commandes,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=$request->validate(
            [
                'nom' => 'required',
                'prenom' => 'required',
                'email' => 'required',
                'telephone' => 'required',
                'burger_id' => 'required',
                'etat' => 'required',
            ]
        );

        $commande=Commande::create($validate);
        return response()->json($commande,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commande =  Commande::findOrFail($id);
        return response()->json($commande,201);
    }
    public function valideCom (string $id)
    {
            try {
            $commande = Commande::findOrFail($id);
            $commande->etat = "terminé";
            $commande->save();
            return response()->json($commande, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Commande not found'], 404);
        }
    }
    public function validePay (string $id)
    {
        try {
            $commande = Commande::findOrFail($id);
            $commande->etat = "payé";
            $commande->save();
            return response()->json($commande, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Commande not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $commande =  Commande::findOrFail($id);
            $validated =  $request->validate(
                [
                    'etat'=> 'required'
                ]
            );
            $commande->update($validated);
            return response()->json($commande,200);
        }catch (ModelNotFoundException $ex){
            return response()->json(['error' => 'commande  introuvable'],404);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $commande = Commande::findOrFail($id);
            $commande->etat = "annuler";
            $commande->save();
            return response()->json($commande, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Commande not found'], 404);
        }
    }

    public  function  commandeTerminer()
    {
        $commandes = Commande::where('etat', 'terminé')->get();
        return response()->json($commandes,200);
    }
    public  function  commandeAnnuler()
    {
        $commandes = Commande::where('etat', 'annuler')->get();
        return response()->json($commandes,200);
    }

    public function getRecette()
    {
       // $date= '2024-08-05';
       $date = Carbon::today();
        $recette  = DB::table('payements')
            ->whereDate('created_at', $date)
            ->sum('montant');
        return response()->json($recette,200);
    }

    public  function  getCommandeValide()
    {
        $commandes = Commande::where('etat', 'terminé')
            ->whereDate('updated_at', Carbon::today())
            ->get();
        return response()->json($commandes,200);
    }
    public  function  getCommandeAnnuler()
    {
        $commandes = Commande::where('etat', 'annuler')
            ->whereDate('updated_at', Carbon::today())
            ->get();
        return response()->json($commandes,200);
    }
    public  function  getCommandeEnCour()
    {
        $commandes = Commande::where('etat', 'en cour')
            ->whereDate('created_at', Carbon::today())
            ->get();
        return response()->json($commandes,200);
    }

}
