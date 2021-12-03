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
        $tickets = $this->ticket->with(['event'])->where('event_id', $event_id)->get();

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
