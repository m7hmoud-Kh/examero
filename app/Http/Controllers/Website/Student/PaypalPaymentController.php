<?php

namespace App\Http\Controllers\Website\Student;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\User;
use App\Services\PaymentStudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Nafezly\Payments\Classes\PayPalPayment;

class PaypalPaymentController extends Controller
{
    public $paymentService;

    public function __construct(PaymentStudentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function payWithPaypalStudent(Request $request){
        $payment = new PayPalPayment();
        $response = $payment
        ->setAmount($request->amount)
        ->pay();

        $this->paymentService->storeStudentPlan($request->plan_id,$response['payment_id'], PaymentType::PAYAPL->value);

        return response()->json([
            'payment_id' => $response['payment_id'],
            'redirect_url' => $response['redirect_url'],
            'message' => 'Student subscribe with payment Successfully'
        ]);
    }

    public function payment_verify(Request $request){
        $payment = new PayPalPayment();
        $response = $payment->verify($request);

        if($response['success']){
            $this->paymentService->verifyTeacherPlan($response['payment_id']);
            $this->paymentService->verifyStudentPlan($response['payment_id']);
            return Redirect::to(Config::get('app.frontAppUrl')."/student/payment/SuccessPayment");
        }
        return response()->json([
            'message' => 'BAD REQUEST'
        ],Response::HTTP_BAD_REQUEST);
    }
}
