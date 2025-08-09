<?php

namespace Source\Model\Helpers;

use Aws\S3\S3Client;

class Storage {

    private $s3Client;
    private $publicBucket;
    private $privateBucket;
    private $publicLocalStorage;
    private $privateLocalStorage;

    public function __construct() {
        $s3Config = STORAGE_CONFIG['s3'];
        $localConfig = STORAGE_CONFIG['local'];

        $s3Client = new S3Client([
            "suppress_php_deprecation_warning" => $s3Config["suppress_php_deprecation_warning"],
            "region" => $s3Config["region"],
            "version" => $s3Config["version"],
            "credentials" => [
                "key" => $s3Config["credentials"]["key"],
                "secret" => $s3Config["credentials"]["secret"]
            ]
        ]);

        $this->setS3Client($s3Client);
        $this->setPublicBucket($s3Config["buckets"]["publico"]);
        $this->setPrivateBucket($s3Config["buckets"]["privado"]);
        $this->setPublicLocalStorage($localConfig["publico"]);
        $this->setPrivateLocalStorage($localConfig["privado"]);
    }

    public function setS3Client(S3Client $s3Client) {
        $this->s3Client = $s3Client;
    }

    public function getS3Client() {
        return $this->s3Client;
    }

    public function setPublicBucket(array $publicBucket) {
        $this->publicBucket = $publicBucket;
    }

    public function getPublicBucket() {
        return $this->publicBucket;
    }

    public function setPrivateBucket(array $privateBucket) {
        $this->privateBucket = $privateBucket;
    }

    public function getPrivateBucket() {
        return $this->privateBucket;
    }

    public function setPublicLocalStorage(array $publicLocalStorage) {
        $this->publicLocalStorage = $publicLocalStorage;
    }

    public function getPublicLocalStorage() {
        return $this->publicLocalStorage;
    }

    public function setPrivateLocalStorage(string $privateLocalStorage) {
        $this->privateLocalStorage = $privateLocalStorage;
    }

    public function getPrivateLocalStorage() {
        return $this->privateLocalStorage;
    }

    public function sendFileToBucket(string $filePath, string $fileName, bool $public = true) {
        $bucket =  ($public ? $this->getPublicBucket() : $this->getPrivateBucket());
        try {
            $fullFileName = $bucket['folder'] . $fileName;
                $result = $this->getS3Client()->putObject([
                'Bucket' => $bucket['name'],
                'Key' => $fullFileName,
                'SourceFile' => $filePath,
                'ContentType' => mime_content_type($filePath)
            ]);
            $result_arr = $result->toArray(); 
            if(!empty($result_arr['ObjectURL'])) { 
                // $s3_file_link = $result_arr['ObjectURL']; 
                $s3_file_link = '{bucketPublico}'.$fileName;
            } else { 
                $output = ['code' => 1, 'message' => 'Upload Failed! S3 Object URL not found.']; 
            } 
        } catch (\Aws\S3\Exception\S3Exception $e) { 
            $output = ['code' => 1, 'message' => $e->getMessage()]; 
        } 
         
        return !empty($output) ? $output : ['code' => 200, 'message' => $s3_file_link]; 
    }

    public function deleteFileFromBucket(string $fileName, bool $public = true) {
        $bucket = $public ? $this->getPublicBucket() : $this->getPrivateBucket();
        $fullFileName = $bucket['folder'] . $fileName;
        return $this->getS3Client()->deleteObject([
            'Bucket' => $bucket['name'],
            'Key' => $fullFileName
        ]);
    }

    public function getFileUrlFromBucket(string $fileName, bool $public = true) {
        $bucket =  ($public ? $this->getPublicBucket() : $this->getPrivateBucket());
        return $this->getS3Client()->getObjectUrl($bucket, $fileName);
    }

    public function getAllFilesFromFolder(string $folderPath, bool $public = true) {
        $bucket =  ($public ? $this->getPublicBucket() : $this->getPrivateBucket());
        $fullFolderPath = $bucket['folder'] . $folderPath;
        $result = $this->getS3Client()->listObjectsV2([
            'Bucket' => $bucket['name'],
            'Prefix' => $fullFolderPath
        ]);
        return isset($result['Contents']) ? $result['Contents'] : [];
    }

    public function cleanFolderFromBucket(string $folderPath, bool $public = true) {
        $files = $this->getAllFilesFromFolder($folderPath, $public);
        $bucket =  ($public ? $this->getPublicBucket() : $this->getPrivateBucket());
        foreach ($files as $file) {
            return $this->getS3Client()->deleteObject([
                'Bucket' => $bucket['name'],
                'Key' => $file['Key']
            ]);
        }
    }

    public function searchPublicBucket($file) {
        return (strpos($file, '{bucketPublico}') !== false);
    }

    public function searchPrivateBucket($file) {
        return (strpos($file, '{bucketPrivado}') !== false);
    }

    public function searchPublicLocalStorage($file) {
        return (strpos($file, '{localPublico}') !== false);
    }

    public function searchPrivateLocalStorage($file) {
        return (strpos($file, '{localPrivado}') !== false);
    }

    public function identifyStorageType($file) {
        if ($this->searchPublicBucket($file)) return $this->getPublicBucket();
        if ($this->searchPrivateBucket($file)) return $this->getPrivateBucket();
        if ($this->searchPublicLocalStorage($file)) return $this->getPublicLocalStorage();
        if ($this->searchPrivateLocalStorage($file)) return $this->getPrivateLocalStorage();
        return NULL;
    }

    function cleanStorageType($file) {
        $file = str_replace('{bucketPublico}', '', $file);
        $file = str_replace('{bucketPrivado}', '', $file);
        $file = str_replace('{localPublico}', '', $file);
        $file = str_replace('{localPrivado}', '', $file);
        return $file;
    }

    public function copyFileFromBucket(string $sourceFileName, string $destinationFileName, bool $public = true) {
        $sourceBucket = $this->identifyStorageType($sourceFileName);
        if (empty($sourceBucket)) {
            return ['code' => 1, 'message' => 'Source bucket not found.'];
        }
        $sourceFileName = $sourceBucket['name'] . '/' . $sourceBucket['folder'] . $this->cleanStorageType($sourceFileName);
        $bucket =  ($public ? $this->getPublicBucket() : $this->getPrivateBucket());
        try {
            $this->getS3Client()->copyObject([
                'Bucket' => $bucket['name'],
                'Key' => "{$bucket['folder']}{$destinationFileName}",
                'CopySource' => $sourceFileName
            ]);
            return ['code' => 200, 'message' => '{bucketPublico}'.$destinationFileName];
        } catch (\Aws\S3\Exception\S3Exception $e) {
            return ['code' => 1, 'message' => $e->getMessage()];
        }
    }

}