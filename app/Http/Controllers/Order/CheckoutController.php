<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Helpers\GeneratorHelper;
use App\Helpers\ConstantHelper;
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
			'ticket' => 'required',
			'email' => 'required|email',
			'phone' => 'required',
            'first_name' => 'required',
			'gender' => 'required',
        ]);

		$checkMaxTicket = $this->checkMaxTicket($request->ticket);
		if($checkMaxTicket == false)
			return JsonResponse::preconditionFailedResponse('Ticket that selected is more than qty');

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($checkout_id)
    {
        $checkout = Checkout::with('detail.ticket')->where('id', $checkout_id)->first();
		$checkout['gender'] = ConstantHelper::gender($checkout->gender);

		return JsonResponse::gotResponse($checkout);
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
