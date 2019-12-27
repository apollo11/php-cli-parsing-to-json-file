<?php
namespace TopBetApp\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use TopBetApp\functions\ReturnLogs;
use TopBetApp\functions\JsonValidation;
use TopBetApp\functions\OutputToJsonFile;
use TopBetApp\main\GameLines\GameLinesController as GameLines;
use TopBetApp\main\GetFeaturedEvent\GetFeaturedEventController as Featured;

class GetGameLinesCli
{
    use ReturnLogs;

    private $eventObj;
    private $featuredEvent;

    public function __construct()
    {
        $this->eventObj = new GameLines();
        $this->featuredEvent = new Featured();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function executeGameLineEventCli()
    {
        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();

        $merge = array_merge($this->featuredEvent->apiResponse(), $this->eventObj->apiResponse());

        $data = json_encode($merge);

        $this->setStart('GAME LINES PARSING');
        $this->setResult($this->debugResponse($data));
        $this->setEnd('GAME LINES PARSING');
        $this->apiLogs('game_lines.log');

        $path = __DIR__.'/json/';

        if($data != '[]') {
            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {

                $jsonObj->toJsonFile($path,'GameLinesEvent', $data);

//                $this->logMsg('Done initializing request - GAME LINES API', basename(__FILE__));
                $return =  'SUCCESS PARSING API RESPONSE TO JSON';

            } else {

//                $this->logMsg('There\'s something initializing request - GAME LINES API', basename(__FILE__));
                $return =  'Error - Not a valid Json Format';
            }
        } else {

            $jsonObj->toJsonFile($path,'GameLinesEvent', $data);
//            $this->logMsg("EMPTY DATA - GAME LINES API - \n Result:".$data, basename(__FILE__));
            $return =  'RECORDS NOT FOUND';

        }

        return $return;

    }

}

$obj = new GetGameLinesCli();

print $obj->executeGameLineEventCli();
print "\n";

