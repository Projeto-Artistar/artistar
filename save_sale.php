<?php
require_once 'classes/sales.php';

$sales = new Sales();
$inser = $sales->saveSale();

header('Location: index.php');