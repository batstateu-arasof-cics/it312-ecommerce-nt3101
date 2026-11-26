# Grading rubric

Grades come from what is merged into `develop` and from Git history. Work that only exists on a laptop or an unmerged branch does not count.

## Team grade (70%)

| Criterion | Weight | Full marks |
| --- | --- | --- |
| Must items | 40% | All 4 Must items merged and working in the final demo (10% each) |
| Integration | 10% | Uses other modules only through contracts and events; the full flow (`StarterFlowTest` + Platform team's integration tests) still passes |
| Tests | 10% | At least one feature test per Must item, all green in CI |
| Documentation | 5% | Module README up to date: progress, interface, routes, tables, changelog; diagrams added for new integrations |
| Final demo | 5% | Module shown working in 5 minutes; every member can explain part of it |
| Stretch items | bonus, up to +10% | +5% per merged Stretch item, maximum 2 |

**Platform team** is graded on its own 4 Must items the same way (40%), plus review quality (10%: on time, written reasons), integration tests (10%), release notes and demos (10%).

## Individual grade (30%)

| Criterion | Weight | Full marks |
| --- | --- | --- |
| Commits | 15% | Regular commits under your own account across the 3 weeks, `[Module] message` format, meaningful messages |
| Pull requests | 10% | Authored at least 2 merged PRs with a filled-in template |
| Reviews | 5% | Reviewed your teammates' PRs with real comments (leaders: approvals; others: comments) |

A member with no commits in `develop` gets 0 for the individual grade, whatever the team grade.

## Deductions
- Writing to another team's table or changing `app/Contracts` without approval: −5% team grade per incident
- Committing `.env`, keys or passwords: −5% team grade
- Breaking `develop` and leaving it red for more than 24 hours: −5% team grade
