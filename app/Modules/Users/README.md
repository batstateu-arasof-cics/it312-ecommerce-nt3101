# Users & Auth

> [!IMPORTANT]
> **NT 3101 · Group 6** owns this module.

## Team — Group 6
| | |
| --- | --- |
| Group GitHub account | _not set yet: add it in your first PR_ |
| Members | 4 (names are in the class tracker) |

## Scope
Registration, login/logout, password reset, roles (customer/admin), profile, and saved addresses. Every other module depends on this one.

## Progress
**Difficulty:** Medium · starter about 25% done

> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] Login, register, logout
> - [x] `admin` middleware
> - [x] `addresses` table and `Address` model
> - [x] `UserService::find()` and `currentUser()`

**Your work: Must items (graded)**
- [ ] 1. Forgot password and reset password pages (table `password_reset_tokens` exists; mail goes to the log)
- [ ] 2. Profile page: edit name, email and password
- [ ] 3. Address book: list, add, edit, delete, set one default
- [ ] 4. `UserService::getDefaultAddress()` (Orders team and Shipping team need this) + feature tests for login, register and addresses

**Your work: Stretch items (bonus, after all Musts)**
- [ ] Email verification
- [ ] Admin user list with role change

## Interface provided — `App\Contracts\UserServiceInterface`
| Method | Parameters | Returns | Status |
| --- | --- | --- | --- |
| `find` | `int $id` | `?User` | Done |
| `currentUser` | — | `?User` | Done |
| `getDefaultAddress` | `int $userId` | `?Address` | **To do** (returns null) |

## Events
- Fires: none
- Listens to: none

## Dependencies used
None.

## Database
| Table | Columns | Migration file |
| --- | --- | --- |
| `users` (core) | id, name, email, password, role | `database/migrations/0001_01_01_000000_create_users_table.php` |
| `addresses` | user_id, recipient, phone, street, barangay, city, province, region, postal_code, is_default | `database/migrations/2026_01_02_000100_create_addresses_table.php` |

## Routes
| Method | URI | Controller@action | Middleware |
| --- | --- | --- | --- |
| GET/POST | `/login` | `AuthController@showLogin` / `login` | guest |
| GET/POST | `/register` | `AuthController@showRegister` / `register` | guest |
| POST | `/logout` | `AuthController@logout` | auth |

## Setup and testing
- Seeded accounts: `admin@shop.test` / `password`, `customer@shop.test` / `password`
- Manual test: register a new account, log out, log in again, open `/admin` as the customer (expect 403)
- Automated tests:

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
