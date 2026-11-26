# FAQ

Maintained by Platform team. Add a question every time a team gets stuck on something another team could hit too.

## Setup

**`could not find driver` when migrating**
Enable `pdo_sqlite` (or `pdo_mysql`) in `php.ini`. In XAMPP: open `php.ini`, remove the `;` before `extension=pdo_sqlite`, restart.

**`No application encryption key has been specified`**
Run `php artisan key:generate`.

**My new route returns 404**
Check that it is in your module's `routes.php`, then run `php artisan route:clear` and `php artisan route:list --path=<your-uri>`.

## Git

**I committed to `develop` by mistake**
Don't push. Run `git branch feature/<module>-<task>` (saves your work), then `git reset --hard origin/develop`, then `git checkout feature/<module>-<task>`.

**My PR has conflicts**
`git checkout develop && git pull && git checkout <your-branch> && git merge develop`, fix the marked files, then commit and push. Ask Platform team if the conflict is in another team's files.

## Modules

**How do I call another team's code?**
Type-hint its interface from `app/Contracts` in your constructor or controller method. Laravel passes in the implementation.

**I need another team's method that isn't built yet**
Code against the interface anyway; the starter returns safe placeholder data. Tell that team directly or through their liaison.
