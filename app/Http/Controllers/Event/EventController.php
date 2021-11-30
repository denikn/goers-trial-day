<?php

namespace App\Http\Controllers\Event;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Event;
use App\Models\Event\Ticket;
use Schema;
use Carbon\Carbon;

class EventController extends Controller
{
	function __construct(Event $event, Ticket $ticket)
	{
        $this->event = $event;
		$this->ticket = $ticket;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = $this->event->query();

		$events = $events->with(['session', 'organization', 'ticket']);

		// filter by date
		if($request->dateFrom AND $request->dateTo)
		{
			$events = $events->whereHas('session', function ($q) use ($request)
			{
                $q->whereBetween(
					"start", [$request->dateFrom, $request->dateTo]
				);
			});
		}

		// filter by time
		if($request->timeFrom AND $request->timeTo)
		{
			$events = $events->whereHas('session', function ($q) use ($request)
			{
                $q->whereTime('start', '>=', $request->timeFrom)->whereTime('start', '<=', $request->timeTo);
			});
		}

		// filter by price
		if($request->priceFrom AND $request->priceTo)
		{
			$events = $events->whereHas('ticket', function ($q) use ($request)
			{
                $q->where('price', '>=', $request->priceFrom)->where('price', '<=', $request->priceTo);
			});
		}

		// filter by interests
		if($request->interests)
		{
			foreach(json_decode($request->interests) as $interest)
			{
				$events = $events->where('interests', 'LIKE', '%'.$interest.'%');
			}
		}

		// sorting by condition
		if($request->sortBy)
		{
			switch($request->sortBy)
			{
				case "PRICE_ASC" :
					$events = $events->whereHas('ticket', function ($q) use ($request)
					{
						$q->orderBy('price', 'ASC');
					});
					break;
				case "PRICE_DESC" :
					$events = $events->whereHas('ticket', function ($q) use ($request)
					{
						$q->orderBy('price', 'DESC');
					});
					break;
				case "UPCOMING" :
					$events = $events->whereHas('session', function ($q) use ($request)
					{
						$q->whereDate(
							"start", ">=", Carbon::now()
						);
					});
					break;
				case "NEW_IN" :
					$events = $events->whereHas('session', function ($q) use ($request)
					{
						$q->whereDate(
							"created_at", ">=", Carbon::now()->subDays(7)
						);
					});
					break;
				default :
					$events->get();
			}
		}

		$events = $events->get();

		if ($events->isEmpty()) {
			return response()->json([
				'code' => 400,
				'message' => 'Not found.',
				'data' => []
			], 400);
		} else {
			return response([
				'code' => 200,
				'message' => 'Success.',
				'data' => $events
			], 200);
		}
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
    public function show($id)
    {
        $event = $this->event->with(['session', 'organization', 'ticket'])->find($id);

		if ($event) {
			return response()->json([
				'code' => 200,
				'message' => 'Success.',
				'data' => $event
			], 200);
		} else {
			return response()->json([
				'code' => 400,
				'message' => 'Not found.',
				'data' => []
			], 400);
		}
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
