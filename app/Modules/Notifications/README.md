# Notifications

> [!WARNING]
> **Not assigned in NT 3101.** No group works on this module; its starter code stays as it is so the rest of the system keeps working. Changes need the instructor's approval.

## Team
Not assigned in NT 3101.

## Scope
Emails for every order event (placed, paid, cancelled, shipped) and low-stock alerts to admins, sent through a queue and logged. In development, mail goes to the log or to Mailtrap (an external integration).

## Progress
**Difficulty:** Medium · starter about 25% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `notification_logs` table and model
> - [x] `NotificationService::send()` sends plain-text mail and logs it
> - [x] `SendOrderPlacedEmail` listener on `OrderPlaced`

**Your work: Must items (graded)**
- [ ] 1. One Mailable with a Blade template for the order email (order number, items, total)
- [ ] 2. Listeners and templates for `PaymentConfirmed` (receipt), `OrderCancelled`, `OrderShipped` (tracking number)
- [ ] 3. `StockLow` listener that emails every admin
- [ ] 4. Feature tests with `Mail::fake()` for each event

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Queue the mails (`ShouldQueue`) and use Mailtrap
- [ ] Admin page listing `notification_logs` with "resend" for failed ones

## Interface provided — `App\Contracts\NotificationServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `send` | `User $user, string $template, array $data` | `void` | Partial (plain text, `order_placed` only) |

## Events
- Fires: none
- Listens to: `OrderPlaced` (done); `PaymentConfirmed`, `OrderCancelled`, `OrderShipped`, `StockLow` (to do)

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Users team | `User` email, admin role | Recipients |
| Orders team | `Order`, order events | Content |
| Payments team | `PaymentConfirmed` | Receipt |
| Inventory team | `StockLow` | Admin alert |
| Shipping team | `OrderShipped`, `Shipment` | Tracking email |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `notification_logs` | user_id, template, channel, status, data, error | `database/migrations/2026_01_02_001000_create_notification_logs_table.php` |

## Routes
None yet.

## Setup and testing
- With `MAIL_MAILER=log`, sent mails appear in `storage/logs/laravel.log`
- Manual test: place an order, check the log file and the `notification_logs` table
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
