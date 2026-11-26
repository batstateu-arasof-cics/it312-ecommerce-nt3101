# Vouchers & Discounts — unassigned

> No team owns this module this semester (Platform team is the Platform team). The starter code stays so checkout keeps working: the seeded code `WELCOME10` applies a discount. Changes here need the instructor's approval.

## Team
Not assigned in NT 3101.

## Scope
Admin-managed voucher codes (fixed amount or percent, minimum spend, expiry, usage limit) that customers apply at checkout.

## Progress
> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `vouchers` and `voucher_redemptions` tables, `Voucher` model
> - [x] `VoucherService::apply()` — finds an active code and computes a fixed or percent discount
> - [x] `RedeemVoucher` listener on `OrderPlaced` (calls `redeem()`)
> - [x] Seeded voucher `WELCOME10` (10% off)

**To do**
- [ ] `apply()`: reject expired codes, subtotal below `min_spend`, used-up codes
- [ ] `redeem()`: record the redemption and increment `used_count` in a transaction
- [ ] Admin voucher list, create, edit, deactivate (`/admin/vouchers`)
- [ ] Show why a code was rejected (coordinate with Orders team on the checkout page)
- [ ] Feature tests for each rule

## Interface provided — `App\Contracts\VoucherServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `apply` | `?string $code, float $subtotal` | `float` discount | Partial |
| `redeem` | `string $code, int $orderId` | `void` | **To do** |

## Events
- Fires: none
- Listens to: `OrderPlaced` → `Listeners/RedeemVoucher`

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `admin` middleware | Admin pages |
| Orders team | `OrderPlaced` event, `orders.voucher_code` | Redemption |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `vouchers` | code, type, value, min_spend, usage_limit, used_count, expires_at, is_active | `database/migrations/2026_01_02_000500_create_vouchers_tables.php` |
| `voucher_redemptions` | voucher_id, order_id | same file |

## Routes
None yet.

## Setup and testing
- Manual test: enter `WELCOME10` at checkout, check the discount line
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
