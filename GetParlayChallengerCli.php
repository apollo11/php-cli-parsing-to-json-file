<?php
namespace TopBetApp\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use TopBetApp\functions\ReturnLogs;
use TopBetApp\functions\JsonValidation;
use TopBetApp\functions\OutputToJsonFile;
use TopBetApp\main\GetParlayChallenges\GetParlayChallengesController as Parlay;

class GetParlayChallengerCli
{
    use ReturnLogs;

    private $parlayObj;

    public function __construct()
    {
        $this->parlayObj = new Parlay();
    }

    /**
     * Execute CLI
     */

    public function executeGetParlayChallenge()
    {
        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();

        $data = json_encode($this->parlayObj->apiResponse());

        $this->setStart('PARLAY LINES PARSING');
        $this->setResult($this->debugResponse($data));
        $this->setEnd('PARLAY LINES PARSING');
        $this->apiLogs('parlay_lines.log');

        $path = __DIR__.'/json/';

        if($data != '[]') {
            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {

                $jsonObj->toJsonFile($path,'ParlayChallenge', $data);

//                $this->logMsg('Done initializing request - PARLAY API ', basename(__FILE__));
                $return =  'SUCCESS PARSING API RESPONSE TO JSON';

            } else {

//                $this->logMsg('There\'s something initializing request - PARLAY API ', basename(__FILE__));
                $return =  'Error - Not a valid Json Format';

            }
        } else {

            $jsonObj->toJsonFile($path,'ParlayChallenge', $data);
//            $this->logMsg("EMPTY DATA - PARLAY API \n Result: ".$data, basename(__FILE__));
            $return =  'RECORDS NOT FOUND';

        }

        return $return;

    }
}

$obj = new GetParlayChallengerCli();

print $obj->executeGetParlayChallenge();
print "\n";
