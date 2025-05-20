# SDi Laravel Spotify API

This is a technical challenge developed for SDi, using Laravel 12 and Sail. It connects with the Spotify API and implements clean architecture and documentation standards.

## 🛠️ Stack

-   Laravel 12
-   Sail (Docker)
-   Breeze + Livewire
-   Sanctum (Auth)
-   Scramble (API Docs)
-   Telescope (Local Debugging)
-   PHPUnit (Testing)

## 🚀 Getting Started

```bash
git clone https://github.com/trzaskos/sdi-laravel-spotify-api.git
cd sdi-laravel-spotify-api
./vendor/bin/sail up -d
```

Create a `.env` file and configure your Spotify credentials:

```bash
cp .env.example .env
./vendor/bin/sail artisan key:generate
```

## 🔐 Authentication

This API uses Laravel Sanctum for authentication.

### Endpoints

-   `POST /api/auth/register`: Register a new user
-   `POST /api/auth/login`: Authenticate and receive token
-   `POST /api/auth/logout`: Revoke the current token (requires Bearer token)

To authenticate requests, use the token in the `Authorization` header:

```
Authorization: Bearer your-token-here
```

---

## 📬 Postman Collection

<details>
<summary>📂 Click to expand Postman collection JSON</summary>

```json
{
    "info": {
        "name": "SDi Laravel Spotify API – Auth",
        "_postman_id": "12345678-90ab-cdef-1234-567890abcdef",
        "description": "Auth endpoints for SDi Laravel Spotify API",
        "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
    },
    "item": [
        {
            "name": "Register",
            "request": {
                "method": "POST",
                "header": [
                    { "key": "Content-Type", "value": "application/json" }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n  \"name\": \"Mary Dev\",\n  \"email\": \"mary@example.com\",\n  \"password\": \"12345678\",\n  \"password_confirmation\": \"12345678\"\n}"
                },
                "url": {
                    "raw": "http://localhost/api/auth/register",
                    "protocol": "http",
                    "host": ["localhost"],
                    "path": ["api", "auth", "register"]
                }
            }
        },
        {
            "name": "Login",
            "request": {
                "method": "POST",
                "header": [
                    { "key": "Content-Type", "value": "application/json" }
                ],
                "body": {
                    "mode": "raw",
                    "raw": "{\n  \"email\": \"mary@example.com\",\n  \"password\": \"12345678\"\n}"
                },
                "url": {
                    "raw": "http://localhost/api/auth/login",
                    "protocol": "http",
                    "host": ["localhost"],
                    "path": ["api", "auth", "login"]
                }
            }
        },
        {
            "name": "Logout",
            "request": {
                "method": "POST",
                "header": [
                    { "key": "Authorization", "value": "Bearer {token}" },
                    { "key": "Content-Type", "value": "application/json" }
                ],
                "url": {
                    "raw": "http://localhost/api/auth/logout",
                    "protocol": "http",
                    "host": ["localhost"],
                    "path": ["api", "auth", "logout"]
                }
            }
        }
    ]
}
```

</details>

---

## 📜 API Documentation

Once the app is running, you can access:

-   [http://localhost/docs/api](http://localhost/docs/api) → Scramble API Docs
-   [http://localhost/telescope](http://localhost/telescope) → Laravel Telescope (only in local)

---

## 🔄 Branching & Commits

We follow Git branches and commit messages in English.

### Branch naming

-   `feature/feature-name`
-   `fix/issue-description`
-   `chore/task-description`
-   `test/unit-tests-for-x`

### Commit examples

-   `feat: add register/login/logout endpoints`
-   `fix: handle auth token error`
-   `test: add tests for auth routes`
-   `docs: update README`

---

## 🚪 License

MIT
