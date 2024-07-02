<?php

namespace App\Http\Controllers\Website\Student;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Services\PaymentStudentService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Nafezly\Payments\Classes\PaymobPayment;

class MasterCardController extends Controller
{

    public $paymentService;

    public function __construct(PaymentStudentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function payWithStudentPaymob(Request $request){
        $payment = new PaymobPayment();
        $response = $payment
        ->setUserFirstName(Auth::user()->first_name)
        ->setUserLastName(Auth::user()->last_name)
        ->setUserEmail(Auth::user()->email)
        ->setUserPhone(Auth::user()->phone_number)
        ->setAmount($request->amount)
        ->pay();

        $this->paymentService->storeStudentPlan($request->plan_id,$response['payment_id'], PaymentType::VISA->value);

        return response()->json([
            'payment_id' => $response['payment_id'],
            'redirect_url' => $response['redirect_url'],
            'message' => 'Student subscribe with payment Successfully'
        ]);

    }

    public function paymob_verify(Request $request){
        $payment = new PaymobPayment();
        $response = $payment->verify($request);

        if($response['success']){
            if(Auth::guard('teacher')->user()){
                $this->paymentService->verifyTeacherPlan($response['payment_id']);
                return Redirect::to(Config::get('app.frontAppUrl')."/teacher/payment/SuccessPayment");
            }elseif(Auth::user()){
                $this->paymentService->verifyStudentPlan($response['payment_id']);
                return Redirect::to(Config::get('app.frontAppUrl')."/student/payment/SuccessPayment");
            }
        }

        return response()->json([
            'message' => 'BAD REQUEST'
        ],Response::HTTP_BAD_REQUEST);
    }
}
