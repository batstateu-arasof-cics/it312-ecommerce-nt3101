# Contributing rules

Git history is how your contribution is graded. Every line of code must be traceable to a team and a person.

## Branches
- `main` — releases only; the instructor merges into it.
- `develop` — integration branch; all PRs go here.
- `feature/<module>-<short-task>` — your work, e.g. `feature/cart-update-quantity`. Branch from the latest `develop`.

```bash
git checkout develop
git pull
git checkout -b feature/cart-update-quantity
# ...work...
git add .
git commit -m "[Cart] Add quantity update to cart"
git push -u origin feature/cart-update-quantity
```

## Commits
- Commit under **your own** GitHub account. Set it once: `git config --global user.name "Your Name"` and `git config --global user.email "you@example.com"` (the email on your GitHub account).
- Message format: `[Module] Short description in the imperative`, e.g. `[Inventory] Restore stock when an order is cancelled`.
- Small commits. One member committing for the whole team is not accepted.

## Pull requests
- Open the PR into `develop` and fill in the template.
- Your team leader approves it. CODEOWNERS requests the right reviewers automatically.
- A PR that touches another team's folder or `app/Contracts` also needs that team's or the instructor's approval.
- The `tests` check must be green.
- Link the issue: `Closes #12`.
- **Platform team tests and merges it.** They reply within 24 hours: merge, or "Request changes" with a written reason. Do not ask anyone else to merge.
- Platform team's own PRs are reviewed by the instructor.

## Repository settings (instructor, once)
In GitHub: **Settings → Branches → Add branch ruleset** (or classic branch protection).

| Setting | `develop` | `main` |
| --- | --- | --- |
| Require a pull request before merging | on, 1 approval | on, 1 approval |
| Require review from Code Owners | on (owning team approves) | on |
| Require status checks: `tests` | on | on |
| Restrict who can push / merge | the Platform group's GitHub team, `instructors` | `instructors` only |
| Block force pushes and deletion | on | on |

Give every class team **Write** access (they can push feature branches and approve PRs); only the rules above let Platform team merge into `develop`.

## Issues
- Each item in your README's To do list becomes a GitHub issue using the **Module task** template.
- Label it with your module (e.g. `cart`) and assign the member doing it.

## Keeping up to date
Before opening a PR, update your branch so it merges cleanly:

```bash
git checkout develop
git pull
git checkout feature/cart-update-quantity
git merge develop
php artisan migrate:fresh --seed
php artisan test
```

## Never commit
`.env`, API keys, passwords, the `vendor/` folder, or `database/database.sqlite`.
