# Laravel Backend API - Arquitectura Modular

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Sanctum-4.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Sanctum">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License MIT">
</p>

## 📋 Descripción

API RESTful desarrollada con **Laravel 12** implementando una **arquitectura modular limpia** con patrones de diseño avanzados. El proyecto utiliza **Laravel Sanctum** para autenticación basada en tokens y demuestra las mejores prácticas en desarrollo backend moderno.

## ✨ Características Principales

-   🔐 **Autenticación con Laravel Sanctum** - Tokens de acceso personal seguros
-   🏗️ **Arquitectura Modular** - Separación clara de responsabilidades
-   📦 **Patrón Repository** - Abstracción de la capa de datos
-   🎯 **Service Layer** - Lógica de negocio desacoplada
-   🔄 **DTOs (Data Transfer Objects)** - Transferencia de datos tipada
-   🔌 **Dependency Injection** - Inversión de control mediante contratos
-   📝 **Form Request Validation** - Validación centralizada
-   🎨 **API Resources** - Transformación consistente de respuestas
-   🐳 **Docker Ready** - Configuración para contenedores
-   📚 **Documentación API** - Generada con Scribe

---

## 🔐 Autenticación con Laravel Sanctum

### Características de Seguridad

Este proyecto implementa **Laravel Sanctum** para proporcionar un sistema de autenticación robusto y seguro:

-   ✅ Tokens de acceso personal (Personal Access Tokens)
-   ✅ Registro de IP por token para auditoría
-   ✅ Tokens revocables individualmente
-   ✅ Middleware de autenticación `auth:sanctum`
-   ✅ Rate limiting en endpoints de autenticación
-   ✅ Expiración configurable de tokens

### Uso del Token

Todos los endpoints protegidos requieren el header de autorización:

```bash
Authorization: Bearer 1|abcdef123456...
```

---

## 🏗️ Arquitectura y Patrones de Diseño

### Estructura Modular

El proyecto implementa una arquitectura modular híbrida que combina las convenciones de Laravel con principios de Clean Architecture:

```
app/
├── Models/                         # Modelos globales (Laravel default)
│   └── Customer.php
│
├── Http/
│   ├── Controllers/               # Controllers (Laravel default)
│   │   └── CustomerController.php
│   │
│   ├── Requests/                  # Form Requests (Laravel default)
│   │   ├── StoreCustomerRequest.php
│   │   └── UpdateCustomerRequest.php
│   │
│   └── Resources/                 # API Resources (Laravel default)
│       └── CustomerResource.php
│
└── Modules/                       # Estructura modular
    └── Customer/
        ├── Contracts/             # Interfaces (Dependency Inversion)
        │   ├── CustomerServiceInterface.php
        │   └── CustomerRepositoryInterface.php
        │
        ├── Dtos/                  # Data Transfer Objects
        │   ├── CustomerCreateDTO.php
        │   ├── CustomerUpdateDTO.php
        │   └── CustomerDTO.php
        │
        ├── Repositories/          # Data Access Layer
        │   └── EloquentCustomerRepository.php
        │
        ├── Services/              # Business Logic Layer
        │   └── CustomerService.php
        │
        └── Converters/            # Transformers
            └── CustomerConverter.php
```

### Patrones de Diseño Implementados

#### 1. **Repository Pattern**

Abstrae la lógica de acceso a datos, permitiendo cambiar la implementación sin afectar el resto de la aplicación.

```php
// Contrato
interface CustomerRepositoryInterface {
    public function findAll(): Collection;
    public function findById(int $id): ?Customer;
    public function create(array $data): Customer;
    public function update(int $id, array $data): Customer;
    public function delete(int $id): bool;
}

// Implementación
class EloquentCustomerRepository implements CustomerRepositoryInterface {
    // Implementación con Eloquent ORM
}
```

**Ventajas:**

-   ✅ Testeable mediante mocks
-   ✅ Cambio fácil de ORM (Eloquent → Query Builder → otro)
-   ✅ Centralización de queries complejos

#### 2. **Service Layer Pattern**

Encapsula la lógica de negocio fuera de los controladores.

```php
interface CustomerServiceInterface {
    public function getAllCustomers(): Collection;
    public function getCustomerById(int $id): CustomerDTO;
    public function createCustomer(CustomerCreateDTO $dto): CustomerDTO;
    public function updateCustomer(int $id, CustomerUpdateDTO $dto): CustomerDTO;
    public function deleteCustomer(int $id): bool;
}
```

**Ventajas:**

-   ✅ Controladores delgados (Thin Controllers)
-   ✅ Lógica reutilizable
-   ✅ Fácil de testear
-   ✅ Operaciones transaccionales centralizadas

#### 3. **Data Transfer Object (DTO)**

Objetos inmutables para transferir datos entre capas.

```php
class CustomerCreateDTO {
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $address
    ) {}

    public static function fromRequest(Request $request): self {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            address: $request->input('address')
        );
    }
}
```

