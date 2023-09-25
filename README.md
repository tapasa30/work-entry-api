# API Fichaje de trabajo

### Para ver una lista de comandos disponibles ejecuta `make help`

## Endpoints

- GET /user: Obtener todos los usuarios.
- POST /user: Crear un nuevo usuario.
- PUT /user/{id}: Actualizar un usuario existente.
- DELETE /user/{id}: Eliminar un usuario.
- GET /user/{id}: Obtener un usuario por su ID.
- GET /work-entry/active: Obtener la entrada de trabajo activa.
- POST /work-entry: Crear una nueva entrada de trabajo.
- PUT /work-entry/{id}: Actualizar la fecha de finalización de la entrada de trabajo.
- DELETE /work-entry/{id}: Eliminar una entrada de trabajo.
- GET /work-entry/{id}: Obtener una entrada de trabajo por ID.

### Pasos a seguir para iniciar la API

- Ejecutar comando `make start`
- Entrar al contenedor con `make bash`

#### Dentro del contenedor

- Ejecturar `composer install`
- Crear la base de datos con el comando `php bin/console doctrine:database:create`
- Ejectuar migraciones con el comando `php bin/console doctrine:migrations:migrate --no-interaction`
