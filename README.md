# API Fichaje de trabajo

## Requisitos previos

- Docker
- Docker Compose

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
