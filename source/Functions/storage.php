<?php

function storageURL($file) {
    $storage = STORAGE_CONFIG;
    $bucketPublico = $storage['s3']['buckets']['publico']['url'];
    $bucketPrivado = $storage['s3']['buckets']['privado']['url'];
    $localPublico = $storage['local']['publico']['url'];
    $file = str_replace('{bucketPublico}', $bucketPublico, $file);
    $file = str_replace('{bucketPrivado}', $bucketPrivado, $file);
    $file = str_replace('{localPublico}', $localPublico, $file);
    return $file;
}