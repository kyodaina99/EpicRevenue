<?php

namespace App\Http\Controllers\User;

use App\Models\EmailNotification;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Auth;
use App\User;
use Validator;
use Hash;
use DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = User::where('id', Auth::user()->id)->with('emailNotification')->first();
        return view('user.settings.settings')->with(compact('user'));
    }

    /**
     * Display a password reset page.
     *
     * @return Response
     */
    public function password()
    {
        $user = User::find(Auth::user()->id);
        return view('user.settings.password')->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateInfo(Request $request)
    {
        $validator = $this->validateUpdateInfo($request->all());

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find(Auth::user()->id)->update([
            'firstname' => $request->firstname,
            'lastname'  => $request->lastname,
            'address1'  => $request->address1,
            'address2'  => $request->address2,
            'city'      => $request->city,
            'state'     => $request->state,
            'zip'       => $request->zip,
        ]);
        return redirect('/settings/');
    }

    private function validateUpdateInfo(Array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required|min:3|max:50',
            'lastname'  => 'required|min:3|max:50',
            'address1'  => 'max:50',
            'address2'  => 'max:50',
            'city'      => 'max:60',
            'state'     => 'max:30',
            'zip'       => 'max:10'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updateNotifications(Request $request)
    {
        $data = EmailNotification::where('user_id', auth()->user()->id)->firstOrFail();

        if($request->has('leads'))
            $data->leads = 'yes';
        else
            $data->leads = 'no';
        if($request->has('newsletters'))
            $data->newsletters = 'yes';
        else
            $data->newsletters = 'no';

        $data->save();
        return redirect('/settings/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currentPassword'  => 'required|min:6|max:50',
            'password'  => 'required|confirmed|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return redirect('/settings/password')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find(Auth::user()->id);
        if (! Hash::check($request->currentPassword, $user->password)) {
            return redirect('/settings/password')
                ->withErrors(['current' => 'Current Password not matched.'])
                ->withInput();
        }
        $user->fill([
            'password' => Hash::make($request->password)
        ])->save();

        return redirect('/settings/password');
    }
}
