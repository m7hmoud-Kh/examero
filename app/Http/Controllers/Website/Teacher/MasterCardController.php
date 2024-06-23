<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Services\PaymentTeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nafezly\Payments\Classes\PaymobPayment;

class MasterCardController extends Controller
{
    //
    public $paymentService;

    public function __construct(PaymentTeacherService $paymentService)
    {
        $this->paymentService = $paymentService;
    }


    public function payWithTeacherPaymob(Request $request)
    {
        $payment = new PaymobPayment();
        $response = $payment
        ->setUserFirstName(Auth::guard('teacher')->user()->first_name)
        ->setUserLastName(Auth::guard('teacher')->user()->last_name)
        ->setUserEmail(Auth::guard('teacher')->user()->email)
        ->setUserPhone(Auth::guard('teacher')->user()->phone_number)
        ->setAmount($request->amount)
        ->pay();

        $this->paymentService->storeTeacherPlan($request->plan_id,$response['payment_id'], PaymentType::VISA->value);

        return response()->json([
            'payment_id' => $response['payment_id'],
            'redirect_url' => $response['redirect_url'],
            'message' => 'Teacher subscribe with payment Successfully'
        ]);
    }


}
