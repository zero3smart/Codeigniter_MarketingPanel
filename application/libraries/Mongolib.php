<?php
/**
 * Created by PhpStorm.
 * User: titu
 * Date: 2/8/17
 * Time: 10:11 AM
 */

require  MY_PATH . '/application/third_party/MongoDB.php';
class Mongolib
{

    public function __construct()
    {
        $this->db = MongoApi::getInstance()->getConnection();
    }

}