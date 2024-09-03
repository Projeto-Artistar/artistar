<?php
$web = $_SERVER['DOCUMENT_ROOT'];
require_once($web.'/source/Models/Home.php');
require_once($web.'/source/Core/Core.php');

$core = new Core();

$home = new Home();
$eventos = $home->Eventos();
$core->loadPage('apis/eventos', ['eventos' => $eventos]);