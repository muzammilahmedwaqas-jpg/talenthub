# TalentHub Recruiters – Invoicing Tracker

A Laravel web application for **TalentHub Recruiters**, a boutique recruitment agency that bills client companies for placement services. Staff can manage clients and services, issue invoices, record (partial) payments, see outstanding balances, and download printable PDF invoices.

**Live site:** https://talenthub.onrender.com

| Demo login | |
|---|---|
| Email | `admin@talenthub.test` |
| Password | `password` |

> The live site runs on Render's free plan: it sleeps after 15 minutes without visitors, so the first page load can take about a minute.

---

## Features

- **Login** – all admin pages, payment entry and PDF downloads are protected by Laravel's `auth` middleware
- **Clients, Services, Invoices** – full create / list / view / edit / delete with paginated tables
- **Validation** – form requests check required fields, numbers, unique emails and invoice numbers, and valid dates
- **Payments** – record full or partial payments on an invoice; the amount can never exceed the remaining balance
- **Automatic status** – an invoice becomes *Unpaid*, *Partial* or *Paid* based on its payments
- **PDF invoices** – download a formatted invoice with client details, totals and payment history
- **Safe deletes** – clients, services and invoices that still have related records cannot be deleted

## Tech stack

| Part | Tool |
|---|---|
| Framework | Laravel 13 (PHP 8.4) |
| Database | SQLite |
| UI | Blade components + Bootstrap 5 (CDN) |
| PDF | barryvdh/laravel-dompdf |
| Hosting | Render (Docker, free plan) |

## Data model

```
clients ──< invoices >── services
               │
               └──< payments
```

- A client has many invoices; an invoice belongs to one client and one service
- An invoice has many payments
- Foreign keys use `restrictOnDelete`, so billing records cannot be lost by deleting a parent record

---

## Local setup

**Requirements:** PHP 8.4+, Composer, Git. (Laravel Herd on Windows/macOS includes PHP and Composer.)

```bash
# 1. Get the code
git clone https://github.com/muzammilahmedwaqas-jpg/talenthub.git
cd talenthub

# 2. Install PHP packages
composer install

# 3. Create the environment file and app key
cp .env.example .env
php artisan key:generate

# 4. Create the SQLite database file
touch database/database.sqlite
#    (Windows PowerShell: New-Item database/database.sqlite)

# 5. Create the tables and sample data
php artisan migrate --seed

# 6. Run the app
php artisan serve
```

Open http://localhost:8000 (or http://talenthub.test with Herd) and log in with the demo account above.

To reset the database with fresh sample data at any time:

```bash
php artisan migrate:fresh --seed
```

The seeder creates the admin user, 5 clients, 5 services, 10 invoices and matching payments.

---

## Deployment (Render)

The app is deployed with **Docker**, because Render has no native PHP runtime.

| File | Purpose |
|---|---|
| `Dockerfile` | Builds a PHP 8.4 + Apache image, serves the `public` folder, runs `composer install --no-dev` |
| `docker/start.sh` | Runs on every start: creates the SQLite file, runs migrations, seeds a new database, caches config/routes/views, starts Apache |
| `.dockerignore` | Keeps `.env`, `vendor` and the local database out of the image |

### Steps

1. Push the code to a public GitHub repository
2. On Render: **New → Web Service**, connect the repository, choose **Language: Docker**, branch `main`, **Free** instance
3. Add these environment variables:

| Key | Value |
|---|---|
| `APP_NAME` | `TalentHub` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | output of `php artisan key:generate --show` |
| `APP_URL` | the Render URL, e.g. `https://talenthub.onrender.com` |
| `DB_CONNECTION` | `sqlite` |
| `SESSION_DRIVER` | `database` |
| `LOG_CHANNEL` | `stderr` |
| `PORT` | `80` |

4. Click **Deploy web service**. Every later `git push` to `main` redeploys automatically.

### Deployment notes

- **Migrations run automatically** in `docker/start.sh` – no console access is needed (Render's shell is a paid feature).
- **Data is temporary on the free plan.** Render's free disk is wiped on every restart or redeploy, so the database is rebuilt with sample data each time. For permanent data, attach a persistent disk (paid) or switch to a hosted database such as PostgreSQL and update the `DB_*` variables.
- **HTTPS:** `bootstrap/app.php` trusts Render's proxy (`trustProxies(at: '*')`) so Laravel generates `https://` links and forms work without mixed-content warnings.
- **Errors:** with `LOG_CHANNEL=stderr`, Laravel errors appear in Render's **Logs** tab. Keep `APP_DEBUG=false` in production so error pages never show code or secrets.

---

## User guide

1. **Log in** with your email and password. Use **Log out** in the top-right corner when you are done.
2. **Clients** – add the companies you bill. Click a company name to see its details and invoices.
3. **Services** – add what the agency sells (e.g. *Permanent Placement*) with a price.
4. **Invoices** – click **New invoice**, choose a client and a service, check the suggested invoice number and dates, enter the amount and save.
5. **Record a payment** – open an invoice, fill in **Record a payment** (amount, date, method, optional reference) and submit. The *Total paid* and *Remaining balance* cards and the status badge update automatically. Partial payments are allowed; overpaying is not.
6. **Download PDF** – on any invoice page, click **Download PDF** to get a printable invoice with totals and payment history.
7. **Deleting** – a client or service that is used on invoices, or an invoice that has payments, cannot be deleted. Remove the related records first.

## Maintenance

- **Change the admin password** (locally): `php artisan tinker`, then
  `App\Models\User::where('email', 'admin@talenthub.test')->first()->update(['password' => 'new-password']);`
  On Render, change the password in `database/seeders/DatabaseSeeder.php` instead, since the database is rebuilt on each deploy.
- **Update the live site:** commit and `git push` to `main`; Render rebuilds automatically.
- **Check the live app is running:** visit `/up` – it returns a success page when the app is healthy.

## Project structure (main files)

```
app/Http/Controllers/     ClientController, ServiceController, InvoiceController,
                          PaymentController, Auth/LoginController
app/Http/Requests/        Validation rules for each form
app/Models/               Client, Service, Invoice (totals + status), Payment
database/migrations/      Table definitions with foreign keys
database/seeders/         Admin user and sample data
resources/views/          Blade views and components (layout, input, status badge)
resources/views/invoices/pdf.blade.php   PDF invoice layout
routes/web.php            Guest (login) and auth-protected routes
```
