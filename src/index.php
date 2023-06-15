<?php
require 'vendor/autoload.php';

/**
 * AWS utiliza getenv para acceder las variables del sistema
 * Por lo tanto tengo que usar createUnsafeImmutable
 */
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

use Jcuna\S3Uploads;
/**
 * @Example
 */
$s3Uploads = new S3Uploads();
$filePath = dirname(__DIR__) . '/random.pdf';

$splitPath = explode('/', $filePath);
/**
 * El nombre de archivo en el destino de s3
 * El nombre puede incluir un path como 'destino/donde/se-guarda/mi-archivo.pdf'
 */
$targetKey = end($splitPath);

/**
 * Subir un object/archivo
 * Objeto en $uploadedFile['path] es un string que representa el path en s3
 */
$uploadedFile = $s3Uploads->upload($filePath, $targetKey);
var_dump('archivo guardado en s3', $uploadedFile);

/**
 * descargar archivo
 * Objeto en $downloadedFile['body'] es de tipo GuzzleHttp\Psr7\Stream
 */
$downloadedFile = $s3Uploads->getObject($targetKey);
var_dump('archivo desgargado de s3', $downloadedFile);

/**
 * descargar archivo en un directorio especifico
 * Objeto en $downloadedFile['body'] es de tipo GuzzleHttp\Psr7\Stream
 */
$downloadedFile = $s3Uploads->getObject($targetKey, dirname(__DIR__) . '/copia1.pdf');
var_dump('archivo desgargado de s3 y guardado como copia1.pdf', $downloadedFile);

/**
 * Listar todos los objectos en un bucket de s3
 */
foreach ($s3Uploads->listObjects() as $key) {
    var_dump($key);
}
