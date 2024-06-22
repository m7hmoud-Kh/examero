<?php

namespace App\Http\Controllers\Website\Teacher;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Services\PaymentTeacherService;
use Illuminate\Http\Request;
use Nafezly\Payments\Classes\PayPalPayment;

class PaypalPaymentController extends Controller
{
    public $paymentService;

    public function __construct(PaymentTeacherService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function payWithPaypalTeacher(Request $request)
    {
        $payment = new PayPalPayment();
        $response = $payment
        ->setAmount($request->amount)
        ->pay();

        $this->paymentService->storeTeacherPlan($request->plan_id,$response['payment_id'], PaymentType::PAYAPL->value);
        
        return response()->json([
            'payment_id' => $response['payment_id'],
            'redirect_url' => $response['redirect_url'],
            'message' => 'Teacher subscribe with payment Successfully'
        ]);
    }


}
