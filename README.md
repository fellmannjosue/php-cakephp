# Hola Mundo · CakePHP (framework real)

Portal del framework **CakePHP** (creado con `composer create-project cakephp/app`),
parte de una serie de 9 portales "Hola Mundo" con un **cuadro comparativo** común.

> Tipo: **framework real**. Controlador (`src/Controller/PortalController.php`), vista
> (`templates/Portal/index.php`), ruta `/api` (JSON) y validación reales. 5 funciones
> (mezcla) + tabla comparativa de los 9.

## Local
```bash
composer install && bin/cake server
```
## Docker
```bash
docker build -t php-cakephp . && docker run -p 8080:80 php-cakephp
```
Coolify: Build Pack **Dockerfile**, puerto **80**.
