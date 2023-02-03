## technical Test

se ejecutara el comando `composer install` para hacer la instalacion de todas las dependencias necesarias 

seguidamente se renombrara el arhcivo `.env.example` y se colocara el siguiente nombre `.env`
en dicho archivo se modificaran las siguientes variables a los valores que tengas

- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

luego procederas a ejecutar el comando de artisan `php artisan migrate` para ejecutar las migraciones y se creen las 
tablas correspondientes

este ultimo paso para la configuracion sera opcional ya que solamente seria para poblar las tablas necesarias de datos 
`php artisan db:seed`

despues de haber seguido los pasos anteriores ahora se procedera a levantar el servidor
 ejecutando el comando de artisan `php artisan serve` y debera correr en el puerto 8000 y la ruta quedaria asi
http://localhost:8000/
