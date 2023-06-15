# S3 Uploads ejemplos

### Las siguientes variables deben de estar disponible para poder ser accedidas atravez de la instancia de PHP. i.e
```php
$_ENV['S3_BUCKET_NAME'];
# o
getenv('S3_BUCKET_NAME')
```
```shell
    S3_BUCKET_NAME=enestar-bitrix-data
    AWS_ACCESS_KEY_ID=SERA_PROVEIDA
    AWS_SECRET_ACCESS_KEY=SERA_PROVEIDA
    AWS_REGION=us-east-1
```

### Los paquetes son instalados via composer*
```shell
composer install
```
Para informacion de como utilizar composer, https://getcomposer.org/download/

### Notas:
1. No escriba los secretos de accesso en los archivos php o ningun archivo de texto que sea parte de un proyecto de codigo
2. AWS utiliza un sistema para escanear repositorios de codigo y si encuentra secretos, pueden desactivar la cuenta de AWS a la que los secrtos pertenecen.
