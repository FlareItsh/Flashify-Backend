# Flashify Backend

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

<p align="center">
<img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
<img src="https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white" alt="Vue.js">
<img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

## ✨ Features

-   🔐 **Secure Authentication**: JWT-based authentication with Laravel Sanctum
-   📚 **Flashcard Management**: Create, read, update, and delete flashcards organized in collections
-   👤 **User Profiles**: Customizable user profiles with avatar selection
-   🏷️ **Tagging System**: Organize collections with tags and priority levels
-   📊 **Statistics**: Track your learning progress with collection and flashcard stats
-   🐳 **Docker Support**: Easy deployment with containerization
-   📱 **RESTful API**: Clean, well-documented API endpoints
-   🧪 **Testing**: Comprehensive test suite for reliability

## 🏗️ Architecture

![Architecture](architecture.png)

Flashify Backend is the API server for the Flashify flashcard maker application, built with Laravel. It provides RESTful endpoints for managing users, collections, flashcards, and avatars. This backend handles authentication, data storage, and business logic for the flashcard creation and management system.

## Frontend

The frontend for this application can be found at [Flashify Frontend](https://github.com/FlareItsh/Flashify.git).

## Prerequisites

To simplify the setup process, especially on Windows, we recommend using XAMPP, which provides PHP, MySQL, and Apache in a single package. Alternatives include WAMP, MAMP, or Laragon.

Before you begin, ensure you have the following installed on your system:

-   **PHP**: Version 8.1 or higher (check with `php --version`)
-   **Composer**: PHP dependency manager (check with `composer --version`)
-   **Node.js and npm**: For frontend assets (optional)
-   **MySQL or another supported database**
-   **Git**: For cloning the repository

## Installation

1. **Clone the repository**:

    ```sh
    git clone https://github.com/FlareItsh/Flashify-Backend.git
    cd Flashify-Backend
    ```

2. **Install PHP dependencies**:

    ```sh
    composer install
    ```

3. **Install Node.js dependencies (optional)**:

    ```sh
    npm install
    ```

4. **Environment Configuration**:

    - Copy the `.env.example` file to `.env`:
        ```sh
        cp .env.example .env
        ```
    - Update the `.env` file with your database credentials and other settings.

5. **Generate Application Key**:

    ```sh
    php artisan key:generate
    ```

6. **Run Database Migrations**:

    ```sh
    php artisan migrate
    ```

7. **Seed the Database (optional but needed to retrieve and load avatars)**:
    ```sh
    php artisan db:seed
    ```

## Running Locally

To start the development server:

```sh
php artisan serve
```

The API will be available at `http://localhost:8000`.

## Additional Commands

-   **Run tests**: `php artisan test`

## API Documentation

The Flashify Backend provides a RESTful API for managing users, collections, and flashcards. All protected endpoints require authentication via Bearer token in the `Authorization` header.

### Authentication

#### Register User

-   **Method**: `POST`
-   **Endpoint**: `/api/register`
-   **Request Body**:
    ```json
    {
        "username": "string",
        "email": "string",
        "password": "string",
        "password_confirmation": "string",
        "avatar_id": "integer (optional, 1-20)"
    }
    ```
-   **Response (Success)**:
    ```json
    {
      "status": "success",
      "message": "User created successfully",
      "data": {
        "user_id": 1,
        "username": "example",
        "email": "user@example.com",
        "avatar": {...}
      }
    }
    ```
-   **Response (Validation Error)**:
    ```json
    {
        "status": "error",
        "message": "Validation failed",
        "errors": {
            "email": ["The email has already been taken."]
        }
    }
    ```

#### Login

-   **Method**: `POST`
-   **Endpoint**: `/api/login`
-   **Request Body**:
    ```json
    {
        "login": "string (username or email)",
        "password": "string"
    }
    ```
-   **Response (Success)**:
    ```json
    {
      "status": "success",
      "message": "Login successful",
      "data": {
        "user": {...},
        "token": "bearer_token_here",
        "token_type": "Bearer"
      }
    }
    ```

#### Logout

-   **Method**: `POST`
-   **Endpoint**: `/api/logout`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "Logged out successfully"
    }
    ```

#### Get Authenticated User

-   **Method**: `GET`
-   **Endpoint**: `/api/me`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
      "status": "success",
      "data": {
        "user_id": 1,
        "username": "example",
        "email": "user@example.com",
        "avatar": {...},
        "collections": [...]
      }
    }
    ```

#### Change Password

-   **Method**: `POST`
-   **Endpoint**: `/api/change-password`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**:
    ```json
    {
        "current_password": "string",
        "password": "string",
        "password_confirmation": "string"
    }
    ```
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "Password changed successfully"
    }
    ```

### Users

#### List Users

-   **Method**: `GET`
-   **Endpoint**: `/api/users?per_page=15`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
      "status": "success",
      "data": {
        "current_page": 1,
        "data": [...],
        "per_page": 15,
        "total": 100
      }
    }
    ```

#### Get User by ID

-   **Method**: `GET`
-   **Endpoint**: `/api/users/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
      "status": "success",
      "data": {
        "user_id": 1,
        "username": "example",
        "email": "user@example.com",
        "avatar": {...},
        "collections": [...]
      }
    }
    ```

