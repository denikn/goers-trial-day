<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Helpers\GeneratorHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Ticket;
use App\Models\Order\Checkout;
use App\Models\Order\CheckoutDetail;
use Carbon\Carbon;

class CheckoutController extends Controller
{
	function __construct(Checkout $checkout, CheckoutDetail $checkoutDetail, Ticket $ticket)
	{
		$this->ticket = $ticket;
        $this->checkout = $checkout;
		$this->checkoutDetail = $checkoutDetail;
		$this->genders = Config::get('constants.genders');
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
			'ticket' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
            'first_name' => 'required',
			'gender' => 'required',
        ]);

		try {
			// check maximum qty that can be selected
			$checkMaxTicket = $this->checkMaxTicket($request->ticket);
			if($checkMaxTicket == false)
				return JsonResponse::preconditionFailedResponse('Ticket that selected is more than qty');

			// is ticket sold out?
			$checkQtyTicket = $this->checkQtyTicket($request->ticket);
			if($checkQtyTicket == false)
				return JsonResponse::preconditionFailedResponse('Ticket sold out');

			$input['order_number'] = GeneratorHelper::orderNumber();
			$input['email'] = $request->email;
			$input['phone'] = $request->phone;
			$input['first_name'] = $request->first_name;
			$input['last_name'] = $request->last_name;
			$input['gender'] = $this->genders[$request->gender];
			$input['expired_at'] = Carbon::now()->addMinutes(30);

			$checkout = $this->checkout->create($input);
			$checkoutDetail = $this->storeCheckoutDetail($checkout->id, $request->ticket);

			return JsonResponse::createdResponse($checkout);
		} catch (\Throwable $th) {
            return JsonResponse::preconditionFailedResponse($th);
        }
    }

	public function storeCheckoutDetail($checkout_id, $ticketDetails)
	{
		foreach($ticketDetails as $ticket)
		{
			$input['checkout_id'] = $checkout_id;
			$input['ticket_id'] = $ticket['id'];
			$input['qty'] = $ticket['qty'];
			$checkoutDetail = $this->checkoutDetail->create($input);
		}

		return $checkoutDetail;
	}

	public function checkMaxTicket($ticketDetails)
	{
		foreach($ticketDetails as $ticket)
		{
			$ticketData = $this->ticket->find($ticket['id']);
			if($ticket['qty'] > $ticketData->max_per_person)
				return false;
		}

		return true;
	}

	public function checkQtyTicket($ticketDetails)
	{
		foreach($ticketDetails as $ticket)
		{
			$ticketData = $this->ticket->find($ticket['id']);
			if($ticket['qty'] > $ticketData->qty)
				return false;
		}

		return true;
	}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($checkout_id)
    {
		try {
			$checkout = Checkout::with('detail.ticket')->where('id', $checkout_id)->first();

			return JsonResponse::gotResponse($checkout);
		} catch (\Throwable $th) {
            return JsonResponse::preconditionFailedResponse($th);
        }
    }

}
