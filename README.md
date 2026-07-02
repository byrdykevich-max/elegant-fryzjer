# Elegant Fryzjer — WordPress theme

[![Lint PHP](https://github.com/byrdykevich-max/elegant-fryzjer/actions/workflows/lint-php.yml/badge.svg)](https://github.com/byrdykevich-max/elegant-fryzjer/actions/workflows/lint-php.yml)

Custom WordPress theme for **[elegantfryzjer.pl](https://elegantfryzjer.pl)** — a hair salon & barber in
Warszawa, Białołęka. Lightweight and fast: no page builder, minimal front-end JS, mobile-first,
accessible markup. Trilingual (Polish / English / Ukrainian).

> The live site is intentionally **noindexed** (WordPress core `blog_public = 0`), so every page
> emits `<meta name="robots" content="noindex, nofollow">`. Keep it that way until launch.

## Single source of truth

All business facts (NAP, phone, opening hours, service catalogue, booking CTA) live in
**`inc/config.php`** — `ef_config()` and `ef_services()`. The visible templates *and* the
JSON-LD structured data both read from there, so a phone number or an opening hour is changed
in exactly one place and can never drift between the page and the schema.

- **Phone** — set `phone_tel` (digits, for `tel:` links) and `phone_display` (formatted). Empty
  values suppress click-to-call rather than dialing a placeholder.
- **Hours** — `hours` maps `Mo…Su` to `['HH:MM','HH:MM']`, or `null` for a closed day. Closed days
  are omitted from JSON-LD (schema takes literal day/time only — never prose).
- **Booking CTA** — paste a `booksy_url` and it becomes the primary CTA site-wide; otherwise the
  CTA falls back to click-to-call, then to the contact form.

## Layout

```
functions.php        Theme setup, asset enqueue, CTA/phone helpers, meta/OG, contact handler
style.css            Single stylesheet (design tokens + components; dark/light)
header.php footer.php front-page.php page-*.php   Templates
assets/icons/        Favicon / site-icon set (SVG master + versioned PNG/ICO + webmanifest)
assets/js/main.js    Tiny deferred script (gallery lightbox, a11y labels)
inc/config.php       Business config — EDIT THIS to change NAP / hours / services
inc/schema.php       HairSalon JSON-LD (built from config; output in <head>)
inc/i18n.php         Language routing + gettext wiring (pl / en / uk)
inc/gallery.php      Approved gallery image list + responsive <picture> data
inc/sitemap.php      XML sitemap
languages/           gettext catalogs — .pot template + pl_PL / en_US / uk_UA .po/.mo
```

## Internationalization

Polish is the source language (msgids are Polish). `en_US` and `uk_UA` carry translations in
`languages/*.po`, compiled to `*.mo`. After changing any translatable string:

```sh
# recompile the catalog(s) you touched, e.g.
msgfmt --check languages/en_US.po -o languages/en_US.mo
```

Machine-translated strings pending human review are marked `[MT-REVIEW]` in the `.po`.

## Cache-busting

`EF_VER` in `functions.php` versions the enqueued CSS/JS (and `?ver=` on favicon tags). **Bump it**
on any CSS/JS/template change so browsers and the edge cache pick up the new assets. Not needed for
`.mo`-only updates.

## Deployment

The repository is the source of truth (build dir). Deploying to the live server copies the theme
into the web root and requires two easily-forgotten steps on this host:

1. Copy changed files to the live theme dir and `chown` to the web-server user.
2. **`restorecon`** every copied file — SELinux labels files from the home dir as `user_home_t`,
   which php-fpm cannot read (the site would render a blank `200`). Relabel to `httpd_sys_content_t`.
3. Flush the object cache (`redis-cli FLUSHALL`) so a stale/broken response isn't served.

## License

Released under the [MIT License](LICENSE).
