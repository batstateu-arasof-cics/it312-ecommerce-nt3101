# IT 312 E-Commerce — NT 3101

A Laravel e-commerce site built by the 7 groups of NT 3101: one Platform group (Group 5) that reviews, tests and merges every pull request, and module groups that each own one or two modules. Every module is **25–40% done**: the database tables, the service interface, the wiring between modules and at least one working feature are in place. Each group has **3 weeks** to finish **4 Must items** (graded) and optional **Stretch items** (bonus), listed in its module `README.md`.

- Timeline: [docs/TIMELINE.md](docs/TIMELINE.md)
- Grading: [docs/RUBRIC.md](docs/RUBRIC.md)
- Setup problems: [docs/FAQ.md](docs/FAQ.md)

The full system already runs end to end in a basic form: browse → add to cart → checkout (COD) → stock deducted → email logged → order history → admin dashboard.

## What already works (do not rebuild)

> [!NOTE]
> Start the app and try these before writing any code. They are finished and other teams depend on them. Your work is only the **Must** and **Stretch** items in your module's README.
>
> | Feature | Try it | Code |
> | --- | --- | --- |
> | Register, log in, log out | `/register`, `/login` | `app/Modules/Users` |
> | Product list and product page | `/products` | `app/Modules/Catalog` |
> | Keyword search | `/search?q=coffee` | `app/Modules/Search` |
> | Add to cart, cart page | product page → Add to cart | `app/Modules/Cart` |
> | Checkout with cash on delivery | `/cart` → Checkout | `app/Modules/Orders` |
> | Online payment through the mock gateway | Checkout → Pay online (gateway running) | `app/Modules/Payments`, `mock-gateway/` |
> | Order history | `/orders` | `app/Modules/Orders` |
> | Stock goes down after an order | product page stock number | `app/Modules/Inventory` |
> | Order email (written to `storage/logs/laravel.log`) | place an order | `app/Modules/Notifications` |
> | Admin dashboard with sales and low stock | `/admin` as `admin@shop.test` | `app/Modules/Dashboard` |
> | Reviews shown on the product page | any seeded product | `app/Modules/Reviews` |
>
> **How to tell done from not done in the code:** every place left for you is marked `TODO (<Module> team, Must n)` or `TODO (<Module> team)`, e.g. `TODO (Cart team, Must 2)`. Code without a TODO is finished. Search for `TODO (Cart team` (your module name) to see your whole to-do list.

## Setup (Windows with XAMPP/Laragon, macOS or Linux)

Requirements: PHP 8.3+, Composer, Git. SQLite is used by default, so no database server is needed.

```bash
git clone <repo-url> ecommerce
cd ecommerce
composer install
cp .env.example .env            # Windows: copy .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Open http://localhost:8000

For online payments, also start the mock payment gateway in a second terminal (it plays the role of PayMongo):

```bash
php -S localhost:9000 mock-gateway/index.php
```

| Account | Email | Password |
| --- | --- | --- |
| Admin | `admin@shop.test` | `password` |
| Customer | `customer@shop.test` | `password` |

Demo voucher: `WELCOME10` (10% off). The Vouchers module (`app/Modules/Vouchers`) is unassigned starter code. Sent emails go to `storage/logs/laravel.log`.

To use MySQL instead, set `DB_CONNECTION=mysql` and the `DB_*` values in `.env`, create the database, then run `php artisan migrate:fresh --seed`.

## Groups and modules in NT 3101

| Group | GitHub account | Module | Folder | Difficulty | Members |
| --- | --- | --- | --- | --- | --- |
| 1 | @benidickorcio-sudo | **Payments** | `app/Modules/Payments` | Hard | 4 |
| 2 | _not set yet: add it in your first PR_ | **Inventory + Dashboard** | `app/Modules/Inventory`, `app/Modules/Dashboard` | Medium–hard | 4 |
| 3 | @zickyel | **Checkout & Orders** | `app/Modules/Orders` | Hard | 5 |
| 4 | @euel-villavicencio | **Catalog + Search** | `app/Modules/Catalog`, `app/Modules/Search` | Medium | 4 |
| 5 | @keldigno | **Platform (Repo Admin / QA)** | `tests/Feature/Integration`, `.github`, `docs` | Hard | 4 |
| 6 | _not set yet: add it in your first PR_ | **Users & Auth** | `app/Modules/Users` | Medium | 4 |
| 7 | @fainted19 | **Cart & Wishlist** | `app/Modules/Cart` | Easy | 3 |

Groups that own two modules are graded on Must 1–2 of each module; Must 3–4 count as Stretch. Member names are kept in the class tracker, not in this repo.

**Not assigned in NT 3101** (starter code stays as it is): Notifications, Shipping & Tracking, Reviews & Ratings, Vouchers & Discounts.

## How the code is organized

```
app/
  Contracts/          one interface per module - the ONLY way modules call each other (instructor-owned)
  Events/             OrderPlaced, PaymentConfirmed, OrderCancelled, OrderShipped, StockLow (instructor-owned)
  Providers/ModuleServiceProvider.php   loads every module (instructor-owned)
  Modules/<Module>/
    <Module>ServiceProvider.php   binds your service to your interface, registers your listeners
    Http/Controllers/
    Models/
    Services/                     your implementation of your interface
    Listeners/                    reactions to events from other modules
    database/migrations/          your tables
    views/                        used as view('<module>::file'), e.g. view('cart::index')
    routes.php                    your routes (loaded automatically, with the web middleware)
    README.md                     your module documentation and To do list
database/migrations/  core tables: users, categories, products, orders, order_items (instructor-owned)
resources/views/layouts/app.blade.php  shared layout (instructor-owned)
tests/Feature/StarterFlowTest.php      must always pass
mock-gateway/          fake payment gateway, a separate server (instructor-owned)
```

### Rules for calling another module
1. **Use the interface, not the class.** Type-hint `App\Contracts\CartServiceInterface`, never `CartService`.
2. **React with events.** To act when an order is placed, add a listener for `App\Events\OrderPlaced` in your own module and register it in your provider's `$listen`.
3. **Do not write to another team's tables.** Reading another team's model for display is fine; changing data goes through their interface.
4. **Do not change a contract alone.** Open an issue, get approval from every team that uses it, then the instructor merges the change.

## Git workflow

See [CONTRIBUTING.md](CONTRIBUTING.md). In short: branch from `develop` as `feature/<module>-<task>`, commit with `[Module] message` (e.g. `[Cart] Add remove button`) under your own account, open a PR into `develop`, get your leader's approval, and Platform team tests and merges it. Keep your module `README.md` up to date in the same PR.
