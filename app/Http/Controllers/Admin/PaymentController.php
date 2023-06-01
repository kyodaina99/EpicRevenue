<?php

namespace App\Http\Controllers\Admin;
use App\Models\UserPaymentMethod;
use App\Models\UserPaymentDetail;
use App\Models\UserBalance;
use App\Models\UserBalanceHistory;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data['bodyid'] = 'dark';
        $data['users'] = User::with('balance', 'paymentDetail')->get();
        return view('admin.payments.index', $data);
    }

    /**
     * Generate payment.
     *
     * @return Response
     */
    public function generate(Request $request)
    {
        foreach($request->input('users') as $u)
        {
            $user = User::where('id', (int) $u)->with('paymentDetail')->firstOrFail();
            $balance = UserBalance::where('user_id', (int) $user->id)->firstOrFail();
            $paid = $balance->histories()->operationOf('withdraw')->sum('amount');
            $cleared = $balance->histories()->operationOf('add')->cleared()->sum('amount') - $paid;
            if($cleared >= $user->paymentDetail->threshold)
            {
                $cashCleared = $balance->histories()->operationOf('add')->typeOf('cash')->cleared()->sum('amount') -  $balance->histories()->operationOf('withdraw')->typeOf('cash')->sum('amount');
                $referralCleared =  $balance->histories()->operationOf('add')->typeOf('referral')->cleared()->sum('amount') -  $balance->histories()->operationOf('withdraw')->typeOf('referral')->sum('amount');

                if($cashCleared > 0) {
                    $log = UserBalanceHistory::create(array(
                        'user_balance_id' => $balance->id,
                        'type' => 'cash',
                        'operation' => 'withdraw',
                        'amount' => $cashCleared,
                        'pay_to' => $user->paymentDetail->send_to,
                        'method' => $user->paymentDetail->method
                    ));
                    $balance->cash = $balance->cash - $cashCleared;

                }

                if ($referralCleared > 0) {
                    $log = UserBalanceHistory::create(array(
                        'user_balance_id' => $balance->id,
                        'type' => 'referral',
                        'operation' => 'withdraw',
                        'amount' => $referralCleared,
                        'pay_to' => $user->paymentDetail->send_to,
                        'method' => $user->paymentDetail->method
                    ));
                    $balance->referral = $balance->referral - $referralCleared;
                }

                $user->save();
                $balance->save();
            }
        }

        return redirect('/admin/payments');
    }

}
