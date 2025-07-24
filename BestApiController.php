<?php

use OpenApi\Attributes as OA;

/**
 * @OA\Info(
 *     title="Best Properties Mohali API",
 *     description="API documentation for Best Properties Mohali application",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="support@bestpropertiesmohali.com"
 *     )
 * )
 * @OA\Server(
 *     url="http://localhost/bestpropertiesmohali",
 *     description="Local development server"
 * )
 * @OA\Server(
 *     url="https://yourdomain.com",
 *     description="Production server"
 * )
 */

class BaseApiController {
    
    /**
     * Standard JSON response format
     */
    protected function jsonResponse($data, $status = 200, $message = 'Success') {
        header('Content-Type: application/json');
        http_response_code($status);
        
        return json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
    
    /**
     * Error response format
     */
    protected function errorResponse($message, $status = 400) {
        return $this->jsonResponse(null, $status, $message);
    }
}
?>