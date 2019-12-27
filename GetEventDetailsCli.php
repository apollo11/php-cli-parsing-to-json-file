<?php
namespace App\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\functions\ReturnLogs;
use App\functions\JsonValidation;
use App\functions\OutputToJsonFile;
use App\main\GetEventDetails\GetEventDetailsController as EventDetails;
use App\main\LiveBetting\LiveBettingController as LiveEvent;

class GetEventDetailsCli
{
    use ReturnLogs;

    public function executeEventDetailsCli()
    {
        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();
        $eventObj = new LiveEvent();
        $eventID = $eventObj->getEventID();
        $eventDetailsObj = new EventDetails($eventID);

        $data = json_encode($eventDetailsObj->apiResponse());

        if($data == '[]') {
            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {

                $path = __DIR__.'/json/';

                $jsonObj->toJsonFile($path,'LiveEventDetails', $data);

                $this->logMsg('Done initializing request - EVENT DETAILS API ', basename(__FILE__));
                $return =  'Success - 200';

            } else {

                $this->logMsg('There\'s something initializing request - EVENT DETAILS API', basename(__FILE__));
                $return =  'Error - Not a valid Json Format';

            }
        } else {

            $this->logMsg('EMPTY DATA -  EVENT DETAILS API', basename(__FILE__));
            $return =  'RECORDS NOT FOUND';

        }

        return $return;
    }

}
