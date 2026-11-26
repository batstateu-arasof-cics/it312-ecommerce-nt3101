# Cart & Wishlist

> [!IMPORTANT]
> **NT 3101 · Group 7** owns this module.

## Team — Group 7
| | |
| --- | --- |
| Group GitHub account | @fainted19 |
| Members | 3 (names are in the class tracker) |

## Scope
Shopping cart (add, update quantity, remove, subtotal) and wishlist (save for later, move to cart). The cart is stored in the database, so it survives logout.

## Progress
**Difficulty:** Easy · starter about 25% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `cart_items` and `wishlist_items` tables and models
> - [x] Add to cart, cart page with subtotal
> - [x] `CartService::getItems()`, `getSubtotal()`, `clear()`

**Your work: Must items (graded)**
- [ ] 1. Stock check when adding (`CatalogServiceInterface::isAvailable`)
- [ ] 2. Update quantity, with ownership check
- [ ] 3. Remove item, with ownership check
- [ ] 4. Wishlist: add/remove on the product page and a wishlist page + feature tests (stock limit, another user's item gives 403)

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Move a wishlist item to the cart
- [ ] Cart item count in the nav (coordinate with Platform team; layout is shared)

## Interface provided — `App\Contracts\CartServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `getItems` | `int $userId` | `Collection` of `CartItem` with `product` | Done |
| `getSubtotal` | `int $userId` | `float` | Done |
| `clear` | `int $userId` | `void` | Done |

## Events
- Fires: none
- Listens to: none

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `auth` | Cart belongs to a user |
| Catalog team | `CatalogServiceInterface::isAvailable`, `Product` | Stock check, product data |
| Orders team | route `checkout.show` | Checkout button |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `cart_items` | user_id, product_id, quantity (unique user+product) | `database/migrations/2026_01_02_000400_create_cart_tables.php` |
| `wishlist_items` | user_id, product_id (unique user+product) | same file |

## Routes
| Method | URI | Controller@action | Middleware |
| --- | --- | --- | --- |
| GET | `/cart` | `CartController@index` | auth |
| POST | `/cart/{product}` | `CartController@add` | auth |

## Setup and testing
- Manual test: log in as `customer@shop.test`, add two products, open `/cart`
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
