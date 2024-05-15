<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202402-V2.0>
 * @link    <https://www.defenzelite.com>
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
// use PragmaRX\Google2FAQRCode\Google2FA;
use Google2FA;

class MFAController extends Controller
{
    // public function index(){
    //     return view('auth.mfa.index');
    // }
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $user->update(
                [
                'google2fa_secret' => $request->secret_key,
                ]
            );
            return back();
        }
        return back()->with('error', 'User Not Found');
    }

    public function resetForm()
    {
        return view('auth.mfa.reset');
    }

    public function mfaEnabled()
    {
        auth()->user()->update(
            [
            'google2fa_secret' => null
            ]
        );
        Google2FA::logout();
        return back();
    }

    public function mfaReset(Request $request)
    {
        if ($request->password != null && Hash::check($request->password, auth()->user()->password)) {
            $this->mfaEnabled();
            return back();
        } else {
            return back()->with('error', 'Please Enter valid password');
        }
    }
}
