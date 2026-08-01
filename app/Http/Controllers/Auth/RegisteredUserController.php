<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
  public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => 'required|in:joueur,supporter',
        'photo' => 'nullable|image|max:5120',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->assignRole($request->role);

    if ($request->role === 'joueur') {
        $joueur = \App\Models\Joueur::make([
            'user_id' => $user->id,
            'nom' => $request->name,
            'prenom' => '',
        ]);

        if ($request->hasFile('photo')) {
            $joueur->photo = $this->compresserEtStockerPhoto($request->file('photo'));
        }

        $joueur->save();
    }

    event(new Registered($user));

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
}

private function compresserEtStockerPhoto($fichier): string
{
    $manager = new ImageManager(new Driver());
    $image = $manager->read($fichier);
    $image->scaleDown(width: 500);

    // Encode en JPEG compresse en memoire (pas de sauvegarde locale)
    $imageEncodee = (string) $image->toJpeg(75);

   // Upload vers Cloudinary via la facade du package
$resultat = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload(
    'data:image/jpeg;base64,'.base64_encode($imageEncodee),
    ['folder' => 'sama-asc/joueurs']
)->getSecurePath();

return $resultat;
}
}