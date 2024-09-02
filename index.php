<?php
$web = dirname(__FILE__);
require $web.'/source/Core/Core.php';

$core = new Core\Core();
$core->loadPage('home');