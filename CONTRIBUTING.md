# Contributing

Thanks for working on the Elegant Fryzjer theme. `main` is a protected branch, so
**all changes land through a pull request** — direct pushes to `main` are rejected.

## Branch → PR → merge

```bash
# 1. Start from an up-to-date main
git checkout main
git pull

# 2. Create a topic branch
git checkout -b <type>/<short-description>     # e.g. fix/kontakt-map, feat/booksy-cta

# 3. Make your change, then lint locally before pushing (see below)

# 4. Commit and push the branch
git commit -am "Short imperative summary"
git push -u origin <branch>

# 5. Open a pull request
gh pr create --fill

# 6. Wait for CI (Lint PHP) to pass, then self-merge
gh pr merge --squash --delete-branch
```

A PR can only merge when:

- All three **Lint PHP** checks pass — `php -l (PHP 7.4 | 8.1 | 8.3)`.
- The branch is **up to date** with `main` (rebase/merge if GitHub says it's behind).

No approving review is required (solo maintainer), but the checks are mandatory and
enforced for everyone, including admins.

## Lint locally before pushing

CI only runs `php -l`. Catch failures before the PR by running the same check:

```bash
find . -type f -name '*.php' -not -path './vendor/*' -print0 | xargs -0 -n1 php -l
```

## Making changes the theme's way

- **Business facts are single-sourced in `inc/config.php`** (`ef_config()` / `ef_services()`):
  NAP, phone, opening hours, service catalogue, booking CTA. Change them there — the
  visible templates *and* the JSON-LD schema both read from it, so they never drift.
  Never hard-code a phone number or an hour into a template.
- **Schema is display-safe:** JSON-LD `openingHoursSpecification` takes literal day/time
  only. Never put prose (notes, "call us") into schema fields.
- **Translations:** Polish is the source language (msgids are Polish). After changing a
  translatable string, update `languages/*.po` and recompile the affected catalog:
  ```bash
  msgfmt --check languages/en_US.po -o languages/en_US.mo
  ```
  Mark machine translations pending review with `[MT-REVIEW]`.
- **Cache-busting:** bump `EF_VER` in `functions.php` for any CSS/JS/template change so
  browsers and the edge cache pick up new assets. Not needed for `.mo`-only updates.
- Keep it lightweight: no page builder, minimal front-end JS, accessible markup.

## Commit messages

Short imperative subject line ("Add …", "Fix …", "Update …"), with a body explaining
*why* when the change isn't obvious.

## Deployment

Merging to `main` does **not** deploy. Publishing to the live server is a separate
manual step with host-specific requirements (SELinux `restorecon`, Redis flush) — see
the **Deployment** section of [`README.md`](README.md).

## Emergency merge (CI unavailable)

Branch protection is enforced on admins, so if GitHub Actions is down and a fix must
ship, an admin can temporarily lift protection, merge, then re-apply it:

```bash
gh api --method DELETE repos/byrdykevich-max/elegant-fryzjer/branches/main/protection
# …merge the PR…
# then re-apply protection (see the repo's branch-protection settings)
```
