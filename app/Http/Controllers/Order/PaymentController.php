<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Order\Payment;
use App\Models\Order\PaymentMethod;
use App\Models\Order\Checkout;
use App\Http\Controllers\Order\CheckoutController;
use Carbon\Carbon;

class PaymentController extends Controller
{
	function __construct(Payment $payment, PaymentMethod $paymentMethod, Checkout $checkout)
	{
        $this->payment = $payment;
		$this->paymentMethod = $paymentMethod;
		$this->checkout = $checkout;
    }

	public function countSubTotal($checkout_id)
	{
		$price = 0;
		$checkout = $this->checkout->with('detail')->find($checkout_id);

		foreach($checkout->detail as $data)
		{
			$price = $price + ($data->qty * $data->ticket->price);
		}

		return $price;
	}

	public function getPaymentMethod($payment_method_id)
	{
		return $this->paymentMethod->find($payment_method_id);
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
			'checkout_id' => 'required',
			'payment_method_id' => 'required'
        ]);

		$subTotal = $this->countSubTotal($request->checkout_id);
		$paymentMethod = $this->getPaymentMethod($request->payment_method_id);

		$input['checkout_id'] = $request->checkout_id;
		$input['subtotal'] = $subTotal;
		$input['payment_method_id'] = $request->payment_method_id;
		$input['voucher'] = $request->voucher;
		$input['discount'] = $request->discount;
		$input['total'] = $subTotal +  $paymentMethod->service_fee - $request->discount;

        $payment = $this->payment->create($input);

		return JsonResponse::createdResponse($payment);
    }

	public function paymentValidation(Request $request)
	{
		$this->validate($request, [
			'type' => 'required',
			'card_number' => 'required'
        ]);

		try {
			switch($request->type)
			{
				case 'MasterCard' : $card = (new \LVR\CreditCard\Cards\MasterCard);
				break;
				case 'Visa' : $card = (new \LVR\CreditCard\Cards\Visa);
				break;
			}

			$isValid = $card->setCardNumber($request->card_number)->isValidCardNumber();

			return JsonResponse::gotResponse(json_encode($request->all()));
		} catch (\Throwable $th) {
            return JsonResponse::preconditionFailedResponse($th);
        }
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
