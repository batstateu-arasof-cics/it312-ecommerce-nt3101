# Admin Dashboard & Reports

> [!IMPORTANT]
> **NT 3101 · Group 2** owns this module.
> Your group also owns **Inventory & Stock** (`app/Modules/Inventory`).
> **Graded for your group:** Must 1–2 in this module and Must 1–2 in Inventory & Stock. Must 3–4 in both modules count as Stretch (bonus).

## Team — Group 2
| | |
| --- | --- |
| Group GitHub account | _not set yet: add it in your first PR_ |
| Members | 4 (names are in the class tracker) |

## Scope
The admin home page (`/admin`): sales figures, orders by status, top products, low-stock list, and a date-range sales report with CSV export. Also the admin navigation that links to every team's admin pages. Owns no tables.

## Progress
**Difficulty:** Medium–easy · starter about 25% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `/admin` page with total sales and order count
> - [x] `ReportService::salesSummary()` with optional date range
> - [x] Low-stock panel (shows seeded low-stock products)

**Your work: Must items (graded)**
- [ ] 1. Orders by status and top 5 products by quantity sold on the dashboard
- [ ] 2. Sales report page with a date range (`/admin/reports/sales`)
- [ ] 3. CSV export of the report
- [ ] 4. Admin menu partial (`dashboard::partials.admin-menu`) other teams add their links to + feature tests (403 for customers, figures match orders)

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Daily sales chart (Chart.js from a CDN)
- [ ] Average order value and comparison with the previous period

## Interface provided — `App\Contracts\ReportServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `salesSummary` | `?string $from, ?string $to` (Y-m-d) | `array` (total_sales, order_count, …) | Partial |

## Events
- Fires: none
- Listens to: `StockLow` (optional, e.g. flash an alert)

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `admin` middleware | Admin only |
| Catalog team | `Product` | Top products |
| Orders team | `Order`, `OrderItem` | Sales figures |
| Inventory team | `InventoryServiceInterface::lowStock` | Low-stock panel |

## Database
None.

## Routes
| Method | URI | Controller@action | Middleware |
| --- | --- | --- | --- |
| GET | `/admin` | `DashboardController@index` | auth, admin |

## Setup and testing
- Manual test: log in as `admin@shop.test`, open `/admin`; place an order as the customer and refresh
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
