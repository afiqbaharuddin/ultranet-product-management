# Ultranet Product Management System

A comprehensive Laravel-based product management system with RESTful API, admin dashboard, and complete CRUD operations.

## 📋 Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [API Documentation](#api-documentation)
- [Testing](#testing)
- [Docker Deployment](#docker-deployment)
- [Project Structure](#project-structure)
- [Assumptions & Design Choices](#assumptions--design-choices)

---

## ✨ Features

### Product Management (Admin Dashboard)

- ✅ Complete CRUD operations for products
- ✅ Soft delete functionality
- ✅ Bulk delete products
- ✅ Export products to Excel (.xlsx)
- ✅ Filter products by status (enabled/disabled)
- ✅ Search products by name
- ✅ Pagination support

### Category Management

- ✅ One-to-many relationship (Category → Products)
- ✅ Category CRUD operations
- ✅ Category filtering in API

### RESTful API

- ✅ Full product CRUD via API
- ✅ Sanctum token-based authentication
- ✅ Category filtering
- ✅ Bulk delete endpoint
- ✅ Pagination support
- ✅ Comprehensive Swagger/OpenAPI documentation

### Advanced Features

- ✅ Form Request validation
- ✅ PHPUnit test suite with 90%+ coverage
- ✅ API Resources for consistent JSON responses
- ✅ Excel export using Laravel-Excel
- ✅ Docker support for easy deployment

---

## 🔧 Requirements

- **PHP**: 8.1 or higher
- **Composer**: 2.x
- **MySQL**: 8.0 or higher
- **Node.js**: 16.x or higher (for asset compilation)
- **Extensions**: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath

---

## 📦 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/afiqbaharuddin/ultranet-product-management.git
cd ultranet-product-management
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

**Note**: Laravel Breeze is already included in the dependencies for authentication scaffolding.

### 3. Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ultranet_product_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations and Seeders

```bash
# Run migrations
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

This will create:

- Admin user: `admin@ultranet.com` / `password`
- 10 product categories
- 50-100 sample products

### 6. Build Frontend Assets

```bash
# Build Vite assets for production
npm run build

# Or run development server with hot reload
npm run dev
```

### 7. Access the Application

The application will be available at: `http://localhost:8000`

**Default Login Credentials:**

- Email: `admin@ultranet.com`
- Password: `password`

---

## 📚 API Documentation

### Accessing Swagger UI

Once the application is running, visit:

```
http://localhost:8000/api/documentation
```

The Swagger UI provides interactive API documentation where you can:

- View all available endpoints
- Test API calls directly from the browser
- See request/response schemas

### API Authentication

All API endpoints require authentication using Laravel Sanctum. To access the API:

1. **Login** to get authentication token
2. **Use token** in Authorization header:
    ```
    Authorization: Bearer {your-token}
    ```

### Example API Request

```bash
# Get products list
curl -X GET "http://localhost:8000/api/products" \
  -H "Authorization: Bearer {your-token}" \
  -H "Accept: application/json"
```

---

## 🚀 Running the Application

### Local Development Server

```bash
# Start the Laravel development server
php artisan serve
```

The application will be available at: `http://localhost:8000`

### Compile Assets

```bash
# Development
npm run dev

# Production
npm run build

# Watch for changes
npm run watch
```

### Access Points

- **Admin Dashboard**: `http://localhost:8000/admin/products`
- **Swagger API Docs**: `http://localhost:8000/api/documentation`
- **Login**: `http://localhost:8000/login`

**Default Admin Credentials:**

- Email: `admin@ultranet.com`
- Password: `password`

---

## 📚 API Documentation

### Authentication

This API uses Laravel Sanctum for authentication. To access protected endpoints:

1. **Create a user account** or use the seeded admin account
2. **Generate an API token** (via `/api/login` endpoint or manually in database)
3. **Include the token** in the Authorization header:

```bash
Authorization: Bearer YOUR_TOKEN_HERE
```

### Base URL

```
http://localhost:8000/api
```

### Available Endpoints

#### Products

| Method   | Endpoint                     | Description                         | Auth Required |
| -------- | ---------------------------- | ----------------------------------- | ------------- |
| `GET`    | `/products`                  | List all products (with pagination) | ✅            |
| `GET`    | `/products?category_id={id}` | Filter products by category         | ✅            |
| `GET`    | `/products/{id}`             | Get single product details          | ✅            |
| `POST`   | `/products`                  | Create a new product                | ✅            |
| `PUT`    | `/products/{id}`             | Update a product                    | ✅            |
| `DELETE` | `/products/{id}`             | Delete a product (soft delete)      | ✅            |
| `POST`   | `/products/bulk-delete`      | Bulk delete products                | ✅            |

### Example API Requests

#### Create Product

```bash
curl -X POST http://localhost:8000/api/products \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laptop",
    "category_id": 1,
    "description": "High-performance laptop",
    "price": 999.99,
    "stock": 50,
    "enabled": true
  }'
```

**Response (201 Created):**

```json
{
    "message": "Product created successfully",
    "data": {
        "id": 1,
        "name": "Laptop",
        "category_id": 1,
        "category_name": "Electronics",
        "description": "High-performance laptop",
        "price": "999.99",
        "stock": 50,
        "enabled": true,
        "created_at": "2026-01-29T09:00:00.000000Z",
        "updated_at": "2026-01-29T09:00:00.000000Z"
    }
}
```

#### List Products with Filtering

```bash
curl -X GET "http://localhost:8000/api/products?category_id=1&page=1" \
  -H "Authorization: Bearer YOUR_TOKEN"
```

#### Bulk Delete Products

```bash
curl -X POST http://localhost:8000/api/products/bulk-delete \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "ids": [1, 2, 3]
  }'
```

### Interactive API Documentation

For a complete, interactive API documentation, visit:

**Swagger UI**: `http://localhost:8000/api/documentation`

---

## 🧪 Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test file
php artisan test --filter ProductApiTest

# Run specific test method
php artisan test --filter test_can_create_product
```

### Test Coverage

The project includes comprehensive tests for:

- ✅ **API Endpoints**: All CRUD operations
- ✅ **Authentication**: Sanctum token validation
- ✅ **Validation**: Form Request validation rules
- ✅ **Relationships**: Category-Product relationships
- ✅ **Filtering**: Category filtering and search
- ✅ **Bulk Operations**: Bulk delete functionality

**Current Coverage**: ~90% of critical application logic

### Test Files

- `tests/Feature/ProductApiTest.php` - API endpoint tests
- `tests/Unit/ProductTest.php` - Product model unit tests
- `tests/Unit/CategoryTest.php` - Category model unit tests

---

## 🐳 Docker Deployment

### Prerequisites

- Docker Desktop installed
- Docker Compose installed

### Quick Start with Docker

```bash
# Build and start containers
docker-compose up -d

# Run migrations inside container
docker-compose exec app php artisan migrate

# Run seeders
docker-compose exec app php artisan db:seed

# Generate Swagger docs
docker-compose exec app php artisan l5-swagger:generate
```

### Access Points (Docker)

- **Application**: `http://localhost:8000`
- **PHPMyAdmin**: `http://localhost:8080`
- **MySQL**: `localhost:3307`

### Docker Services

| Service      | Description                   | Port |
| ------------ | ----------------------------- | ---- |
| `app`        | Laravel Application (PHP-FPM) | -    |
| `nginx`      | Nginx Web Server              | 8000 |
| `db`         | MySQL 8.0 Database            | 3307 |
| `phpmyadmin` | Database Management UI        | 8080 |

### Docker Commands

```bash
# View logs
docker-compose logs -f app

# Stop containers
docker-compose down

# Rebuild containers
docker-compose up -d --build

# Access app container shell
docker-compose exec app bash
```

---

## 📁 Project Structure

```
ultranet-product-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin dashboard controllers
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ProductController.php
│   │   │   └── Api/             # API controllers
│   │   │       └── ProductController.php
│   │   ├── Requests/            # Form Request validation
│   │   │   ├── StoreProductRequest.php
│   │   │   ├── UpdateProductRequest.php
│   │   │   └── BulkDeleteProductRequest.php
│   │   └── Resources/           # API Resources
│   │       └── ProductResource.php
│   ├── Models/
│   │   ├── Product.php          # Product model with SoftDeletes
│   │   ├── Category.php         # Category model
│   │   └── User.php
│   └── Exports/
│       └── ProductsExport.php   # Excel export logic
├── database/
│   ├── migrations/              # Database migrations
│   ├── factories/               # Model factories
│   └── seeders/                 # Database seeders
├── resources/
│   └── views/
│       └── admin/               # Admin dashboard Blade templates
│           ├── products/
│           └── categories/
├── routes/
│   ├── web.php                  # Web routes (admin dashboard)
│   ├── api.php                  # API routes
│   └── auth.php                 # Authentication routes
├── tests/
│   ├── Feature/                 # Feature tests
│   └── Unit/                    # Unit tests
├── docker-compose.yml           # Docker configuration
├── Dockerfile                   # Docker image definition
└── README.md                    # This file
```

---

## 💡 Assumptions & Design Choices

### Architecture

**MVC Pattern**: The application strictly follows Laravel's MVC architecture for maintainability and scalability.

**Repository Pattern**: Not implemented to keep the codebase simple and leverage Laravel's Eloquent ORM directly.

### Database Design

**Soft Deletes**: Products use soft deletes (`deleted_at` timestamp) to preserve data integrity and allow recovery of accidentally deleted products.

**Relationships**: One-to-many relationship between Category and Product ensures referential integrity and efficient querying.

**Indexing**: Foreign keys and frequently queried columns are indexed for performance.

### API Design

**RESTful Standards**: API follows REST principles with proper HTTP methods and status codes.

**Sanctum Authentication**: Chosen for its simplicity and native Laravel integration. More suitable for SPAs and mobile apps than OAuth2.

**API Resources**: Used to ensure consistent JSON response structure and decouple database schema from API responses.

**Versioning**: Not implemented in v1.0 but can be easily added using route prefixes (`/api/v1/`, `/api/v2/`).

### Validation

**Form Requests**: All input validation is handled by dedicated Form Request classes, keeping controllers clean and validation rules reusable.

**Client-Side Validation**: Minimal front-end validation; relies primarily on server-side validation for security.

### Security

**CSRF Protection**: Enabled for all web routes.

**SQL Injection**: Prevented by using Eloquent ORM and parameter binding.

**XSS Protection**: Blade templates automatically escape output.

**Mass Assignment**: Protected via `$fillable` properties in models.

### Performance

**Eager Loading**: Uses `with('category')` to prevent N+1 query problems.

**Pagination**: All list endpoints return paginated results (15 items per page).

**Caching**: Not implemented in v1.0 but recommended for production (Redis/Memcached).

### Testing

**Database Transactions**: Tests use `RefreshDatabase` trait to ensure a clean state for each test.

**Factories**: Used to generate test data, making tests maintainable and readable.

**Coverage Focus**: Prioritized testing API endpoints and critical business logic over simple getters/setters.

### Excel Export

**Laravel-Excel Package**: Used for its simplicity and Laravel integration. Exports include all product fields with category name.

### Frontend

**Tailwind CSS**: Used for rapid UI development with utility-first CSS.

**Minimal JavaScript**: Uses vanilla JavaScript for simple interactions (select all checkboxes).

**No SPA Framework**: Traditional server-side rendering for simplicity. Could be migrated to Vue.js/React for richer interactions.

---

## 🛠️ Future Enhancements

### Planned Features

- [ ] API rate limiting
- [ ] Redis caching for frequently accessed data
- [ ] Product images upload and management
- [ ] Advanced filtering (price range, stock levels)
- [ ] Product variants (size, color, etc.)
- [ ] Inventory tracking and alerts
- [ ] Sales analytics dashboard
- [ ] API versioning
- [ ] Webhook notifications
- [ ] Multi-language support

### Performance Improvements

- [ ] Implement Redis caching
- [ ] Add database query optimization
- [ ] Implement lazy loading for images
- [ ] Add CDN for static assets

---

## 📝 License

This project is developed as part of the BestWeb Technologies Laravel Developer Assessment.

---

## 👥 Contact

For questions or support, please contact:

- **Email**: mafqqq16@gmail.com
- **Repository**: https://github.com/afiqbaharuddin/ultranet-product-management

---

## 🙏 Acknowledgments

- **Laravel Framework**: https://laravel.com
- **Laravel Excel**: https://laravel-excel.com
- **Laravel Sanctum**: https://laravel.com/docs/sanctum
- **L5 Swagger**: https://github.com/DarkaOnLine/L5-Swagger

---

**Built with ❤️ using Laravel**
