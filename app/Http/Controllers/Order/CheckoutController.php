<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Helpers\GeneratorHelper;
use App\Helpers\ConstantHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Order\Checkout;
use App\Models\Event\Ticket;
use App\Http\Controllers\Event\TicketController;
use Carbon\Carbon;

class CheckoutController extends Controller
{
	function __construct(Checkout $checkout, Ticket $ticket)
	{
        $this->checkout = $checkout;
		$this->ticket = $ticket;
		$this->genders = Config::get('constants.genders');
    }

	public function ticket($ticket_ids)
	{
		foreach(json_decode($ticket_ids) as $ticket_id)
		{
			$ticketIdData[] = $this->getTicket($ticket_id);
		}

		return $ticketIdData;
	}

	public function getTicket($ticket_id)
	{
		$ticket = $this->ticket->find($ticket_id);
		$ticket['selling_period'] = TicketController::sellingPeriod($ticket->selling_period);
		$ticket['event_session_ids'] = TicketController::eventSession($ticket->event_session_ids);

		return $ticket;
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

		$input['order_number'] = GeneratorHelper::orderNumber();
		$input['ticket_ids'] = json_encode($request->ticket_ids);
		$input['email'] = $request->email;
		$input['phone'] = $request->phone;
		$input['first_name'] = $request->first_name;
		$input['last_name'] = $request->last_name;
		$input['gender'] = $this->genders[$request->gender];
		$input['expired_at'] = Carbon::now()->addMinutes(30);

        $checkout = $this->checkout->create($input);

		return JsonResponse::createdResponse($checkout);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($checkout_id)
    {
        $checkout = $this->checkout->where('id', $checkout_id)->first();
		$checkout['gender'] = ConstantHelper::gender($checkout->gender);

		if($checkout)
			$checkout['ticket_ids'] = $this->ticket($checkout->ticket_ids);

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
