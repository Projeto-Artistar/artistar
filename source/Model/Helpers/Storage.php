<?php

namespace Source\Model\Helpers;

use Aws\S3\S3Client;

class Storage {

    private $s3Client;
    private $publicBucket;
    private $privateBucket;

    public function __construct() {
        $s3Config = STORAGE_CONFIG['s3'];

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

    public function sendFileToPublicBucket(string $filePath, string $fileName) {
        
        try {
            $fullFileName = $this->getPublicBucket()['folder'] . $fileName;
                $result = $this->getS3Client()->putObject([
                'Bucket' => $this->getPublicBucket()['name'],
                'Key' => $fullFileName,
                'SourceFile' => $filePath,
                'ContentType' => mime_content_type($filePath)
            ]);
            $result_arr = $result->toArray(); 
             
            if(!empty($result_arr['ObjectURL'])) {
                $s3_file_link = $this->getPublicBucket()['url'] . $fileName;
            } else { 
                $output = ['code' => 1, 'message' => 'Upload Failed! S3 Object URL not found.']; 
            } 
        } catch (\Aws\S3\Exception\S3Exception $e) { 
            $output = ['code' => 1, 'message' => $e->getMessage()]; 
        } 
         
        return !empty($output) ? $output : ['code' => 200, 'message' => $s3_file_link]; 
    }

    public function sendFileToPrivateBucket(string $filePath, string $fileName) {
        try {
            $fullFileName = $this->getPrivateBucket()['folder'] . $fileName;
                $result = $this->getS3Client()->putObject([
                'Bucket' => $this->getPrivateBucket()['name'],
                'Key' => $fullFileName,
                'SourceFile' => $filePath,
                'ContentType' => mime_content_type($filePath)
            ]);
            $result_arr = $result->toArray(); 
            if(!empty($result_arr['ObjectURL'])) { 
                $s3_file_link = $result_arr['ObjectURL']; 
            } else { 
                $output = ['code' => 1, 'message' => 'Upload Failed! S3 Object URL not found.']; 
            } 
        } catch (\Aws\S3\Exception\S3Exception $e) { 
            $output = ['code' => 1, 'message' => $e->getMessage()]; 
        } 
         
        return !empty($output) ? $output : ['code' => 200, 'message' => $s3_file_link]; 
    }

    public function sendFileToBucket(string $filePath, string $fileName, bool $public = true) {
        if ($public) {
            return $this->sendFileToPublicBucket($filePath, $fileName);
        } else {
            return $this->sendFileToPrivateBucket($filePath, $fileName);
        }
    }

    public function deleteFileFromPublicBucket(string $fileName) {
        $fullFileName = $this->getPublicBucket()['folder'] . $fileName;
        return $this->getS3Client()->deleteObject([
            'Bucket' => $this->getPublicBucket()['name'],
            'Key' => $fullFileName
        ]);
    }

    public function deleteFileFromPrivateBucket(string $fileName) {
        $fullFileName = $this->getPrivateBucket()['folder'] . $fileName;
        return $this->getS3Client()->deleteObject([
            'Bucket' => $this->getPrivateBucket()['name'],
            'Key' => $fullFileName
        ]);
    }

    public function deleteFileFromBucket(string $fileName, bool $public = true) {
        if ($public) {
            return $this->deleteFileFromPublicBucket($fileName);
        } else {
            return $this->deleteFileFromPrivateBucket($fileName);
        }
    }

    public function getFileUrlFromPublicBucket(string $fileName) {
        return $this->getS3Client()->getObjectUrl($this->getPublicBucket(), $fileName);
    }

    public function getFileUrlFromPrivateBucket(string $fileName) {
        return $this->getS3Client()->getObjectUrl($this->getPrivateBucket(), $fileName);
    }

    public function getFileUrlFromBucket(string $fileName, bool $public = true) {
        if ($public) {
            return $this->getFileUrlFromPublicBucket($fileName);
        } else {
            return $this->getFileUrlFromPrivateBucket($fileName);
        }
    }

}