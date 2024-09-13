<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use App\Models\Payement;
use Illuminate\Support\Facades\DB;


class PayementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payement= Payement::all();
        return response()->json($payement,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate= $request->validate(
            [
                'montant' => 'required',
                'commande_id'=>'required',
            ]
        );
        $payement=Payement::create($validate);
        return response()->json($payement,201);
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

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function ventesMensuelles()
    {
        $ventes = DB::table('payements')
            ->select(DB::raw('EXTRACT(MONTH FROM created_at) as mois'), DB::raw('SUM(montant) as total'))
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy('mois')
            ->get();

        return response()->json($ventes);
    }
}
