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
use App\Models\MailSmsTemplate;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | include a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // Override the default sendResetLinkResponse method
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('success', trans($response));
    }

    public function sendResetLinkEmail(Request $request)
    {
        try {
            $user = User::where('email',$request->email)->first();
            if(!$user){
                return back()->with('error','Please provide existing email address.');
            }

            $template = MailSmsTemplate::whereCode('password-reset-mail')->first();
            $token = \Str::random(60);
            $user->update([
                'remember_token' => $token,
            ]);
            $link = route('password.reset',['token' => $token, 'email' => $request->email]);
            if($template){
                $link =
                $arr = [
                    "{link}" => '<a href="' . $link . '" style="display:inline-block; padding:5px 10px; background-color:#3498db; color:#ffffff; text-decoration:none; border-radius:5px;">Reset Password</a>',
                ];
                $this->sendMailTo($request->email,$template,$arr);
                return back()->with('success','A reset link has been sent to your email address');
            }  else{
                return back()->withError('You does not have any template');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'There was an error: ' . $th->getMessage());
        }
    }
}
