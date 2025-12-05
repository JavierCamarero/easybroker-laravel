# EasyBroker API Challenge – Laravel

## Architecture

This project uses a **feature-first (vertical slice) architecture**, where all logic for a feature lives in a single folder:


Each slice contains:

- **Contracts** – defines the provider abstraction (e.g., PropertiesProvider)
- **Services** – EasyBroker API client implementation
- **UseCases** – application logic (pagination, iteration, mapping)
- **DTOs** – typed data objects instead of raw arrays

This structure keeps the domain logic **isolated, testable, and independent** of Laravel delivery layers, making it easy to extend the feature or switch providers without affecting unrelated parts of the system.


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
