<?php
namespace TopBetApp\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use TopBetApp\functions\ReturnLogs;
use TopBetApp\functions\JsonValidation;
use TopBetApp\functions\OutputToJsonFile;
use TopBetApp\main\LiveBetting\LiveBettingController as LiveEvent;
use TopBetApp\cli\GetEventDetailsCli as Details;

class GetEventCli
{
    use ReturnLogs;

    private $eventObj;
    private $eventDetails;

    public function __construct()
    {
        $this->eventObj = new LiveEvent();
        $this->eventDetails = new Details();
    }

    /**
     * Executing CLI
     * @return string
     */
    public function executeEventCli()
    {
        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();

        $data = json_encode($this->eventObj->apiResponse());

        $this->setStart('LIVE EVENT PARSING');
        $this->setResult($this->debugResponse($data));
        $this->setEnd('LIVE EVENT PARSING');
        $this->apiLogs('live_event.log');

        $path = __DIR__.'/json/';

        if($data != "[]") {

            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {

                $jsonObj->toJsonFile($path,'LiveEvent', $data);

//                $this->logMsg('Done initializing request - LIVE EVENT API ',basename(__FILE__));
                $return =  'SUCCESS PARSING API RESPONSE TO JSON';

            } else {

//                $this->logMsg('There\'s something initializing request - LIVE EVENT API', basename(__FILE__));
                $return =  'Error - Not a valid Json Format';

            }
        } else {

            $jsonObj->toJsonFile($path,'LiveEvent', $data);

            $return =  'RECORDS NOT FOUND';

        }

        return $return;

    }

    /**
     * @return string
     */
    public function executeEventDetailsCli()
    {
        return $this->eventDetails->executeEventDetailsCli();

    }

}

$obj = new GetEventCli();

print $obj->executeEventCli();

print "\n";
