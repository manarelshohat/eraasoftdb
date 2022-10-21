<?php

use Eraasoft\Db\db;

include "vendor/autoload.php";



$db = new db("localhost", "root", "", "eraasoftlaravel");
print_r($db->select("category", "*")->first());