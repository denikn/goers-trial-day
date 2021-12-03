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
    public static function gotResponse($data)
    {
		if(is_array($data)) {
			if ($data->isEmpty()) {
				return self::gotEmptyResponse($data, 'array');
			} else {
				return self::gotSuccessResponse($data);
			}
		} else {
			if ($data) {
				return self::gotSuccessResponse($data);
			} else {
				return self::gotEmptyResponse($data, 'object');
			}
		}
    }

	public static function gotEmptyResponse($data, $type)
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

	public static function gotSuccessResponse($data)
	{
		return response()->json([
			'code' => 200,
			'message' => 'Success.',
			'data' => $data
		], 200);
	}

	public static function createdResponse($data)
    {
		if(is_array($data)) {
			if ($data->isEmpty()) {
				return self::createdEmptyResponse($data, 'array');
			} else {
				return self::createdSuccessResponse($data);
			}
		} else {
			if ($data) {
				return self::createdSuccessResponse($data);
			} else {
				return self::createdEmptyResponse($data, 'object');
			}
		}
    }

	public static function createdEmptyResponse($data, $type)
	{
		if($type == 'array') {
			return response()->json([
				'code' => 406,
				'message' => 'Not found.',
				'data' => []
			], 406);
		} else {
			return response()->json([
				'code' => 406,
				'message' => 'Not found.',
				'data' => ''
			], 406);
		}
	}

	public static function createdSuccessResponse($data)
	{
		return response()->json([
			'code' => 201,
			'message' => 'Success.',
			'data' => $data
		], 201);
	}
}
