<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

use GuzzleHttp\Exception\ClientException;
use Mockery\CountValidator\Exception;

use App\Models\AccountStatus;
use App\Models\EmailNotification;
use App\Models\PaymentDetail;
use App\Models\UserApi;
use App\Models\UserBalance;
use Carbon\Carbon;
use Mail;
use Auth;
use Socialite;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    protected $username = 'email';

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        $user = new User();
        return view('auth.create')->with(compact('user'));
    }


    /**
     * Show the application payment registration form.
     *
     * @return \Illuminate\Http\Response
     */
     /*
    public function getRegisterPayment(Request $request)
    {
        $data = array();
        if($request->has('middleware_error')){
            $data['middleware_error'] = "You haven't added any payment method. Add now to access your account.";
        }
        return view('auth.payment', $data);
    }
    */


    public function getRegisterComplete(Request $request)
    {
        $data = array();
        if($request->session()->get('complete') === 'yes'){
            $data['message'] = "Registration complete. We need to confirm your email. Confirm your email to access your account.";
        } else {
            return response('Unauthorized.', 401);
        }
        return view('auth.confirm', $data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $this->validator($request->all())->validate();

        $secret = \config('recaptcha.api_secret_key');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $request['g-recaptcha-response'],
        ]);

        if(json_decode($response->body())->success){
            return redirect()->back()->with('errors',collect(['Recaptcha check failed!']));
        }

        $user =  $this->create( $request->all() );
        $user->role = 2;
        if(! is_null($request->cookie('refer'))
            && $user->id !== (int) $request->cookie('refer')
            && ! is_null(User::find((int) $request->cookie('refer'))))
        {
            $user->referral_id = (int)$request->cookie('refer');
            $user->save();
        }

        $status = new AccountStatus();
        $status->user_id = $user->id;
        $status->save();

        $balance = new UserBalance();
        $balance->user_id = $user->id;
        $balance->save();

        $email = new EmailNotification();
        $email->user_id = $user->id;
        $email->save();

        $api = new UserApi();
        $api_random = Str::random(32);
        $api->user_id = $user->id;
        $api->key = $api_random . $user->id;
        $api->secret_key = $api_random . $user->id;
        $api->save();

        $this->guard()->login($user, true);

        return redirect('/account/create/address');
    }

    /**
     * Handle a registration network request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegisterNetworks(Request $request)
    {

    }


    public function getRegisterAddress(Request $request)
    {
        $data['user'] = Auth::user();
        if($request->has('middleware_error')){
            $data['error']['middleware'] = "Please enter the required information below in order to continue.";
        }
        return view('auth.address', $data);
    }

    public function postRegisterAddress(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make((array)$request->all(), array(
            'address1' => 'required|min:7|max:255',
            'address2' => 'max:255',
            'city' => 'required|min:3|max:50',
            'state' => 'required|min:3|max:50',
            'zip' => 'required|min:3|max:10',
            'phone' => 'min:7|max:50',
        ));

        if ($validator->fails()) {
            return redirect('/account/create/address')
                ->withErrors($validator)
                ->withInput();
        }

        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->zip = $request->input('zip');
        $user->save();

        $status = AccountStatus::firstOrNew(['user_id' => (int) $user->id]);
        $status->is_contact_info_added = 'yes';
        $status->save();

        $email_confirm_code = Str::random(64);


        $status = AccountStatus::firstOrNew(['user_id' => (int) $user->id]);
        $status->any_payment_method_added = 'yes';
        $status->email_confirm_code = $email_confirm_code;
        $status->save();

        $shouldSend = true;
        if (!is_null($user->status->email_confirm_send_at)) {
            if ($user->status->email_confirm_send_at->addMinutes(5)->isFuture()) {
                $shouldSend = false;
            } else {
                $user->status->email_confirm_send_at = Carbon::now();
            }
        } else {
            $user->status->email_confirm_send_at = Carbon::now();
        }
        $user->save();

        if ($shouldSend) {
            Mail::send('emails.confirm', ['user' => $user, 'email_confirm_code' => $email_confirm_code], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Your confirmation email!');
            });
        }

        //auth()->logout();

        $request->session()->flash('complete', 'yes');
        return redirect('/account/create/complete');
    }


    /**
     * Handle a registration payment request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegisterPayment(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make((array)$request->all(), array(
            'payment_method' => 'required|in:paypal,check,gift_card',
            'payment_method_detail' => 'required'
        ));

        if ($validator->fails()) {
            return redirect('/account/create/payment')
                ->withErrors($validator)
                ->withInput();
        }

        $payment = new PaymentDetail();
        $payment->user_id = $user->id;
        $payment->method = $request->payment_method;
        $payment->send_to = $request->payment_method_detail;
        $payment->save();

        $email_confirm_code = Str::random(64);


        $status = AccountStatus::firstOrNew(['user_id' => (int) $user->id]);
        $status->any_payment_method_added = 'yes';
        $status->email_confirm_code = $email_confirm_code;
        $status->save();

        $shouldSend = true;
        if (!is_null($user->status->email_confirm_send_at)) {
            if ($user->status->email_confirm_send_at->addMinutes(5)->isFuture()) {
                $shouldSend = false;
            } else {
                $user->status->email_confirm_send_at = Carbon::now();
            }
        } else {
            $user->status->email_confirm_send_at = Carbon::now();
        }
        $user->save();

        if ($shouldSend) {
            Mail::send('emails.confirm', ['user' => $user, 'email_confirm_code' => $email_confirm_code], function ($m) use ($user) {
                $m->to($user->email, $user->name)->subject('Your confirmation email!');
            });
        }

        //auth()->logout();

        $request->session()->flash('complete', 'yes');
        return redirect('/account/create/complete');
    }


    public function confirmEmail($id, $email_confirm_code)
    {
        $user = User::find((int) $id);
        if($user->status->email_confirm_code === $email_confirm_code)
        {
            $status = AccountStatus::firstOrNew(['user_id' => (int) $user->id]);
            $status->email_confirmed = 'yes';
            $status->save();

            auth()->login($user);

            return view('auth.success');
        } else {
            return view('auth.fail');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|min:3|max:50|string',
            'lastname'  => 'required|min:3|max:50|string',
            'email'     => 'required|email|max:255|unique:users',
            'password'  => 'required|confirmed|min:6|max:50',
            'terms'     => 'accepted',
            'privacy'   => 'accepted',
            //'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname'  => $data['lastname'],
            'email'     => strtolower( $data['email'] ),
            'password'  => bcrypt($data['password'])
        ]);
    }


    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
