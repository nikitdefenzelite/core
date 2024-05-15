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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginForm($role)
    {
        

        if (!Role::where('name', $role)->exists()) {
            abort(404);
        }
        return view('auth.' . $role . '.login', compact('role'));
    }

    public function adminForm()
    {
        $role = 'admin';
        if (!Role::where('name', $role)->exists()) {
            abort(404);
        }
        return view('auth.' . $role . '.login', compact('role'));
    }

    public function otp(Request $request)
    {
        $phone = $request->phone;
        return view('auth.send-otp', compact('phone'));
    }

    public function signup(Request $request)
    {
        if (session()->has('phone')) {
            $phone = session()->get('phone');
            return view('auth.signup', compact('phone'));
        } else {
            return redirect()->back()->with('error', "Something went wrong!");
        }
    }

    public function validateSignup(Request $request)
    {

        $existEmail = User::whereEmail($request->email)->first();
        if ($existEmail) {
            return back()->with('error', 'Email is already Exists!');
        }

        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6'],
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }

        // Account Creation
        $user = User::create(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]
        );
        $user->syncRoles([3]);
        auth()->loginUsingId($user->id);
        return redirect(route('index'));
    }

    public function validateOTP(Request $request)
    {
        $get_otp = implode('', $request->otp);
        if (session()->get('otp') == $get_otp) {
            $phone = session()->get('phone');
            $user = User::where('phone', '!=', null)->wherePhone($phone)->first();
            if ($user) {
                if (auth()->check()) {
                    auth()->logout();
                }

                // Setting Dynamic Session Domain for logging in

                auth()->loginUsingId($user->id);
                return redirect()->route('index');
            } else {
                return redirect(route('signup'));
            }
        } else {
            return back()->with('error', 'The OTP entered is incorrect');
        }
    }

    public function validateLoginByNumber(Request $request)
    {
        if (is_array($request->phone)) {
            $phone = implode('', $request->phone);
        } else {
            $phoneArray = str_split($request->phone);
            $phone = implode('', $phoneArray);
        }
        if (strlen($phone) > 10 || strlen($phone) < 10) {
            return back()->with('error', 'Phone number should be 10 digits!');
        }
        $otp = rand(1000, 9999);
        $phone = $phone;
        session()->put('otp', $otp);
        session()->put('phone', $phone);
        $mailContent = MailSmsTemplate::where('code', '=', "otp-send")->first();
        if ($mailContent) {
            $arr = [
                '{OTP}' => $otp,
            ];
            $msg = DynamicMailTemplateFormatter($mailContent->body, $mailContent->variables, $arr);
            //  sendSms($phone,$msg,$mailContent->footer);
        }

        return redirect(route('otp-index') . '?phone=' . $phone);
    }

    public function login(Request $request, $role)
    {
        $request['password'] = base64_decode($request->input('password'));

        if (!Role::where('name', $role)->exists()) {
            return back()->with('error', 'Role is not found!.');
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 3])) {
                $this->incrementLoginAttempts($request);
                return back()->with('error', 'This account is not activated.');
            } elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
                if (auth()->user()->hasRole($role)) {
                    return redirect(url('admin/dashboard'));
                } else {
                    $this->incrementLoginAttempts($request);
                    Auth::logout();
                    return back()->with('error', 'Account not found with ' . $role . ' role.');
                }
            }
        } else {
            $this->incrementLoginAttempts($request);
            return redirect()->back()->with('error', 'Credentials do not match our database.');
        }
    }

    protected function validateLogin(Request $request)
    {
        if (getSetting('recaptcha') == 0) {
            $validate = 'recaptcha|sometimes';
        } else {
            $validate = 'recaptcha|required';
        }
        $request->validate(
            [
                $this->username() => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response' => $validate,
            ]
        );
    }
    
}
