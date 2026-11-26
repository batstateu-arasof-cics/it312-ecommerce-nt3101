# Reviews & Ratings

> [!WARNING]
> **Not assigned in NT 3101.** No group works on this module; its starter code stays as it is so the rest of the system keeps working. Changes need the instructor's approval.

## Team
Not assigned in NT 3101.

## Scope
Star ratings and written reviews on the product page. Only customers who bought the product can review it, once per product. Admins can hide reviews.

## Progress
**Difficulty:** Easy · starter about 25% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `reviews` table and `Review` model
> - [x] `getAverageRating()` and the reviews section on the product page
> - [x] Seeded sample reviews; `OrderServiceInterface::hasPurchased()` is ready to use

**Your work: Must items (graded)**
- [ ] 1. Review form and `POST /products/{product}/reviews` with validation (rating 1–5)
- [ ] 2. Only buyers can review (`hasPurchased`), one review per product
- [ ] 3. Admin review list with hide/show (`/admin/reviews`)
- [ ] 4. Move the queries out of the partial into the service + feature tests (non-buyer 403, duplicate rejected)

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Edit or delete your own review
- [ ] Star breakdown (how many 5-star, 4-star, ...)

## Interface provided — `App\Contracts\ReviewServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `getAverageRating` | `int $productId` | `?float` | Done |

## Events
- Fires: none
- Listens to: none

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `auth`, `admin` | Who may post and moderate |
| Catalog team | product page includes the partial | Where reviews show |
| Orders team | `OrderServiceInterface::hasPurchased` | Buyers only |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `reviews` | product_id, user_id, rating, comment, is_approved | `database/migrations/2026_01_02_001200_create_reviews_table.php` |

## Routes
None yet.

## Setup and testing
- Manual test: open any seeded product and check the Reviews section
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
