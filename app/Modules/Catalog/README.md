# Product Catalog

> [!IMPORTANT]
> **NT 3101 · Group 4** owns this module.
> Your group also owns **Search & Filters** (`app/Modules/Search`).
> **Graded for your group:** Must 1–2 in this module and Must 1–2 in Search & Filters. Must 3–4 in both modules count as Stretch (bonus).

## Team — Group 4
| | |
| --- | --- |
| Group GitHub account | @euel-villavicencio |
| Members | 4 (names are in the class tracker) |

## Scope
Categories, product listing, product detail page, and admin product management with image upload. Owner of the `products` and `categories` tables.

## Progress
**Difficulty:** Medium–easy · starter about 25% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `Category` and `Product` models, core tables
> - [x] Product listing with pagination and product detail page
> - [x] `CatalogService::getProduct()` and `isAvailable()`

**Your work: Must items (graded)**
- [ ] 1. Category page (`/categories/{slug}`) and working links in the sidebar
- [ ] 2. Admin product list, create, edit, deactivate (`/admin/products`) with validation (price > 0, unique slug from name)
- [ ] 3. Product image upload to `storage/app/public/products`; update `Product::imageUrl()`
- [ ] 4. Admin category create, edit, delete + feature tests for the admin pages

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Multiple images per product
- [ ] "Related products" on the product page

## Interface provided — `App\Contracts\CatalogServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `getProduct` | `int $id` | `?Product` (active only) | Done |
| `isAvailable` | `int $productId, int $qty` | `bool` | Done |

## Events
- Fires: none
- Listens to: none

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `admin` middleware | Protect admin pages |
| Cart team | route `cart.add` | Add to cart button on the product page |
| Reviews team | view `reviews::partials.product-reviews` | Reviews section on the product page |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `categories` (core) | name, slug, parent_id | `database/migrations/2026_01_01_000100_create_catalog_tables.php` |
| `products` (core) | category_id, name, slug, description, price, stock, image, is_active | same file |

`stock` is changed only by Inventory team. The admin form may set the starting stock when a product is created.

## Routes
| Method | URI | Controller@action | Middleware |
| --- | --- | --- | --- |
| GET | `/products` | `ProductController@index` | — |
| GET | `/products/{product:slug}` | `ProductController@show` | — |

## Setup and testing
- Seeded data: 4 categories, 12 products
- Manual test: open `/products`, open a product, check price and stock
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
