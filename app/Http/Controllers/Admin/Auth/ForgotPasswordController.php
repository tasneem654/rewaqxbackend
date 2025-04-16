<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    // عرض صفحة إدخال الإيميل
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    // إرسال الرابط
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::broker('admins')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with('status', trans($status))
                    : back()->withErrors(['email' => trans($status)]);
    }
}
