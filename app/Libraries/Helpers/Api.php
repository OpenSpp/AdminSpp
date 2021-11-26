<?php
namespace App\Libraries\Helpers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Description of Helpers
 *
 * @author muri
 */
class Api {
    
    public function __construct() {
        
    }
    
    /**
     * 
     * @param type $success
     * @param type $error
     * @param type $message
     * @param type $data
     * @return type array
     */
    public static function message($success = false, $message = [], $data = [], $pagination = []) {
        $messageData = [];
        foreach($message as $key => $value) {
            $messageData[$key] = $value;
        }
        
        return [
            'success' => (bool) $success,
            'message' => (array) $messageData,
            'data' => (array) $data,
            'pagination' => (array) $pagination,
        ];
    }
    
}
