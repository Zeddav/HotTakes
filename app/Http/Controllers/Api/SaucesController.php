<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sauces;
use Illuminate\Http\Request;

class SaucesController extends Controller
{
    public function __construct()
    {
        $this->middleware('upload.check')->only(['store', 'update']);
    }
    /**
     * Afficher toutes les sauces.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $sauces = Sauces::all();
        return response()->json($sauces);
    }



    /**
     * Sauvegarder une nouvelle sauce dans la base de données.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
 

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'manufacturer' => 'required|string|max:255',
        'description' => 'required|string',
        'mainPepper' => 'required|string|max:255',
        'imageUrl' => 'required|file|max:2048',
        'heat' => 'required|integer|min:1|max:10',
    ]);

    $userId = auth()->id("userId");
    $data['userId'] = $userId;

    $file = $request->file('imageUrl');
    $mimeType = $file->getClientMimeType();
    $extension = $file->getClientOriginalExtension();
    $filename = uniqid() . '.' . $extension;
    $file->move('images', $filename);
    $data['imageUrl'] = 'images/' . $filename;


    $test=Sauces::create($data);
    return response()->json([
        'message' => 'Sauce créée avec succès !',
        'sauce' => $sauce
    ], 201);
}

    /**
     * Afficher une sauce spécifique.
     *
     * @param \App\Models\Sauces $sauce
     * @return \Illuminate\View\View
     */
    public function show(Sauces $sauce)
    {

        return response()->json($sauce);
    }

    /**
     * Mettre à jour une sauce dans la base de données.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sauces $sauce
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
{
    // Récupérer la sauce existante par son ID
    $sauce = Sauces::findOrFail($id);
    // Validation des données envoyées
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'manufacturer' => 'required|string|max:255',
        'description' => 'required|string',
        'mainPepper' => 'required|string|max:255',
        'imageUrl' => 'nullable|file|max:2048', 
        'heat' => 'required|integer|min:1|max:10',
    ]);

    // Récupérer l'ID de l'utilisateur
    $userId = auth()->id("userId");
    $data['userId'] = $userId;

    // Vérifier si un nouveau fichier image a été téléchargé
    if ($request->hasFile('imageUrl')) {
        $file = $request->file('imageUrl');
        $mimeType = $file->getClientMimeType();
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid() . '.' . $extension;
        $file->move('images', $filename);
        unlink(public_path($sauce->imageUrl));
        $data['imageUrl'] = 'images/' . $filename;

    } else {
        $data['imageUrl'] = $sauce->imageUrl;
    }

    $sauce->update($data);

    return response()->json([
        'message' => 'Sauce mise à jour avec succès !',
        'sauce' => $sauce
    ], 200);
}

    /**
     * Supprimer une sauce.
     *
     * @param \App\Models\Sauces $sauce
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $sauce = Sauces::findOrFail($id);
        if($sauce->imageUrl){
        unlink(public_path($sauce->imageUrl));
        }
        $sauce->delete();
        return response()->json([
            'message' => 'Sauce supprimée avec succès !'
        ], 200);
    }
}
