# SDi Laravel Spotify API

This is a technical challenge developed for SDi, using Laravel 11 and Sail. It connects with the Spotify API and implements clean architecture and documentation standards.

## 🛠️ Stack
- Laravel 11
- Sail (Docker)
- Breeze + Livewire
- Sanctum (Auth)
- Scramble (API Docs)
- Telescope (Local Debugging)
- PHPUnit (Testing)

## 🚀 Getting Started

```bash
git clone https://github.com/trzaskos/sdi-laravel-spotify-api.git
cd sdi-laravel-spotify-api
./vendor/bin/sail up -d

## 🔀 Branching Strategy

We use Git branches and commit messages in English.

- `feature/feature-name`
- `fix/issue-description`
- `test/unit-tests-for-x`
- `chore/update-readme`

Example commits:
- `feat: Add endpoint to fetch Spotify artist by name`
- `fix: Handle missing token error`
- `test: Add test for SpotifyService`