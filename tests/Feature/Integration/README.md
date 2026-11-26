# Platform (Integration & QA)

> [!IMPORTANT]
> **NT 3101 · Group 5** is the Platform group (Repo Admin / QA).
> Only this group (and the instructor) can merge into `develop`.

## Team — Group 5
| | |
| --- | --- |
| Group GitHub account | @keldigno |
| Members | 4 (names are in the class tracker) |

## Scope
Platform team owns the integration of all modules. It reviews, tests and merges every pull request into `develop`, keeps CI green, flags merge conflicts, and publishes two releases (checkpoint and final). It does not own a module; its code is the integration test suite and the CI setup.

**Difficulty:** Hard · starter about 40% done

## Progress
> [!NOTE]
> **Already done in the starter: do not rebuild these.** Read this code first; your work builds on it.
>
> - [x] `StarterFlowTest`: browse, cart, COD checkout, stock, payment record, email log, admin access
> - [x] Integration test template: `CancelOrderFlowTest.php` (skipped until the teams it covers merge)
> - [x] PR template with a Platform review checklist, `CHANGELOG.md`, `docs/FAQ.md`
> - [x] Branch rules set up by the instructor (only Platform team can merge into `develop`)

**Your work: Must items (graded)**
- [ ] 1. Review every PR within **24 hours** using the PR checklist: merge, or "Request changes" with a written reason
- [ ] 2. Three integration tests: enable `CancelOrderFlowTest`, plus online payment → order paid (Orders and Payments teams) and low stock → admin dashboard (Orders and Inventory teams). Notifications, Shipping and Reviews are not assigned in this section, so leave them out of your tests
- [ ] 3. Two releases on `develop`: `v0.1` at the week-2 checkpoint and `v1.0` for the final demo, each with notes in `CHANGELOG.md`
- [ ] 4. Run the checkpoint and final demos from a fresh clone (`migrate:fresh --seed`), and keep `docs/FAQ.md` updated with every setup problem a team hits

**Your work: Stretch items (bonus, after all Musts)**
- [ ] More integration tests: low stock → dashboard + admin email; buyer-only reviews
- [ ] Code style check in CI (`./vendor/bin/pint --test`)

## Limits
- Platform team cannot merge its own PRs; the instructor reviews them.
- Only the instructor merges `develop` into `main`.
- Merge conflicts are fixed by the PR author. Platform team only tells them which files clash.
- Platform team does not write features for other teams; it reports bugs in the review and the owning team fixes them.

## Graded on
Integration tests written, review comments, merge history, release notes and demos.

## Changelog
| Date | Change | PR # | Author |
| --- | --- | --- | --- |
| | Starter code from instructor | — | Instructor |
