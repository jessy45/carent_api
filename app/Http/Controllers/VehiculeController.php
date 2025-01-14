<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;

class VehiculeController extends Controller
{
    // Liste tous les véhicules
    public function index()
    {
        $vehicules = Vehicule::all();
        return response()->json($vehicules);
    }

    // Affiche un véhicule spécifique
    public function show($id)
    {
        $vehicule = Vehicule::find($id);
        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }
        return response()->json($vehicule);
    }

    public function store(Request $request)
    {
        // Validation des données entrantes
        $validated = $request->validate([
            'categorie_id' => 'required|integer|exists:categories,categorie_id',
            'marque' => 'required|string|max:50',
            'modele' => 'required|string|max:50',
            'annee' => 'required|integer',
            'immatriculation' => 'required|string|max:20|unique:vehicules,immatriculation',
            'type_vehicule' => 'required|string|max:50',
            'prix_journalier' => 'required|numeric',
            'image_url' => 'nullable|string',
        ]);

        // Création du véhicule avec les données validées
        $vehicule = Vehicule::create($validated);

        // Retourne la réponse JSON
        return response()->json([
            'message' => 'Véhicule créé avec succès.',
            'data' => $vehicule,
        ], 201);
    }


    // Met à jour un véhicule
    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::find($id);
        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }
        $vehicule->update($request->all());
        return response()->json($vehicule);
    }

    // Supprime un véhicule
    public function destroy($id)
    {
        $vehicule = Vehicule::find($id);
        if (!$vehicule) {
            return response()->json(['message' => 'Véhicule non trouvé'], 404);
        }
        $vehicule->delete();
        return response()->json(['message' => 'Véhicule supprimé']);
    }
}
