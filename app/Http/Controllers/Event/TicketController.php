<?php

namespace App\Http\Controllers\Event;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Ticket;
use Carbon\Carbon;

class TicketController extends Controller
{
	private $eventSessionData = [];

	function __construct(Ticket $ticket)
	{
        $this->ticket = $ticket;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
		try {
			$tickets = $this->ticket->with(['event'])->where('event_id', $event_id)->get();

			return JsonResponse::gotResponse($tickets);
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
    public function show($event_id, $ticket_id)
    {
		try {
			$ticket = $this->ticket->with(['event'])->where([['event_id', $event_id], ['id', $ticket_id]])->first();

			return JsonResponse::gotResponse($ticket);
		} catch (\Throwable $th) {
            return JsonResponse::preconditionFailedResponse($th);
        }
    }

}
