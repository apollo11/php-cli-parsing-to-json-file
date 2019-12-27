<?php
namespace TopBetApp\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use TopBetApp\functions\ReturnLogs;
use TopBetApp\functions\JsonValidation;
use TopBetApp\functions\OutputToJsonFile;
use TopBetApp\main\GetSports\GetSportsController as Sports;

class GetEventMenuCli
{
    use ReturnLogs;

    private $sportsObj;

    public function __construct()
    {
        $this->sportsObj = new Sports();
    }

    /**
     * Execute CLI
     */
    public function executeGetSportsCli()
    {

        $jsonObj = new OutputToJsonFile();
        $validation = new JsonValidation();

        $data = json_encode($this->sportsObj->getSportsApi());

        $this->setStart('SPORTS LINES PARSING');
        $this->setResult($this->debugResponse($data));
        $this->setEnd('SPORTS LINES PARSING');
        $this->apiLogs('menu_lines.log');


        $path = __DIR__.'/json/';

        if($data != '[]') {
            $jsonError = $validation->jsonValidate($data);

            if(empty($jsonError)) {

                $jsonObj->toJsonFile($path,'Menu', $data);

                $this->logMsg('Done initializing request - MENU API ', basename(__FILE__));

                $return =  'Success - 200';

            } else {

                $this->logMsg('There\'s something initializing request - MENU API ', basename(__FILE__));

                $return =  'Error - Not a valid Json Format';
            }
        } else {

            $jsonObj->toJsonFile($path,'Menu', $data);
            $this->logMsg("EMPTY DATA - MENU API \n Result: ".$data, basename(__FILE__));
            $return =  'RECORDS NOT FOUND';

        }

        return $return;

    }

}

$obj = new GetEventMenuCli();

print $obj->executeGetSportsCli();
print "\n";