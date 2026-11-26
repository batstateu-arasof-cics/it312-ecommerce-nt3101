# Payments

> [!IMPORTANT]
> **NT 3101 · Group 1** owns this module.

## Team — Group 1
| | |
| --- | --- |
| Group GitHub account | @benidickorcio-sudo |
| Members | 4 (names are in the class tracker) |

## Scope
Cash on delivery and online payment through a payment gateway. This semester the gateway is the **mock gateway** in `/mock-gateway`: a separate server that behaves like PayMongo (API key, checkout page, signed webhooks). Handles the webhook and confirms payments. This is the project's main external system integration.

## Progress
**Difficulty:** Hard · starter about 40% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `payments` table and `Payment` model
> - [x] Mock payment gateway in `/mock-gateway` (an external system with its own server, API key and signed webhooks)
> - [x] `Gateway/GatewayClient` that creates checkouts on the gateway
> - [x] `createPayment()` for COD and online (online saves `gateway_reference` and `checkout_url`, then checkout redirects there)
> - [x] Webhook route `POST /payments/webhook` (CSRF excluded)

**Your work: Must items (graded)**
- [ ] 1. Return pages `/payments/success` and `/payments/failed` the gateway redirects to, showing the order number and status
- [ ] 2. Webhook signature check in `WebhookController`: reject with 401 unless `X-Mock-Signature` matches (`hash_equals`)
- [ ] 3. `handleWebhook()`: find the payment, update it once (ignore repeats), fire `PaymentConfirmed` on success
- [ ] 4. Feature tests: online checkout with `Http::fake()`, valid and invalid webhook signatures, repeated webhook

**Your work: Stretch items (bonus, after all Musts)**
- [ ] "Pay again" button for a pending online order
- [ ] Swap the mock for the real PayMongo test mode (only the URL, keys and signature header change)

## Interface provided — `App\Contracts\PaymentServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `createPayment` | `Order $order, string $method` (cod, online) | `Payment` | Done |
| `handleWebhook` | `array $payload` | `void` | **Must 3** (logs only) |

## Events
- Fires: `PaymentConfirmed` (Must 3)
- Listens to: none

## Dependencies used
| Module | Interface / method | Why |
| --- | --- | --- |
| Orders team | `Order` model, `CheckoutController` calls `createPayment` | Amount and order link |

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `payments` | order_id, method, status, amount, gateway_reference, checkout_url, paid_at | `database/migrations/2026_01_02_000700_create_payments_table.php` |

## Routes
| Method | URI | Controller@action | Middleware |
| --- | --- | --- | --- |
| POST | `/payments/webhook` | `WebhookController` | web (CSRF excluded) |

## Setup and testing
Run two servers in two terminals:

```bash
php artisan serve                              # the shop, http://localhost:8000
php -S localhost:9000 mock-gateway/index.php   # the gateway, http://localhost:9000
```

- Settings are in `.env` (`PAYMENT_GATEWAY_URL`, `PAYMENT_GATEWAY_SECRET`, `PAYMENT_GATEWAY_WEBHOOK_SECRET`) and read through `config('services.payment_gateway')`.
- Gateway API: `POST /v1/checkouts` with `Authorization: Bearer sk_test_mock`. Webhook body: `{"type": "checkout.paid" | "checkout.failed", "data": {id, reference, amount, status}}`, header `X-Mock-Signature` = HMAC-SHA256 of the raw body with the webhook secret.
- The gateway dashboard at http://localhost:9000 lists every checkout and webhook it sent, and can resend a webhook (use it to test repeats).
- Manual test: check out with "Pay online", click Pay on the gateway page, check the `payments` row and the order status.
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
