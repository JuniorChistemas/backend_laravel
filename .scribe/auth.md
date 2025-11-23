# Authenticating requests

To authenticate requests, include an **`Authorization`** header with the value **`"Bearer {YOUR_TOKEN}"`**.

All authenticated endpoints are marked with a `requires authentication` badge in the documentation below.

Puedes obtener tu token de autenticación realizando login en <code>POST /api/login</code>. El token tiene una validez de <b>1 hora</b> y otorga permisos para crear, actualizar, eliminar y visualizar usuarios y clientes.
