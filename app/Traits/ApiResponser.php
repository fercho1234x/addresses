<?php
namespace App\Traits;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json([ 'payload' => $data ], $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll($collection, $code = 200)
    {
        return $this->successResponse($collection, $code);
    }

    protected function showOne($instance, $code = 200)
    {
        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return response()->json(['message' => $message, 'code' => $code]);
    }

}
