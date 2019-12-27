<?php
/**
 * Created by PhpStorm.
 * User: pacifica
 * Date: 12/17/18
 * Time: 3:56 PM
 */
namespace App\cli;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\functions\ReturnLogs;
use App\main\Seo\SeoController;

class SeoCli
{
    use ReturnLogs;

    private $seoObj;

    /**
     * SeoCli constructor.
     */
    public function __construct()
    {
        $this->seoObj = new SeoController();
    }

    /**
     * Execute inserting SEO when if not available to the site
     */
    public function executeSeoUpdate()
    {
        $result = $this->seoObj->insertSeoContent();

        return $result;

    }
}

$obj = new SeoCli();
print $obj->executeSeoUpdate();
print "\n";