#### Update User

-   **Method**: `PUT` or `PATCH`
-   **Endpoint**: `/api/users/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**:
    ```json
    {
        "username": "string (optional)",
        "email": "string (optional)",
        "avatar_id": "integer (optional)"
    }
    ```
-   **Response**:
    ```json
    {
      "status": "success",
      "message": "User updated successfully",
      "data": {...}
    }
    ```

#### Delete User

-   **Method**: `DELETE`
-   **Endpoint**: `/api/users/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "User deleted successfully"
    }
    ```

#### Get User by Username

-   **Method**: `GET`
-   **Endpoint**: `/api/users/username/{username}`
-   **Headers**: `Authorization: Bearer {token}`

#### Get User by Email

-   **Method**: `POST`
-   **Endpoint**: `/api/users/email`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**:
    ```json
    {
        "email": "string"
    }
    ```

### Avatars

#### List Avatars

-   **Method**: `GET`
-   **Endpoint**: `/api/avatars`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
        "status": "success",
        "data": [
            {
                "avatar_id": 1,
                "avatar_path": "/avatars/avatar1.png"
            }
        ]
    }
    ```

### Collections

#### List Collections

-   **Method**: `GET`
-   **Endpoint**: `/api/collections?per_page=15`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
      "status": "success",
      "data": {
        "current_page": 1,
        "data": [...],
        "per_page": 15,
        "total": 10
      },
      "stats": {
        "total_collections": 10,
        "total_flashcards": 50
      }
    }
    ```

#### Create Collection

-   **Method**: `POST`
-   **Endpoint**: `/api/collections`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**:
    ```json
    {
        "name": "string",
        "description": "string (optional)",
        "tags": ["array", "optional"],
        "priority_level": "low|medium|high (optional)"
    }
    ```
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "Collection created successfully",
        "data": {
            "collection_id": 1,
            "name": "My Collection",
            "flashcards": []
        }
    }
    ```

#### Get Collection

-   **Method**: `GET`
-   **Endpoint**: `/api/collections/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
      "status": "success",
      "data": {
        "collection_id": 1,
        "name": "My Collection",
        "flashcards": [...]
      }
    }
    ```

#### Update Collection

-   **Method**: `PUT` or `PATCH`
-   **Endpoint**: `/api/collections/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**: Same as create, all fields optional
-   **Response**:
    ```json
    {
      "status": "success",
      "message": "Collection updated successfully",
      "data": {...}
    }
    ```

#### Delete Collection

-   **Method**: `DELETE`
-   **Endpoint**: `/api/collections/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "Collection deleted successfully"
    }
    ```

### Flashcards

#### List Flashcards in Collection

-   **Method**: `GET`
-   **Endpoint**: `/api/collections/{collectionId}/flashcards?per_page=15`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
      "status": "success",
      "data": {
        "current_page": 1,
        "data": [...],
        "per_page": 15,
        "total": 20
      }
    }
    ```

#### Create Flashcard

-   **Method**: `POST`
-   **Endpoint**: `/api/collections/{collectionId}/flashcards`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**:
    ```json
    {
        "front": "string",
        "back": "string",
        "hint": "string (optional)",
        "explaination": "string (optional)"
    }
    ```
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "Flashcard created successfully",
        "data": {
            "flashcard_id": 1,
            "front": "Question",
            "back": "Answer"
        }
    }
    ```

#### Get Flashcard

-   **Method**: `GET`
-   **Endpoint**: `/api/collections/{collectionId}/flashcards/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
        "status": "success",
        "data": {
            "flashcard_id": 1,
            "front": "Question",
            "back": "Answer",
            "hint": "Hint",
            "explaination": "Explanation"
        }
    }
    ```

#### Update Flashcard

-   **Method**: `PUT` or `PATCH`
-   **Endpoint**: `/api/collections/{collectionId}/flashcards/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Request Body**: Same as create, all fields optional
-   **Response**:
    ```json
    {
      "status": "success",
      "message": "Flashcard updated successfully",
      "data": {...}
    }
    ```

#### Delete Flashcard

-   **Method**: `DELETE`
-   **Endpoint**: `/api/collections/{collectionId}/flashcards/{id}`
-   **Headers**: `Authorization: Bearer {token}`
-   **Response**:
    ```json
    {
        "status": "success",
        "message": "Flashcard deleted successfully"
    }
    ```

## Docker Deployment

This application is containerized using Docker for easy deployment.

### Environment Variables

Set the following environment variables in your production environment:

-   `AUTO_MIGRATE=true` - Automatically run database migrations on container startup
-   `AUTO_SEED=true` - Automatically run database seeders on container startup (seeds avatars and other initial data)

### Database Seeding

The application includes seeders for:

-   Avatars (20 default avatar images)
-   Users (sample users for testing)
-   Collections (sample flashcard collections)
-   Flashcards (sample flashcards)

When `AUTO_SEED=true`, all seeders will run automatically during container startup, ensuring your production database has the necessary initial data.

## Contributing

Thank you for considering contributing to Flashify Backend! Please follow the standard Laravel contribution guidelines.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