**Ventajas:**

-   ✅ Type safety
-   ✅ Inmutabilidad
-   ✅ Validación en un solo punto
-   ✅ Autocomplete en IDE

#### 4. **Dependency Injection & IoC Container**

Inyección de dependencias mediante el Service Container de Laravel.

```php
class CustomerProvider extends ServiceProvider {
    public function register(): void {
        $this->app->bind(
            CustomerServiceInterface::class,
            CustomerService::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            EloquentCustomerRepository::class
        );
    }
}
```

**Ventajas:**

-   ✅ Desacoplamiento
-   ✅ Testing con mocks
-   ✅ Cambio fácil de implementaciones

#### 5. **Converter Pattern**

Transformación entre modelos y DTOs.

```php
class CustomerConverter {
    public static function toDTO(Customer $customer): CustomerDTO {
        return new CustomerDTO(
            id: $customer->id,
            name: $customer->name,
            email: $customer->email,
            phone: $customer->phone,
            address: $customer->address
        );
    }
}
```

#### 6. **Form Request Validation**

Validación centralizada y reutilizable.

```php
class StoreCustomerRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];
    }
}
```

---

## 🚀 Flujo de una Petición

```
1. Request HTTP
   ↓
2. Routes (routes/api.php)
   ↓
3. Middleware (auth:sanctum)
   ↓
4. Controller (CustomerController)
   ↓
5. Form Request (StoreCustomerRequest) → Validación
   ↓
6. DTO Creation (CustomerCreateDTO::fromRequest)
   ↓
7. Service Layer (CustomerService)
   ↓
8. Repository Layer (EloquentCustomerRepository)
   ↓
9. Model (Customer)
   ↓
10. Converter (CustomerConverter::toDTO)
    ↓
11. API Resource (CustomerResource)
    ↓
12. JSON Response
```

---

## 📦 Instalación

### Requisitos

-   PHP 8.2 o superior
-   Composer
-   Node.js & NPM
-   MySQL/PostgreSQL/SQLite
-   Docker (opcional)

### Instalación Local

```bash
# Clonar el repositorio
git clone https://github.com/JuniorChistemas/backend_laravel.git
cd backend_laravel

# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos en .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_backend
DB_USERNAME=root
DB_PASSWORD=

# Ejecutar migraciones
php artisan migrate

# Seeders (opcional)
php artisan db:seed

# Compilar assets
npm run build

# Iniciar servidor
php artisan serve
```

### Instalación con Docker

```bash
# Construir y levantar contenedores
docker-compose up -d

# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Ver logs
docker-compose logs -f
```

---

## 🧪 Testing

```bash
# Ejecutar todos los tests
php artisan test

# Con cobertura
php artisan test --coverage

# Tests específicos
php artisan test --filter CustomerTest
```

---

## 📚 API Endpoints - CRUD Customers

### Listar Customers

```http
GET /api/customers
Authorization: Bearer {token}
```

### Obtener Customer

```http
GET /api/customers/{id}
Authorization: Bearer {token}
```

### Crear Customer

```http
POST /api/customers
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Smith",
  "email": "jane@example.com",
  "phone": "+1234567890",
  "address": "123 Main St"
}
```

### Actualizar Customer

```http
PUT /api/customers/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane.doe@example.com",
  "phone": "+0987654321"
}
```

### Eliminar Customer

```http
DELETE /api/customers/{id}
Authorization: Bearer {token}
```

### Documentación Completa

Accede a la documentación interactiva generada con Scribe:

```bash
php artisan scribe:generate
```

Visita: `http://localhost:8000/docs`

---

## 🛠️ Tecnologías Utilizadas

-   **Framework:** Laravel 12.x
-   **Autenticación:** Laravel Sanctum 4.x
-   **ORM:** Eloquent
-   **Validación:** Form Requests
-   **Testing:** PHPUnit
-   **Documentación:** Scribe
-   **Code Style:** Laravel Pint
-   **Containerización:** Docker

---

## 📖 Principios SOLID Aplicados

-   ✅ **Single Responsibility:** Cada clase tiene una única responsabilidad
-   ✅ **Open/Closed:** Abierto para extensión, cerrado para modificación
-   ✅ **Liskov Substitution:** Las implementaciones son intercambiables
-   ✅ **Interface Segregation:** Interfaces específicas y cohesivas
-   ✅ **Dependency Inversion:** Dependencia de abstracciones, no de concreciones

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

---

## 👤 Autor

**Junior Chistemas**

-   GitHub: [@JuniorChistemas](https://github.com/JuniorChistemas)

---

## 📞 Soporte

Si tienes alguna pregunta o problema, por favor abre un [issue](https://github.com/JuniorChistemas/backend_laravel/issues) en GitHub.

---

<p align="center">Desarrollado con ❤️ usando Laravel</p>
