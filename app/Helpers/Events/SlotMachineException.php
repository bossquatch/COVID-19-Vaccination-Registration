<?php

namespace App\Helpers\Events;

use Exception;

class SlotMachineException extends Exception {
    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile().': <b>'.$this->getMessage().'</b>';
        return $errorMsg;
    }
}