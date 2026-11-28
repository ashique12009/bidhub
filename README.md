# BidHub

BidHub is an online auction application. The backend is built with Laravel and the frontend with Vue.js.

## Technology Stack

- **Backend:** Laravel, PHP, Laravel Sanctum
- **Frontend:** Vue 3, Vite, Vue Router, Pinia
- **Database:** SQLite by default (Laravel can be configured to use another supported database)

## Features

- Browse products and view featured products on the home page.
- Browse auctions and filter them by status: upcoming, live, or ended.
- Navigate paginated auction listings.
- View auction details, including the starting price, current highest bid, minimum next bid, and auction schedule.
- See a live countdown to an auction's start or end.
- Log in and keep the authenticated session available in the frontend.
- Place bids on live auctions while signed in. The API rejects bids that do not exceed the current highest bid.
- Retrieve an auction's bids, the signed-in user's profile, and the signed-in user's bid history through the API.

## Requirements

- PHP 8.3 or later and Composer
- Node.js 22.18 or later (or 24.12 or later) and npm

## Few Screenshots
Auction list page:
<img width="3024" height="2840" alt="BidHub-auction-list" src="https://github.com/user-attachments/assets/9567a39f-3ddb-428e-8d32-ea75ceba45f6" />

Auction detail page:
<img width="3024" height="2509" alt="BidHub-auction-detail-page" src="https://github.com/user-attachments/assets/1bcf0c0a-d32c-4f17-a18f-d7ffbd6008bb" />

Validation:
<img width="3024" height="1500" alt="BidHub-auction-creation-validation" src="https://github.com/user-attachments/assets/549e37c4-b5b8-4613-8a66-041c46a9fb83" />

Validation:
<img width="3024" height="1500" alt="BidHub-auction-date-validation" src="https://github.com/user-attachments/assets/2d5c5bf7-6880-471c-949b-c584643f88a0" />

Success bid:
<img width="3024" height="2672" alt="BidHub-success-bid" src="https://github.com/user-attachments/assets/f81d0877-7fa7-4497-b121-5db985d7fe45" />

## Getting Started

### 1. Set up the backend

```sh
cd backend
composer install
cp .env.example .env
```

By default, the backend uses SQLite. Create the database file if it does not exist, then generate the application key and run migrations:

```sh
touch database/database.sqlite
php artisan key:generate
php artisan migrate
```

> **Note:** The current migration history has a clean-install issue: one migration attempts to remove `products.starting_price`, but the initial products migration does not create that column. Reconcile the migrations before migrating a fresh SQLite database.

Start the Laravel development server:

```sh
php artisan serve
```

The backend will be available at `http://127.0.0.1:8000`.

### 2. Set up the frontend

In another terminal:

```sh
cd frontend
npm install
```

Create a `frontend/.env` file and point it to the Laravel API:

```dotenv
VITE_API_BASE_URL=http://127.0.0.1:8000/api/v1
```

Start the Vue development server:

```sh
npm run dev
```

Open the local URL printed by Vite in your browser.

## Useful Commands

Run the backend tests:

```sh
cd backend
php artisan test
```

Create a production frontend build:

```sh
cd frontend
npm run build
```