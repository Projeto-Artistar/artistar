<?php
global $db;

define("PROJETO", "artistar");

define("ROOT", 'http://'.$_SERVER['HTTP_HOST']."/".PROJETO);
define("KEY", "Art1st4r-C4t-S0u1");


//home
$active = PROJETO == str_replace('/' ,'', $_SERVER['REQUEST_URI']) ? "ative" : "";
define("ACTIVE", $active);

$host = $_SERVER['HTTP_HOST'];
// $raizSetup = dirname( __FILE__, 2)."/setup";

// $webSetup = preg_split('@(WEB|web)@', __FILE__, -1, PREG_SPLIT_DELIM_CAPTURE);
// $root = (string) rtrim($webSetup[0], '\\/');
// $root = strtr($root, '\\', '/');
// $raizSetup = $root.'/setup';


// if (file_exists("$raizSetup/$host.json")) {
//     $setup = file_get_contents("$raizSetup/$host.json");
// } else {
//     $setup = file_get_contents("$raizSetup/default.json");
// }

// $setup = json_decode($setup, true);

// $host = $setup['db']['host'];
// $db = $setup['db']['name'];
// $user = $setup['db']['user'];
// $password = $setup['db']['pass'];
// $bucket['url'] = $setup['storage']['publico']['url'];
// $port = $setup['db']['port'];

// define("BUCKET_URL", $bucket['url']);
define('DETALHES', '#CEA506');
define('FUNDOICONE', '#E6ECF0');
define('PRINCIPAL', '#071641');
define('FUNDONAVHOVER', '#010242');

// try{
    
//     $db = new PDO("mysql:host=$host;dbname=$db;port=$port;charset=utf8;", $user, $password, array(
//         PDO::MYSQL_ATTR_FOUND_ROWS => true, 
//         PDO::ATTR_TIMEOUT => 60, 
//         PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
//     ));
//     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// }catch(PDOException $e){
//     die($e->getMessage());
// }


function url($path)
{
    if ($path) {
        return ROOT . "/{$path}";
    }
    return ROOT;
}

// function getBucket($path){
//     if($path){
//         return explode("/datafiles", BUCKET_URL)[0]."/{$path}";
//     }
//     return explode("/datafiles", BUCKET_URL)[0];
// }