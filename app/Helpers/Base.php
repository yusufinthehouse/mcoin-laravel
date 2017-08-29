<?php

namespace App\Helpers;

class Base {
    /**
     * Function to return input in error notification format
     * @param string $message Error message (mandatory)
     * @return array  $response Error response 
     */
    public static function apiErrorResponse($message = '') {
        // Initiate response array
        $response = ['status' => 'ERROR', 'message' => $message];
        
        // Return response
        return $response;
    }
    
    /**
     * Function to return input in success notification format
     * @param string $message Success message
     * @param arrray $data Array of data  
     * @param string $token Token string
     * @return type
     */
    public static function apiSuccessResponse($message = '', $data = [], $token = '') {
        // Initiate response
        $response = ['status' => 'OK'];
        
        if (!empty($message)) {
            $response['message'] = $message; 
        }
        
        if (count($data) > 0) {            
            $response['data'] = $data; 
        }
        
        if (!empty($token)) {
            $response['token'] = $token; 
        }
        
        // Return response
        return $response;
    }
}

