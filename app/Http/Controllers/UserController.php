<?php

namespace App\Http\Controllers;

use App\Models\TaxDetail;
use App\User;
use App\Models\Campaign;
use App\Models\Country;
use App\Models\PaymentDetail;
use App\Models\Report;
use App\Models\UserBalance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Validator;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    /*
     * Display Payouts page
     *
     * */
    public function getPayouts()
    {
        $balance = UserBalance::where('user_id', auth()->user()->id)->with('histories')->first();
        $data['unpaid'] = $balance->cash + $balance->referral;
        $data['paid'] = $balance->histories()->operationOf('withdraw')->sum('amount');
        $data['cleared'] = max(0, $balance->histories()->operationOf('add')->where('created_at', '<=', Carbon::now()->subDays(7)->toDateTimeString())->sum('amount') - $data['paid']);
        $data['lifetime'] = $balance->histories()->operationOf('add')->sum('amount');
        $data['withdraws'] = $balance->histories()->operationOf('withdraw')->get();
        $data['tax_details'] = TaxDetail::where('user_id', auth()->user()->id)->first();

        return view('user.payouts')->with($data);
    }

    /*
     * Update payment details
     *
     * */
    public function postPayouts(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'method'   => 'required|in:paypal,check,gift_card',
            'send_to'  => 'required|string|max:255',
            'threshold'=> 'required|integer|min:50|max:500'
        ));

        if ($validator->fails()) {
            return redirect('/payouts')
                ->withErrors($validator)
                ->withInput();
        }

        PaymentDetail::where('user_id', auth()->user()->id)->first()->update([
            'method'   => $request->input('method'),
            'send_to'  => $request->input('send_to'),
            'threshold'=> (float) $request->input('threshold')
        ]);

        return redirect('/payouts')->with('success', 'Updated');
    }



    /*
     * Display Tax Details page
     *
     * */
    public function getTaxDetails()
    {
        $data['tax_details'] = TaxDetail::where('user_id', auth()->user()->id)->first();

        if(!is_null($data['tax_details']) && isset($data['tax_details']->tax_id))
            $data['tax_details']->tax_id = decrypt($data['tax_details']->tax_id);


        return view('user.taxdetails')->with($data);
    }

    /*
     * Update text details
     *
     * */
    public function postTaxDetails(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'name'             => 'required|string|max:255',
            'business_name'    => 'string|max:255',
            'appropriate_type' => 'required|in:Other,Corporation,Partnership,Individual/Sole Proprietor',
            'address'          => 'required|string|max:255',
            'location'         => 'required|string|max:255',
            'tax_id'           => 'required|max:11|min:11',
            'signature'        => 'required|string|max:255',
            'form'             => 'accepted'
        ));

        if ($validator->fails()) {
            return redirect('/taxdetails')
                ->withErrors($validator)
                ->withInput();
        }

        $tax_details = TaxDetail::where('user_id', auth()->user()->id)->first();
        if(is_null($tax_details))
            $tax_details = new TaxDetail();

        $tax_details->name             = $request->input('name');
        $tax_details->user_id          = auth()->user()->id;
        $tax_details->business_name    = $request->input('business_name');
        $tax_details->appropriate_type = $request->input('appropriate_type');
        $tax_details->address          = $request->input('address');
        $tax_details->location         = $request->input('location');
        $tax_details->tax_id           = encrypt($request->input('tax_id'));
        $tax_details->signature        = $request->input('signature');

        $tax_details->save();


        $data['tax_details'] = $tax_details;
        if(!is_null($data['tax_details']) && isset($data['tax_details']->tax_id))
            $data['tax_details']->tax_id = substr(decrypt($data['tax_details']->tax_id), 9, 11);

        $data['success'] = true;

        return view('user.taxdetails')->with($data);
    }


}
