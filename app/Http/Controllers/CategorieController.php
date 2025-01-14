<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie;

class CategorieController extends Controller
{
    // Liste toutes les catégories
    public function index()
    {
        $categories = Categorie::all();
        return response()->json($categories);
    }

    // Affiche une catégorie spécifique
    public function show($id)
    {
        $categorie = Categorie::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        return response()->json($categorie);
    }

    // Ajoute une nouvelle catégorie
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_categorie' => 'required|string|max:50|unique:categories,nom_categorie',
        ]);

        $categorie = Categorie::create($validated);

        return response()->json([
            'message' => 'Catégorie créée avec succès.',
            'data' => $categorie,
        ], 201);
    }

    // Met à jour une catégorie
    public function update(Request $request, $id)
    {
        $categorie = Categorie::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        $validated = $request->validate([
            'nom_categorie' => 'required|string|max:50|unique:categories,nom_categorie,' . $id,
        ]);

        $categorie->update($validated);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès.',
            'data' => $categorie,
        ]);
    }

    // Supprime une catégorie
    public function destroy($id)
    {
        $categorie = Categorie::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }

        $categorie->delete();

        return response()->json(['message' => 'Catégorie supprimée avec succès.']);
    }
}
