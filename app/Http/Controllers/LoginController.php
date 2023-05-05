<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function verify(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::query()->where('email', $email)->first();
        #Error
        #1. Jika user dengan email input tidak ada
        if ($user == null) {
            return redirect()->route('login');
        }
        #2. User ada, tapi password salah
        if (password_verify($password, $user->password) == false) {
            return redirect()->route('login');
        }
        #Kondisi user dan password benar
        #buat token
        $token = Uuid::uuid4()->toString();
        $user->update([
            'token' => $token
        ]);
        session([
            'token' => $token
        ]);
        return redirect()->route('books.index');
    }
}
