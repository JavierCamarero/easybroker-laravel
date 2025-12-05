# EasyBroker API Challenge – Laravel (Minimal README)

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Add your EasyBroker API key to `.env`:

```
EASYBROKER_API_KEY=your_key_here
EASYBROKER_BASE_URL=https://api.stagingeb.com
```

## CLI Usage

List properties:

```bash
php artisan easybroker:list-properties
```

## API Endpoint

```http
GET /api/properties
```

## Tests

```bash
php artisan test
```
