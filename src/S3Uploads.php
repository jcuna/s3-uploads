<?php

namespace Jcuna;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Aws\S3\MultipartUploader;
use Aws\Exception\MultipartUploadException;

class S3Uploads
{

    private string $bucketName;
    private S3Client $client;

    public function __construct() {
        $this->bucketName = getenv('S3_BUCKET_NAME');
        $this->client = new S3Client([
            'region' => getenv('AWS_REGION'),
            'version' => '2006-03-01'
        ]);
    }

    public function upload(string $source, string $key): array {

        $uploader = new MultipartUploader($this->client, $source, [
            'bucket' => $this->bucketName,
            'key' => $key,
        ]);

        try {
            $result = $uploader->upload();
            return ['path' => $result['ObjectURL'], 'error' => null];
        } catch (MultipartUploadException $e) {
            return ['path' => null, 'error' => $e->getMessage()];
        }
    }

    public function getObject(string $name, string $destination = null): array {
        try {
            $payload = [
                'Bucket' => $this->bucketName,
                'Key' => $name
            ];
            if (!is_null($destination)) {
                $payload['SaveAs'] = $destination;
            }
            $result = $this->client->getObject($payload);
            return [
                'body' => $result['Body'],
                'error' => null
            ];
        } catch (S3Exception $e) {
            return [
                'body' => null,
                'error' => $e->getMessage()
            ];
        }
    }

    public function listObjects(): \Generator {
        $results = $this->client->getPaginator('ListObjects', [
            'Bucket' => $this->bucketName
        ]);

        foreach ($results->search('Contents[].Key') as $key) {
            yield $key;
        }
    }
}
