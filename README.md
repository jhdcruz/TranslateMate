# TranslateMate

Translator Web App

## Development

1. Copy `.env.example` file to `.env`

```sh
copy .env.example .env
```

2. Generate `APP_KEY`

```sh
php artisan key:generate
```

3. Put values in `.env`

```env
APP_KEY=<app key>
```

4. Put database values in `.env`

```env
DB_CONNECTION=pgsql
DB_HOST=aws-0-ap-northeast-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=<db-username>
DB_PASSWORD=<db-password>
```

5. Install dependencies

```sh
composer install
# and
npm install
```

6. Run app

```
npm run dev  # run this first

php artisan serve
```