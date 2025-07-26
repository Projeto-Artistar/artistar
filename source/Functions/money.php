<?php

function moedaReal($value) {
    return number_format($value, 2, ',', '.');
}

function desconverteMoedaReal($value) {
    $value = str_replace('.', '', $value);
    $value = str_replace(',', '.', $value);
    return $value;
}