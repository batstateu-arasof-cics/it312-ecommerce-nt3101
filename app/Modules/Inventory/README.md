# Inventory & Stock

> [!IMPORTANT]
> **NT 3101 · Group 2** owns this module.
> Your group also owns **Admin Dashboard & Reports** (`app/Modules/Dashboard`).
> **Graded for your group:** Must 1–2 in this module and Must 1–2 in Admin Dashboard & Reports. Must 3–4 in both modules count as Stretch (bonus).

## Team — Group 2
| | |
| --- | --- |
| Group GitHub account | _not set yet: add it in your first PR_ |
| Members | 4 (names are in the class tracker) |

## Scope
Keeps `products.stock` correct: deducts on orders, restores on cancellation, records every change, alerts on low stock, and lets admins restock or correct stock. **The only module allowed to change `products.stock`.**

## Progress
**Difficulty:** Medium–hard · starter about 40% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `stock_movements` table and `StockMovement` model
> - [x] `deductStock()` with row locking, one `sale` movement per item, run by the `DeductStockOnOrder` listener
> - [x] `RestoreStockOnCancel` listener registered
> - [x] Low-stock threshold in `config/inventory.php` (`LOW_STOCK_THRESHOLD`, default 5) and `lowStock()`

**Your work: Must items (graded)**
- [ ] 1. `restoreStock()`: add quantities back, record `cancel` movements, run only once per order
- [ ] 2. Fire `StockLow` when a sale takes a product to or below the threshold
- [ ] 3. Admin stock page (`/admin/inventory`): every product's stock with a restock form that records a `restock` movement
- [ ] 4. Feature tests: order deducts, cancel restores once, restock adds, `StockLow` fires (`Event::fake()`)

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Per-product stock history page
- [ ] Manual correction with a reason (`adjustment` movements, can be negative)

## Interface provided — `App\Contracts\InventoryServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `deductStock` | `Order $order` | `void` | Done |
| `restoreStock` | `Order $order` | `void` | **Must 1** |
| `lowStock` | — | `Collection` of `Product` | Done |

## Events
- Fires: `StockLow` (Must 2)
- Listens to: `OrderPlaced` → `DeductStockOnOrder`, `OrderCancelled` → `RestoreStockOnCancel`

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Catalog team | `Product` | Stock column |
| Orders team | `Order`, order events | What to deduct or restore |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `stock_movements` | product_id, order_id, user_id, change, reason | `database/migrations/2026_01_02_000800_create_stock_movements_table.php` |

The low-stock threshold is a setting, not a column: `config('inventory.low_stock_threshold')`, set by `LOW_STOCK_THRESHOLD` in `.env`.

## Routes
None yet.

## Setup and testing
- Manual test: note a product's stock, place an order for 2, check the stock dropped by 2 and a `stock_movements` row exists
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
