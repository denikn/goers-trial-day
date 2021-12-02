<?php

namespace App\Http\Controllers\Event;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Event\Event;
use Carbon\Carbon;

class EventController extends Controller
{
	function __construct(Event $event)
	{
        $this->event = $event;
    }

	public function filterByDate($events, $request)
	{
		if($request->dateFrom AND $request->dateTo)
		{
			$events = $events->whereHas('session', function ($q) use ($request)
			{
                $q->whereBetween(
					"start", [$request->dateFrom, $request->dateTo]
				);
			});
		}

		return $events;
	}

	public function filterByTime($events, $request)
	{
		if($request->timeFrom AND $request->timeTo)
		{
			$events = $events->whereHas('session', function ($q) use ($request)
			{
                $q->whereTime('start', '>=', $request->timeFrom)->whereTime('start', '<=', $request->timeTo);
			});
		}

		return $events;
	}

	public function filterByPrice($events, $request)
	{
		if($request->priceFrom AND $request->priceTo)
		{
			$events = $events->whereHas('ticket', function ($q) use ($request)
			{
                $q->where('price', '>=', $request->priceFrom)->where('price', '<=', $request->priceTo);
			});
		}

		return $events;
	}

	public function filterByInterest($events, $request)
	{
		if($request->interests)
		{
			foreach(json_decode($request->interests) as $interest)
			{
				$events = $events->where('interests', 'LIKE', '%'.$interest.'%');
			}
		}

		return $events;
	}

	public function sortBy($events, $request)
	{
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
					$events = $events;
			}
		}

		return $events;
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

		// applying filter
		$events = $this->filterByDate($events, $request);
		$events = $this->filterByTime($events, $request);
		$events = $this->filterByPrice($events, $request);
		$events = $this->filterByInterest($events, $request);

		// sorting by condition
		$events = $this->sortBy($events, $request);

		$events = $events->get();

		return JsonResponse::httpResponse($events);
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
    public function show($event_id)
    {
        $event = $this->event->with(['session', 'organization', 'ticket'])->find($event_id);

		return JsonResponse::httpResponse($event);
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
