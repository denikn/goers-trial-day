<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Order\Payment;
use App\Models\Order\PaymentMethod;
use App\Models\Order\Checkout;
use App\Models\Event\Ticket;
use App\Http\Controllers\Order\CheckoutController;
use Carbon\Carbon;

class PaymentController extends Controller
{
	function __construct(Payment $payment, PaymentMethod $paymentMethod, Checkout $checkout, Ticket $ticket)
	{
        $this->payment = $payment;
		$this->paymentMethod = $paymentMethod;
		$this->checkout = $checkout;
		$this->ticket = $ticket;
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

	public function decreaseTicketQty($checkout_id)
	{
		$checkout = $this->checkout->with('detail')->find($checkout_id);

		foreach($checkout->detail as $data)
		{
			$input['qty'] = $data->ticket->qty - $data->qty;
			$ticket = $this->ticket->findOrFail($data->id)->update($input);
		}

		return $input;
	}

	public function checkExpiredCheckout($checkout_id)
	{
		$checkout = $this->checkout->with('detail.ticket')->where('id', $checkout_id)->first();

		if(Carbon::now()->lessThanOrEqualTo($checkout->expired_at))
			return true;

		return false;
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		try{
			$this->validate($request, [
				'checkout_id' => 'required',
				'payment_method_id' => 'required'
			]);

			// is expired?
			$checkExpiredCheckout = $this->checkExpiredCheckout($request->checkout_id);
			if($checkExpiredCheckout == false)
				return JsonResponse::preconditionFailedResponse('Your checkout data was expired.');

			$subTotal = $this->countSubTotal($request->checkout_id);
			$paymentMethod = $this->getPaymentMethod($request->payment_method_id);

			$input['checkout_id'] = $request->checkout_id;
			$input['subtotal'] = $subTotal;
			$input['payment_method_id'] = $request->payment_method_id;
			$input['voucher'] = $request->voucher;
			$input['discount'] = $request->discount;
			$input['total'] = $subTotal +  $paymentMethod->service_fee - $request->discount;

			$payment = $this->payment->create($input);
			// decrease ticket qty
			if($payment)
				$decreaseTicketQty = $this->decreaseTicketQty($request->checkout_id);

			return JsonResponse::createdResponse($payment);
		} catch (\Throwable $th) {
            return JsonResponse::preconditionFailedResponse($th);
        }
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

}
