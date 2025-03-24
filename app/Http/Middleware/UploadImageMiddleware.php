<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UploadImageMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        // Vérifier si la requête contient un fichier
        if ($request->hasFile('imageUrl')) {

        // Récupérer le fichier
        $file = $request->file('imageUrl');

        // Liste des types MIME autorisés (sans PDF)
        $allowedMimeTypes = [
            'image/jpeg', 'image/png', 'image/jpg', 'image/gif',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        // Liste des extensions autorisées (sans PDF)
        $allowedExtensions = ['jpeg', 'png', 'jpg', 'gif', 'doc', 'docx'];

        // Vérifier le type MIME du fichier (on exclut le PDF ici)
        if (!in_array($file->getClientMimeType(), $allowedMimeTypes)) {
            return back()->with('error', 'Type de fichier non autorisé. Seuls les fichiers JPEG, PNG, JPG, GIF, Word sont autorisés.');
        }

        // Vérifier l'extension du fichier
        $fileExtension = $file->getClientOriginalExtension();
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            return back()->with('error', 'Extension de fichier non autorisée. Seuls les fichiers avec les extensions : jpeg, png, jpg, gif, doc, docx sont autorisés.');
        }
    }

        // Si tout est valide, continuer la requête
        return $next($request);
    }
}
