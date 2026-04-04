<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordRecoveryController extends Controller
{
    public function verifyIdentity(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'string'],
        ]);

        $phone = str_replace(' ', '', $request->phone);

        $user = User::where('email', $request->email)
                    ->where('phone', $phone)
                    ->first();

        if (!$user) {
            return back()->withErrors(['forgot_identity' => 'Aucun compte ne correspond à ces informations.']);
        }

        // Store identity in session for transition
        session(['reset_user_id' => $user->id]);

        return back()->with('identity_verified', true);
    }

    public function resetPassword(Request $request)
    {
        $userId = session('reset_user_id');

        if (!$userId) {
            return back()->withErrors(['reset_error' => 'Session expirée ou invalide.']);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::findOrFail($userId);
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget('reset_user_id');

        return back()->with('password_reset_success', 'Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.');
    }
}
