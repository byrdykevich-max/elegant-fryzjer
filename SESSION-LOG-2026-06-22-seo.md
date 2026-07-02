# Session log — 2026-06-22 (pre-launch SEO readiness review + 🔴 fixes)

Site stayed **NOINDEXED** throughout (`blog_public=0`). `EF_VER` 1.2.7 → **1.2.9**.

## Part 1 — SEO readiness review (report only, no changes)
Inspected all 15 page-views (5 pages × pl/en/uk) + JSON-LD, hreflang, robots/sitemap,
images, lab perf. Delivered a prioritized report (🔴/🟡/🟢 + launch checklist). Premise
correction: the `[MT-REVIEW]` EN/UK strings are **already finalized** (0 across all pages).
**Mostly clean:** unique titles/meta, 1 H1/page, valid HairSalon JSON-LD (NAP = "Hemara 5",
no 5A; telephone, geo, Mon–Sat hours, priceRange $$, areaServed, sameAs→IG, offer catalog),
hreflang cluster reciprocal + x-default→pl, alt text present/translated, webp+lazy+dims,
TTFB ~50ms (Redis), click-to-call + lang dropdown.

## Part 2 — fixed the two 🔴 items (deployed + verified)
**🔴#1 Home canonical (`EF_VER 1.2.8`).** Front page is the posts index
(`show_on_front=posts`), not singular → WP emitted no canonical on `/`, `/en/`, `/uk/`.
Added a per-language self-canonical in `ef_head_meta()` (`functions.php`) guarded by
`is_front_page()` (reuses `$cur`, same as og:url). Verified: 1 canonical per home URL
(correct per lang), sub-pages still exactly 1 (no dup).

**🔴#2 Complete multilingual sitemap (`EF_VER 1.2.9`).** WP-core `wp-sitemap.xml` can't
include the rewrite-virtual /en//uk/ URLs or hreflang → **disabled**
(`wp_sitemaps_enabled`→false). New **`inc/sitemap.php`** (required in functions.php) serves
**`/sitemap.xml`** = 15 `<url>` (5 pages × 3 langs), each with `xhtml:link` hreflang
(pl/en/uk + x-default→pl). Verified: HTTP 200, valid XML, 15 loc + 60 alternates;
wp-sitemap.xml now 404.
- ⚠ **robots.txt is a PHYSICAL file** (`/var/www/wordpress/robots.txt`, nginx-served) that
  **shadows** WP's virtual robots.txt — so the `robots_txt` filter in `inc/sitemap.php` is
  inert (kept as fallback). Edited the physical file directly: Sitemap line → `/sitemap.xml`.

Both serve correctly while noindexed (ready for launch; nothing exposed until noindex lifts).

## Verified live
Home canonicals per-lang ✓; `/sitemap.xml` 200 (15 URLs) ✓; `/wp-sitemap.xml` 404 ✓;
robots.txt → `/sitemap.xml` ✓; **page noindex intact** ✓; `EF_VER 1.2.9`.

## Backups (`/home/opc/theme-backups/`)
`functions.php.bak-20260622-203250` (canonical), `functions.php.bak-20260622-203558`
(sitemap wiring), `robots.txt.bak-20260622-203735`. New file: `inc/sitemap.php`.

## Still open — 🟡 (from the review; not yet done)
- Front-page-as-posts → set a static front page; disable `/feed/` + blog archives (or noindex them).
- ~~Enable gzip/brotli~~ → **gzip DONE** (see Part 3); brotli skipped (no module).
- ~~Deactivate astra-sites~~ → **DONE** (see Part 4).
- Real **geo coords** (JSON-LD lat/lng are placeholders 52.3210/21.0510).
- JSON-LD `addressRegion` "Białołęka" → consider "Mazowieckie" (district vs voivodeship).
- Content placeholders: O nas Julia bio, Reviews, privacy/RODO link, Facebook (sameAs IG-only).
## 🟢 roadmap: per-service local landing pages (Białołęka/Tarchomin/Nowodwory), AggregateRating once real reviews, FAQ schema.
## Launch day: lift noindex (blog_public 0→1), verify GSC, submit /sitemap.xml, request indexing.

## Part 3 — gzip enabled (🟡 follow-up; server config, no theme change)
New **`/etc/nginx/conf.d/gzip.conf`** (http-level, `gzip on; gzip_comp_level 5; gzip_vary on;`
+ text/css/js/xml/json/ld+json/svg/font types; html auto-gzipped). `nginx -t` ✓ → graceful
reload (zero downtime). Measured: **HTML −79%** (45→9.4KB), **CSS −73%** (22→5.9KB), **JS −65%**
(4.4→1.6KB), **sitemap.xml −94%** (6.4→0.4KB); `Vary: Accept-Encoding` set; images left
uncompressed; far-future caching + page noindex intact.
- **brotli NOT enabled** — no `ngx_brotli` module on this nginx (1.26.3); would need a
  third-party repo/compile + `load_module`. Recommended skip on this 2-vCPU box (gzip ≈ 90% of win).
- Not a theme change → no `EF_VER` bump. Config copy: `theme-backups/nginx-gzip.conf.added-20260622`.
  Rollback: `sudo rm /etc/nginx/conf.d/gzip.conf && sudo nginx -t && sudo nginx -s reload`.

## Part 4 — astra-sites plugin deactivated (🟡 follow-up; plugin state, no theme change)
Starter-template importer, unused by the custom theme, was leaking 2 frontend scripts. Deactivated
via WP (`deactivate_plugins`, fires deactivation hook) → `active_plugins` now `[]`. Frontend scripts
**3 → 1** (only theme `main.js`; astra-sites `template-preview/main.js` + its `dom-ready.min.js`
dependency gone). All pages 200 (pl/en/uk), noindex + sitemap + canonical intact. Redis unaffected
(`object-cache.php` drop-in, not a plugin). Rollback: reactivate in wp-admin → Plugins
(files still on disk). No `EF_VER` bump.

Docs updated this session: `HANDOFF-i18n.md` (pre-launch SEO-fixes block + gzip-done + astra-sites-done notes + banner EF_VER→1.2.9).
