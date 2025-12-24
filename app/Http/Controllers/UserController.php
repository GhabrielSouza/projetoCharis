<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('profile');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ], [
            'current_password.required' => 'O campo senha atual é obrigatório.',
            'password.required' => 'O campo nova senha é obrigatório.',
            'password.confirmed' => 'A confirmação da nova senha não corresponde.',
        ]);

        $user = auth()->user();

        if (!\Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'A senha atual está incorreta.']);
        }

        $user->password = \Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with('status', 'Senha alterada com sucesso.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail já está em uso por outro usuário.',
        ]);

        $user = auth()->user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        $user->save();

        return redirect()->back()->with('status', 'Perfil atualizado com sucesso.');
    }

    public function destroy(Request $request)
    {
        if (auth()->check()) {
            $user = auth()->user();
            auth()->logout();

            // Invalidate the session
            $request->session()->invalidate();

            // Regenerate CSRF token
            $request->session()->regenerateToken();

            // Delete the user
            $user->delete();

            return redirect('/')->with('status', 'Conta excluída com sucesso.');
        }
    }
}
