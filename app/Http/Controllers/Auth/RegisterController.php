<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'nullable|email|unique:users,email',
        'phone' => 'nullable|string|unique:users,phone|regex:/^[0-9]{10,15}$/',
        'password' => 'required|string|min:6|confirmed',
    ], [
        'email.unique' => 'Barua pepe hii tayari imesajiliwa.',
        'phone.unique' => 'Namba hii tayari imesajiliwa.',
        'phone.regex' => 'Namba ya simu si sahihi.',
    ]);

    // Require at least one of email or phone
    if (!$request->email && !$request->phone) {
        return back()
            ->withErrors(['login' => 'Tafadhali weka barua pepe au namba ya simu.'])
            ->withInput();
    }

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
    ]);

    // ❌ REMOVE AUTO LOGIN
    // Auth::login($user);

    // ✅ REDIRECT TO LOGIN PAGE WITH SUCCESS MESSAGE
    return redirect()
        ->route('login')
        ->with('success', 'Umefanikiwa kujisajili! Tafadhali ingia sasa.');
}
}