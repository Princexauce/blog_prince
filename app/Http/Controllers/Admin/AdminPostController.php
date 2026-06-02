<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AdminPostController extends Controller
{
    private const IMAGE_MAX_KB = 10240;

    public function index()
    {
        $posts = Post::all();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validatePost($request);
            $postData = [
                'titre' => $validated['titre'],
                'contenu' => $validated['contenu'],
                'categorie' => $validated['categorie'] ?? null,
            ];

            if ($path = $this->storeUploadedImage($request)) {
                $postData['image'] = $path;
            }

            Post::create($postData);

            return redirect()->route('admin.posts.index')->with('success', 'Article créé avec succès');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Erreur création article: '.$e->getMessage());

            return back()->withErrors(['error' => 'Erreur lors de la création: '.$e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $this->validatePost($request);
            $post = Post::findOrFail($id);
            $postData = [
                'titre' => $validated['titre'],
                'contenu' => $validated['contenu'],
                'categorie' => $validated['categorie'] ?? null,
            ];

            if ($path = $this->storeUploadedImage($request)) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $postData['image'] = $path;
            }

            $post->update($postData);

            return redirect()->route('admin.posts.index')->with('success', 'Article mis à jour avec succès');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Erreur mise à jour article: '.$e->getMessage());

            return back()->withErrors(['error' => 'Erreur lors de la mise à jour: '.$e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Article supprimé avec succès');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file') && ! $request->file('file')->isValid()) {
            return response()->json([
                'error' => $this->uploadErrorMessage($request->file('file')),
            ], 422);
        }

        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,webp|max:'.self::IMAGE_MAX_KB,
        ]);

        Storage::disk('public')->makeDirectory('posts/images');

        $path = $request->file('file')->store('posts/images', 'public');

        if (! $path) {
            return response()->json(['error' => 'Impossible d\'enregistrer l\'image.'], 500);
        }

        return response()->json([
            'location' => asset('storage/'.$path),
        ]);
    }

    private function validatePost(Request $request): array
    {
        if ($request->hasFile('image') && ! $request->file('image')->isValid()) {
            throw ValidationException::withMessages([
                'image' => $this->uploadErrorMessage($request->file('image')),
            ]);
        }

        return $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:'.self::IMAGE_MAX_KB,
            'categorie' => 'nullable|string|max:255',
        ]);
    }

    private function storeUploadedImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $image = $request->file('image');

        if (! $image->isValid()) {
            throw ValidationException::withMessages([
                'image' => $this->uploadErrorMessage($image),
            ]);
        }

        Storage::disk('public')->makeDirectory('posts');

        $path = $image->store('posts', 'public');

        if (! $path) {
            throw ValidationException::withMessages([
                'image' => 'Impossible d\'enregistrer l\'image. Lancez « php artisan storage:link » et vérifiez les droits sur storage/app/public.',
            ]);
        }

        return $path;
    }

    private function uploadErrorMessage(UploadedFile $file): string
    {
        return match ($file->getError()) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'L\'image dépasse la taille maximale autorisée par PHP. Utilisez « composer run dev » ou augmentez upload_max_filesize dans php.ini (actuellement souvent 2 Mo).',
            UPLOAD_ERR_PARTIAL => 'Le téléversement a été interrompu. Réessayez.',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant sur le serveur (upload_tmp_dir).',
            UPLOAD_ERR_CANT_WRITE => 'Impossible d\'écrire l\'image sur le disque.',
            UPLOAD_ERR_EXTENSION => 'Une extension PHP a bloqué le téléversement.',
            default => 'Le téléversement de l\'image a échoué. Formats acceptés : JPEG, PNG, GIF, WebP (max. 10 Mo).',
        };
    }
}
