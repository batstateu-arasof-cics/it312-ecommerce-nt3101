# Checkout & Orders

> [!IMPORTANT]
> **NT 3101 · Group 3** owns this module.

## Team — Group 3
| | |
| --- | --- |
| Group GitHub account | @zickyel |
| Members | 5 (names are in the class tracker) |

## Scope
Checkout, order creation from the cart, customer order history and detail, cancellation, and admin order management. **This is the hub module: six teams depend on it.** Keep `OrderServiceInterface` and the order events stable.

## Progress
**Difficulty:** Hard · starter about 40% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `Order` and `OrderItem` models, status constants and the allowed `TRANSITIONS` map with `canTransitionTo()`
> - [x] Checkout page and `createFromCart()` (totals, items, clears cart, fires `OrderPlaced`)
> - [x] Customer order history (`/orders`)
> - [x] `hasPurchased()` (used by Reviews team)
> - [x] Listeners `MarkOrderPaid` and `MarkOrderShipped`

**Your work: Must items (graded)**
- [ ] 1. Order detail page (`/orders/{order}`): items, totals, address, payment status, tracking from `ShippingServiceInterface`; owner only
- [ ] 2. Cancel a pending order (`POST /orders/{order}/cancel`); `updateStatus()` enforces `canTransitionTo()` and fires `OrderCancelled`
- [ ] 3. Admin order list with a status dropdown that calls `updateStatus()` (`/admin/orders`)
- [ ] 4. Re-check stock for every item before placing the order + feature tests (totals, empty cart, cancel, invalid transition)

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Address picker at checkout (after Users team's address book)
- [ ] Admin order filters by status and date, admin order detail page

## Interface provided — `App\Contracts\OrderServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `createFromCart` | `int $userId, array $checkout` (address_id, voucher_code, payment_method) | `Order` | Done |
| `find` | `int $orderId` | `?Order` with items | Done |
| `updateStatus` | `int $orderId, string $status` | `Order` | Partial (Must 2: enforce transitions, fire `OrderCancelled`) |
| `hasPurchased` | `int $userId, int $productId` | `bool` | Done |

## Events
- Fires: `OrderPlaced` (done), `OrderCancelled` (Must 2)
- Listens to: `PaymentConfirmed` → `MarkOrderPaid` (done), `OrderShipped` → `MarkOrderShipped` (done)

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `UserServiceInterface::getDefaultAddress` | Shipping address |
| Cart team | `CartServiceInterface::getItems`, `getSubtotal`, `clear` | Build the order |
| Vouchers (unassigned) | `VoucherServiceInterface::apply` | Discount |
| Payments team | `PaymentServiceInterface::createPayment` | Payment record / online checkout |
| Shipping team | `ShippingServiceInterface::getShippingFee` | Shipping fee |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `orders` (core) | user_id, status, subtotal, discount, shipping_fee, total, voucher_code, payment_method, address_id, shipping_address | `database/migrations/2026_01_01_000200_create_orders_tables.php` |
| `order_items` (core) | order_id, product_id, product_name, quantity, unit_price | same file |

## Routes
| Method | URI | Controller@action | Middleware |
| --- | --- | --- | --- |
| GET | `/checkout` | `CheckoutController@show` | auth |
| POST | `/checkout` | `CheckoutController@store` | auth |
| GET | `/orders` | `OrderController@index` | auth |

## Setup and testing
- Manual test: add items to the cart, check out with COD, see the order in `/orders` and the stock go down on the product page
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
