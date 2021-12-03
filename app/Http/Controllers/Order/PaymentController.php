<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Order\Payment;
use App\Models\Order\PaymentMethod;
use App\Http\Controllers\Order\CheckoutController;
use Carbon\Carbon;

class PaymentController extends Controller
{
	function __construct(Payment $payment, PaymentMethod $paymentMethod)
	{
        $this->payment = $payment;
		$this->paymentMethod = $paymentMethod;
    }

	public function countSubTotal($checkout_id)
	{
		$price = 0;
		$checkout = CheckoutController::show($checkout_id);

		foreach($checkout->ticket_ids as $ticket)
		{
			$price = $price + $ticket->price;
		}

		return $price;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request, [
			'ticket_ids' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
            'first_name' => 'required',
			'gender' => 'required',
        ]);

		// get payment method information
		$paymentMethod = $this->paymentMethod->find($request->payment_method_id);

		$input['checkout_id'] = $request->checkout_id;
		$input['subtotal'] = $request->subtotal;
		$input['payment_method_id'] = $request->payment_method_id;
		$input['voucher'] = $request->voucher;
		$input['discount'] = $request->discount;
		$input['total'] = $request->subtotal + $paymentMethod->service_fee - $request->discount;

        $payment = $this->payment->create($input);

		return JsonResponse::createdResponse($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
