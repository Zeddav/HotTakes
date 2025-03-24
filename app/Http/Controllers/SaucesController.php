<?php

namespace App\Http\Controllers;

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
        return view('sauces.index', compact('sauces'));
    }

    /**
     * Afficher le formulaire pour créer une nouvelle sauce.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sauces.form');
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
    return redirect()->route('sauces.index')->with('success', 'Sauce créée avec succès !');
}

    /**
     * Afficher une sauce spécifique.
     *
     * @param \App\Models\Sauces $sauce
     * @return \Illuminate\View\View
     */
    public function show(Sauces $sauce)
    {

        return view('sauces.show', compact('sauce'));
    }

    /**
     * Afficher le formulaire pour modifier une sauce existante.
     *
     * @param \App\Models\Sauces $sauce
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $sauce = Sauces::findOrFail($id);
        return view('sauces.form', compact('sauce'));
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

    return redirect()->route('sauces.index')->with('success', 'Sauce mise à jour avec succès !');
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
        return redirect()->route('sauces.index')->with('success', 'Sauce supprimée avec succès !');
    }
}
