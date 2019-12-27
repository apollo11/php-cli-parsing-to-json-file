<?php
/**
 * Created by PhpStorm.
 * User: pacifica
 * Date: 4/20/18
 * Time: 3:39 PM
 */
namespace App\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\functions\ReturnLogs;
use App\functions\JsonValidation;
use App\functions\OutputToJsonFile;
use App\main\TeaserChallenge\TeaserChallengeController as Teaser;

class GetTeaserChallengerCli
{
    use ReturnLogs;

    private $parlayObj;

    public function __construct()
    {
        $this->parlayObj = new Teaser();
    }

    /**
     * Execute CLI
     */

    public function executeGetTeaserChallenge()
    {
        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();

        $data = json_encode($this->parlayObj->apiResponse());

        $this->setStart('TEASER EVENT PARSING');
        $this->setResult($this->debugResponse($data));
        $this->setEnd('TEASER EVENT PARSING');
        $this->apiLogs('teaser_lines.log');

        $path = __DIR__.'/json/';

        if($data != '[]') {
            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {


                $jsonObj->toJsonFile($path,'TeaserChallenge', $data);

//                $this->logMsg('Done initializing request - TEASER API', basename(__FILE__));
                $return =  'SUCCESS PARSING API RESPONSE TO JSON';

            } else {

//                $this->logMsg('There\'s something initializing request - TEASER API ', basename(__FILE__));
                $return =  'Error - Not a valid Json Format';
            }
        } else {

            $jsonObj->toJsonFile($path,'TeaserChallenge', $data);
//            $this->logMsg("EMPTY DATA -  TEASER API - \n Result: ".$data, basename(__FILE__));
            $return =  'RECORDS NOT FOUND';
        }

        return $return;

    }

}

$obj = new GetTeaserChallengerCli();

print $obj->executeGetTeaserChallenge();
print "\n";