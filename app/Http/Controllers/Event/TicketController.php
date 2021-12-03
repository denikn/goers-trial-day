<?php

namespace App\Http\Controllers\Event;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Ticket;
use App\Models\Event\EventSession;
use Carbon\Carbon;

class TicketController extends Controller
{
	private $eventSessionData = [];

	function __construct(Ticket $ticket, EventSession $eventSession)
	{
        $this->ticket = $ticket;
		$this->eventSession = $eventSession;
    }

	public function sellingPeriod($selling_period)
	{
		$decodeSellingPeriod = json_decode($selling_period);
		$sellingPeriod = ['start' => $decodeSellingPeriod[0],
						  'end' => $decodeSellingPeriod[1]];

		return $sellingPeriod;
	}

	public function eventSession($event_session_ids)
	{
		foreach(json_decode($event_session_ids) as $event_session_id)
		{
			$eventSessionData[] = $this->eventSession->find($event_session_id);
		}

		return $eventSessionData;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $tickets = $this->ticket->with(['event'])->where('event_id', $event_id)->get();
		$tickets->map(function ($tickets) use ($event_id) {
			// decode selling period
			$tickets['selling_period'] = $this->sellingPeriod($tickets->selling_period);
			$tickets['event_session_ids'] = $this->eventSession($tickets->event_session_ids);
            return $tickets;
        });

		return JsonResponse::gotResponse($tickets);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($event_id, $ticket_id)
    {
        $ticket = $this->ticket->with(['event'])->where([['event_id', $event_id], ['id', $ticket_id]])->first();
		if($ticket) {
			$ticket['selling_period'] = $this->sellingPeriod($ticket->selling_period);
			$ticket['event_session_ids'] = $this->eventSession($ticket->event_session_ids);
		}

		return JsonResponse::gotResponse($ticket);
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
