<?php
/**
 * Created by PhpStorm.
 * User: titu
 * Date: 2/8/17
 * Time: 10:11 AM
 */
class MongoApi {

    static protected $_instance;

    protected $db = null;

    final protected function __construct() {
        $m = new MongoClient("mongodb://127.0.0.1:27017");
        $this->db = $m->selectDB( "email_cleanup" );
    }

    static public function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getConnection() {
        return $this->db;
    }

    final protected function __clone() { }
}