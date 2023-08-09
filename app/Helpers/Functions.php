<?php
   
   /**
    * Success response method
    *
    * @param $result
    * @param $message
    * @return \Illuminate\Http\JsonResponse
    */
   function sendResponse($result, $message,$statusCode=200)
   {
       $response = [
           'status' => true,
           'data'    => $result,
           'message' => $message,
       ];
   
       return response()->json($response, $statusCode);
   }
   
   /**
    * Return error response
    *
    * @param       $error
    * @param array $errorMessages
    * @param int   $code
    * @return \Illuminate\Http\JsonResponse
    */
   function sendError($error, $errorMessages = [], $code = 404)
   {
       $response = [
           'status' => false,
           'message' => $error,
       ];
   
    //    !empty($errorMessages) ? $response['data'] = $errorMessages : null;
   
       return response()->json($response, $code);
   }