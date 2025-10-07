<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\User;

class PasswordResetController extends Controller
{
    // Paso 1: Solicitar código
    public function sendResetCode(Request $request)
    {
         $request->validate([
        'email' => 'required|email|exists:users,email'
        ], [
        'email.exists' => 'El correo ingresado no está registrado.'
        ]);

        $code = rand(100000, 999999);
        DB::table('password_resets_codes')->updateOrInsert(
            ['email' => $request->email],
            ['code' => $code, 'created_at' => now()]
        );

        /*Mail::raw("Tu código de recuperación es: $code", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Código de recuperación de contraseña');
        });*/

        \Log::info("Código enviado a {$request->email}: $code");

        return response()->json(['message' => 'Código enviado al correo.'], 200);
    }

    // Paso 2: Verificar código
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string'
        ]);

        $record = DB::table('password_resets_codes')
                    ->where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

        if (!$record) {
            return response()->json(['message' => 'El código es incorrecto.'], 400);
        }

        return response()->json(['message' => 'Código verificado correctamente.'], 200);
    }

    // Paso 3: cambiar contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string',
            'password' => 'required|min:6|confirmed'
        ]);

        $record = DB::table('password_resets_codes')
                    ->where('email', $request->email)
                    ->where('code', $request->code)
                    ->first();

        if (!$record) {
            return response()->json(['message' => 'El código es incorrecto.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Eliminar código usado
        DB::table('password_resets_codes')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Contraseña actualizada correctamente.'], 200);
    }
}
