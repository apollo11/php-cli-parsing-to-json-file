<?php
/**
 * Created by PhpStorm.
 * User: pacifica
 * Date: 11/6/18
 * Time: 7:03 PM
 */
namespace App\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\functions\ReturnLogs;
use App\functions\JsonValidation;
use App\functions\OutputToJsonFile;
use App\main\UpcomingEvent\UpcomingEventController as UpcomingEvent;

class GetUpcomingEventsCli
{
    use ReturnLogs;

    private $eventObj;

    /**
     * GetUpcomingEventsCli constructor.
     */
    public function __construct()
    {
        $this->eventObj = new UpcomingEvent();
    }

    public function executeUpcomingEvent()
    {
        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();

        $data = json_encode($this->eventObj->apiResponse());

        $path = __DIR__.'/json/';

        if($data != '[]') {
            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {

                $jsonObj->toJsonFile($path,'GetUpcomingEvents', $data);

//                $this->logMsg('Done initializing request - GAME LINES API', basename(__FILE__));
                $return =  'SUCCESS PARSING API RESPONSE TO JSON';

            } else {

//                $this->logMsg('There\'s something initializing request - GAME LINES API', basename(__FILE__));
                $return =  'Error - Not a valid Json Format';
            }
        } else {

            $this->setStart('UPCOMING EVENT LINE');
            $this->setResult($this->debugResponse($data));
            $this->setEnd('UPCOMING EVENT LINE');
            $this->apiLogs('upcoming_event_lines.log');

            $jsonObj->toJsonFile($path,'GetUpcomingEvents', $data);
//            $this->logMsg("EMPTY DATA - GAME LINES API - \n Result:".$data, basename(__FILE__));
            $return =  'RECORDS NOT FOUND';

        }

        return $return;

    }
}

$obj = new GetUpcomingEventsCli();
print $obj->executeUpcomingEvent();
print "\n";
