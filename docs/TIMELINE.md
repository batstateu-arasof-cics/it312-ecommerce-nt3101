# 3-week timeline

Day 1 is the day the repo is opened to the class. Every team works on its 4 **Must** items first; **Stretch** items only after all 4 Musts are merged.

| When | Milestone | Done means |
| --- | --- | --- |
| Days 1–2 | **Setup** | Every member cloned the repo, ran `migrate:fresh --seed` and `php artisan test` (green), and the team merged its first PR: the team table in its module README |
| Day 3 | **Contracts frozen** | No more changes to `app/Contracts` or `app/Events` without instructor approval |
| End of week 1 | Must items that need no other team | At least 2 Musts merged per team |
| Week 2 | Integrations | Listeners, events and cross-module features merged |
| End of week 2 (day 10) | **Checkpoint demo** + release `v0.1` | At least 3 Musts merged per team; Platform team tags `v0.1` and demos the whole flow |
| Week 3 | Finish | Last Must, tests, README updates, then Stretch items |
| Day 18 | **Feature freeze** | Only bug fixes and docs merged after this |
| Day 21 | **Final demo** + release `v1.0` | Platform team demos from a fresh clone; each team presents its module in 5 minutes |

## Rules that keep it on time
- Platform team reviews every PR within **24 hours**.
- PRs should be small: one Must item or less. A PR touching 20 files is hard to review in a day.
- If another team blocks you, code against their interface (the starter returns safe data) and tell their liaison the same day.
- Last merge time before each demo: 6 PM the day before.
