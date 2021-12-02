<?php

namespace App\Helpers;

class JsonResponse
{
    /**
     * Response parser
     *
     * @param  string $file
     * @param  string $dir
     * @return object
     **/
    public static function httpResponse($data)
    {
		if(is_array($data)) {
			if ($data->isEmpty()) {
				return self::emptyResponse($data, 'array');
			} else {
				return self::successResponse($data);
			}
		} else {
			if ($data) {
				return self::successResponse($data);
			} else {
				return self::emptyResponse($data, 'object');
			}
		}
    }

	public static function emptyResponse($data, $type)
	{
		if($type == 'array') {
			return response()->json([
				'code' => 400,
				'message' => 'Not found.',
				'data' => []
			], 400);
		} else {
			return response()->json([
				'code' => 400,
				'message' => 'Not found.',
				'data' => ''
			], 400);
		}
	}

	public static function successResponse($data)
	{
		return response()->json([
			'code' => 200,
			'message' => 'Success.',
			'data' => $data
		], 200);
	}
}
