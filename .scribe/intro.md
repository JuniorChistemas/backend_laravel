# Introduction

API RESTful para gestión de usuarios y clientes. Incluye autenticación mediante tokens Bearer (Laravel Sanctum) y operaciones CRUD completas.

<aside>
    <strong>Base URL</strong>: <code>https://api-backend.laravel.cloud</code>
</aside>

    ## Autenticación

    Esta API utiliza **Bearer Token** para autenticación. Para obtener tu token:

    1. Realiza una petición POST a `/api/login` con tus credenciales (email y password)
    2. Recibirás un token de acceso válido por 1 hora
    3. Incluye el token en el header `Authorization: Bearer {token}` en tus peticiones

    ## Formato de respuesta

    Todas las respuestas están en formato JSON. Las respuestas exitosas incluyen los datos solicitados, mientras que los errores incluyen un mensaje descriptivo.

    ## Rate Limiting

    La API está protegida contra abuso. Se aplican límites de tasa estándar de Laravel.

    ## Códigos de estado

    - `200 OK` - Solicitud exitosa
    - `201 Created` - Recurso creado exitosamente
    - `401 Unauthorized` - Token inválido o ausente
    - `403 Forbidden` - Sin permisos suficientes
    - `404 Not Found` - Recurso no encontrado
    - `422 Unprocessable Entity` - Error de validación
    - `500 Internal Server Error` - Error del servidor

