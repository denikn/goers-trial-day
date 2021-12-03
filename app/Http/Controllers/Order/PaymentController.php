<?php

namespace App\Http\Controllers\Order;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Order\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
	function __construct(Payment $payment)
	{
        $this->payment = $payment;
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
