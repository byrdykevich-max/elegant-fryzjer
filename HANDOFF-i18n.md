# Elegant Fryzjer — Theme Handoff (Dark/Light + Multilingual)

_Last updated: 2026-06-22 · Theme version `EF_VER = 1.2.9`_

> **i18n COMPLETE (2026-06-22): EN and UK are both DONE.** All 171 strings in each of
> `en_US.po` and `uk_UA.po` are reviewed, finalized, and live (0 `[MT-REVIEW]` in any of
> pl/en/uk). No translation work is pending. See §3 for the wording/transliteration
> conventions that were locked in (useful if any string is ever edited again).

## Post-launch changes — 2026-06-22

**Gallery rebuilt to ~80/20/0 men/women/children (client mix ~80% men).**
_(Supersedes the earlier "prominence-only / 3 men" note — the full Media Library was viewed
and classified by subject: **35 men / 17 women / 0 children + 1 colour detail** (53 total).
The earlier women-heavy look was a wiring mistake, not a shortage. Owner confirmed
**identifiable-face photos are cleared** for use.)_
- `ef_gallery_images()` (`inc/gallery.php`) rebuilt to **21 entries, men-first**: 16 men →
  4 women → 1 colour-detail. Hero, OG image and JSON-LD `image` use index `0` (men's salon
  shot); the gallery page iterates the array, so it's men-first automatically. Homepage
  **featured strip** (`front-page.php`, `$featured = array(2,4,5,7,11,16)`) = **5 men + 1
  woman**; **About hero** (`page-o-nas.php`, `$gall[1]`) is a men's slick-back cut.
  **Resulting ratio: people 16M/4W/0C = 80/20/0** (hero/OG/About 100% men; strip 83% men).
- Each of the **15 new men's photos got a distinct, descriptive `alt`** in pl/en/uk
  (accessibility + lightbox label) — added to the three `.po` and recompiled (**171
  translated msgs** per language, 0 untranslated). Listed in Appendix A rows 157–171.
- **webp note:** WordPress upload here does NOT auto-create `.webp` — only the originally
  wired photos had them. The 15 new photos' `-768x768.webp`/`-1024x1024.webp` were generated
  from the real JPGs via PHP-GD (`imagewebp`, q82) so `ef_picture()`'s `<source>` returns 200.
  When adding photos later, generate their webp too.
- ⚠ **Still 0 children's photos** → the 10% children slot is empty; owner will supply real
  kids' photos (add men-first order preserved, + webp + 3-lang alt). **Never duplicate or
  AI-generate** images to fake the ratio.

**Gallery before/after collage tiles — landscape framing (CSS only).** A couple of gallery
photos are 2-up **before/after collages** (currently the balayage and brown→blonde women's
shots). Their files are square with baked-in white margins, so they letterboxed as ragged
white boxes among the edge-to-edge square tiles (and looked especially bad in dark mode).
Fix: flag those entries `'wide' => true` in `ef_gallery_images()`; the gallery templates add
`gallery__item--wide`, and `style.css` renders those tiles as a **3:2 landscape panel with
`object-fit: cover`** — cropping only the redundant top/bottom whitespace, never the
left↔right before/after. Single photos keep their square. **No image files were re-cropped**
(purely a flag + CSS), so the **lightbox still opens the full uncropped square original**.
To mark a future collage the same way, add `'wide' => true` to its array entry. `EF_VER 1.2.7`.

**Pre-launch SEO fixes (2026-06-22) — the two 🔴 items from the readiness review.**
- **Home canonical (`EF_VER 1.2.8`).** The front page is the **posts index** (`show_on_front=posts`),
  not a static page, so WordPress emitted no `rel_canonical` on `/`, `/en/`, `/uk/` (sub-pages
  got theirs from core). `ef_head_meta()` (`functions.php`) now emits a **per-language
  self-canonical guarded by `is_front_page()`** (uses the same `$cur` as og:url) — exactly one
  canonical on home, none duplicated on sub-pages. _(Cleaner long-term alternative, not done:
  switch to a static front page — would also remove the blog-index `/feed/`/archive cruft, a 🟡 item.)_
- **Complete multilingual sitemap (`EF_VER 1.2.9`).** WP-core `wp-sitemap.xml` can't list the
  rewrite-virtual `/en//uk/` URLs or hreflang, so it's **disabled** (`wp_sitemaps_enabled`→false);
  new `inc/sitemap.php` serves **`/sitemap.xml`** = all 15 per-language URLs, each with
  `xhtml:link` hreflang alternates (pl/en/uk + `x-default`→pl). robots.txt advertises it.
  ⚠ **robots.txt is a PHYSICAL file** at `/var/www/wordpress/robots.txt` (not in the theme) and
  **shadows WordPress's virtual robots.txt** — so the `robots_txt` filter in `inc/sitemap.php` is
  inert (kept only as a fallback if the physical file is removed). The physical file was edited
  directly (Sitemap line → `/sitemap.xml`); backup `theme-backups/robots.txt.bak-*`.
- Both serve correctly **while still noindexed** (ready for launch; nothing exposed until noindex lifts).
- **Launch day:** lift noindex (`blog_public` 0→1), verify GSC, **submit `https://elegantfryzjer.pl/sitemap.xml`**,
  request indexing for the home URLs + key pages. (Full checklist in the SEO readiness report.)
- **gzip enabled (2026-06-22, server config — DONE).** New `/etc/nginx/conf.d/gzip.conf`
  (http-level, `gzip_comp_level 5`) compresses text assets: HTML −79% (45→9.4KB), CSS −73%
  (22→5.9KB), JS −65%, sitemap.xml −94%; `Vary: Accept-Encoding` set, images left
  uncompressed, far-future caching + noindex intact. `nginx -t` + graceful reload. NOT a theme
  change (no EF_VER bump); config copy in `theme-backups/nginx-gzip.conf.added-20260622`,
  rollback = `rm /etc/nginx/conf.d/gzip.conf && nginx -t && nginx -s reload`.
  **brotli NOT enabled** — no `ngx_brotli` module on this nginx (would need a third-party
  repo/compile + `load_module`); gzip captures the bulk, recommended to skip on this 2-vCPU box.
- **astra-sites deactivated (2026-06-22, plugin state — DONE).** It's a starter-template
  importer not used by this custom theme; it was leaking 2 frontend scripts sitewide. After
  deactivation `active_plugins` is empty (Redis stays via the `object-cache.php` drop-in,
  not a plugin), frontend scripts went **3 → 1** (theme `main.js` only), all pages still 200,
  noindex intact. Not a theme change (no EF_VER bump). Plugin files remain on disk — rollback
  = reactivate in wp-admin → Plugins (or `activate_plugins('astra-sites/astra-sites.php')`).
- Still-open 🟡 from the review: front-page-as-posts/feeds cleanup, real geo coords,
  `addressRegion`→Mazowieckie, content placeholders.

**Homepage copy made barber-forward (all 3 languages; H1 unchanged).** Four strings were
reworded — hero eyebrow ("Barber & Salon · …"), hero lead (leads with męskie/broda/barber),
services H2 ("Barber i fryzjer dla całej rodziny"), and the "why us" card. New wording is
in Appendix A rows 27, 29, 33, 51. **These msgids changed**, so `pl_PL/en_US/uk_UA.po`
were updated + recompiled (still 0 `[MT-REVIEW]`), but **`elegant-fryzjer.pot` now lists
the 4 old msgids** — regenerate it via the §5 `xgettext` flow next time strings are added.

_(Also shipped 2026-06-22, documented elsewhere: address `5A`→`5` everywhere incl. JSON-LD
+ the Kontakt page DB excerpt; language switcher → accessible dropdown; dark palette refined
to charcoal + brass-gold, AA-verified. Site remains noindexed throughout.)_

This document covers everything you need to (a) review and finalize the English &
Ukrainian translations and (b) understand the dark/light toggle and the multilingual
setup that were added to the **elegant-fryzjer** theme.

> **Polish is the source of truth and the SEO target.** The site is still
> **noindexed** (`blog_public = 0`). Nothing here changes indexing.

---

## 1. What was delivered

| Phase | Feature | Status |
|---|---|---|
| 1 | Dark/light theme toggle (header), no flash, persisted, `prefers-color-scheme` on first visit, WCAG-AA in both modes | **Live** |
| 2 | Multilingual: `pl` (default) + `en` + `uk`, per-language URLs, hreflang, translated titles/meta, localized JSON-LD | **Live** |
| 3 | This handoff document | — |

**Business facts are never translated.** Address, postcode, city, district, phone,
opening hours and prices come from `inc/config.php` and render **identically** in every
language (verified in the JSON-LD: same NAP / geo / phone / `$$` / `PLN` / hours on
`/`, `/en/`, `/uk/`). To change any of them, edit `inc/config.php` only — not the `.po`
files.

**Prices are now set (live as of 2026-06-21)** — all 13 placeholders in `ef_services()`
have been replaced with real values; `zł` suffix, flat prices except the koloryzacja
group which uses `od … zł` (from-prices):

| Group | Item | Price |
|---|---|---|
| Strzyżenie damskie | Strzyżenie damskie + modelowanie | 90 zł |
| | Modelowanie / układanie | 60 zł |
| | Strzyżenie grzywki | 40 zł |
| Strzyżenie męskie | Strzyżenie męskie | 70 zł |
| | Strzyżenie maszynką | 50 zł |
| Barber — broda i zarost | Strzyżenie brody / trymowanie | 50 zł |
| | Strzyżenie włosów + broda | 110 zł |
| | Golenie maszynką / brzytwą | 80 zł |
| Strzyżenie dziecięce | Strzyżenie dziecięce (do 12 lat) | 50 zł |
| Koloryzacja i rozjaśnianie | Koloryzacja jednolita | od 150 zł |
| | Balayage / sombre | od 250 zł |
| | Rozjaśnianie / dekoloryzacja | od 200 zł |
| | Koloryzacja kreatywna | od 300 zł |

To change a price later, edit the matching `'price' => '…'` value in `ef_services()`
(`inc/config.php`), then `redis-cli FLUSHALL`. Prices are NOT in the `.po`/`.mo` files.

> Still-open `[PLACEHOLDER]` content (not prices): the "O nas" Julia bio, the Reviews
> section, the privacy-policy/RODO link, and the approximate geo coordinates. These are
> separate from this translation/price work.

---

## 2. Per-language URLs created

Polish keeps the bare URLs (no prefix). English uses `/en/…`, Ukrainian `/uk/…`,
same slugs under the prefix.

| Page | Polish (default) | English | Ukrainian |
|---|---|---|---|
| Home | `/` | `/en/` | `/uk/` |
| Usługi i cennik | `/uslugi/` | `/en/uslugi/` | `/uk/uslugi/` |
| O nas | `/o-nas/` | `/en/o-nas/` | `/uk/o-nas/` |
| Galeria | `/galeria/` | `/en/galeria/` | `/uk/galeria/` |
| Kontakt | `/kontakt/` | `/en/kontakt/` | `/uk/kontakt/` |

SEO wiring already in place on every page:
- `<html lang>` = `pl-PL` / `en-US` / `uk-UA`
- `hreflang` alternates for all three languages **+ `x-default` → Polish**
- self-referential `rel="canonical"` per language (e.g. `/en/uslugi/` → `/en/uslugi/`)
- `og:locale` + `og:locale:alternate`
- WordPress canonical-redirect is suppressed for prefixed URLs (so `/en/…` is not
  bounced back to Polish)

The header **language switcher** (PL / EN / UK) links between the equivalent pages and
marks the current one with `aria-current`. The visitor's pick is also stored in
`localStorage` (`ef-lang`), but there is **no auto-redirect** — `/` always stays Polish.

---

## 3. Translations needing native review

- **171 strings** total per language (156 original + 15 gallery alts added 2026-06-22). **Both English and Ukrainian are complete** —
  reviewed and deployed in batches on 2026-06-22; `en_US.po` and `uk_UA.po` each have 0
  `[MT-REVIEW]`. Nothing is in draft. (The `[MT-REVIEW]` prefix was shown on the live,
  noindexed site while drafting, so nothing draft was ever mistaken for final.)
- **19** of them are gallery **alt texts** (accessibility + SEO).
- **36** contain a **place name or the name "Julia"** — please pay special attention
  to these. In particular the Ukrainian drafts transliterate **Białołęka → «Білоленка»**
  and **Warszawa → «Варшава»**; a native speaker should confirm the preferred spelling
  (some prefer keeping the Polish Latin form). "Elegant Fryzjer" is the **brand** and is
  intentionally left in Latin everywhere.

### Wording / transliteration conventions locked in by the owner
**English (EN):**
- **Warszawa → "Warsaw"** (English exonym), but **Białołęka kept in Polish Latin**.
- **British spelling** throughout: colour / colouring / specialise / enquiry.
- **RODO → "GDPR"**.
- "Pełna oferta…" rendered as **"full range of services"**, not "full offer".
- "Golenie maszynką / brzytwą" → **"Clipper / razor shave"** ("maszynką" = "Clipper",
  matching "Strzyżenie maszynką" → "Clipper cut").

**Ukrainian (UK):**
- **Białołęka → «Білоленка»** (Cyrillic transliteration, declined — chosen over keeping the
  Polish Latin form).
- **Warszawa → «Варшава»**, **Julia → «Юлія»** (standard established UA forms).
- **RODO → «GDPR»**.
- "Pełna oferta…" → **«Повний перелік послуг»**.

**Both:** brand **"Elegant Fryzjer"** and **"Salon & Barber"** left untranslated (Latin).

Priority order for review:
1. **Header/nav, buttons, form labels, titles & meta** (rows touching `header.php`,
   `footer.php`, `functions.php`, `inc/i18n.php`) — highest visibility.
2. **Page marketing copy** (the page-*.php hero/lead/section text) — tone matters.
3. **Service catalogue** (`inc/config.php`) — also appears in the JSON-LD.
4. **Gallery alt texts** (`inc/gallery.php`) — descriptive; lowest urgency.

The full table (Polish source ↔ EN draft ↔ UK draft, with the source file and flags)
is in **Appendix A** at the end of this document. Line numbers for each string are in
`languages/elegant-fryzjer.pot`.

---

## 4. How to turn a draft translation into final

You edit the human-readable `.po` file, recompile the binary `.mo`, then deploy + flush.
There is **no WordPress admin screen** for this (theme-level i18n by design).

### Files
```
wp-content/themes/elegant-fryzjer/languages/
  elegant-fryzjer.pot   ← template (all source strings + line refs); don't translate
  pl_PL.po / pl_PL.mo   ← Polish source (msgstr == Polish); normally untouched
  en_US.po / en_US.mo   ← English
  uk_UA.po / uk_UA.mo   ← Ukrainian
```

### Step-by-step (per language you edit)
1. **Open** `languages/en_US.po` (or `uk_UA.po`) in a text editor or a PO editor
   (e.g. Poedit). Each entry looks like:
   ```
   msgid "Kontakt"
   msgstr "[MT-REVIEW] Contact"
   ```
2. **Correct the translation and delete the `[MT-REVIEW] ` prefix:**
   ```
   msgid "Kontakt"
   msgstr "Contact"
   ```
   - Keep any `%s` exactly as-is (it is filled in by code, e.g. a service name).
   - Keep any HTML like `<strong>…</strong>` intact.
   - Do **not** edit the `msgid` (the Polish source) — only the `msgstr`.
3. **Recompile** the `.mo` (binary file WordPress actually loads):
   ```bash
   cd /var/www/wordpress/wp-content/themes/elegant-fryzjer/languages
   msgfmt --check -o en_US.mo en_US.po      # or uk_UA.*
   ```
   `--check` will refuse to compile if a `%s` or format placeholder was broken.
4. **Flush caches** so the new strings show immediately:
   ```bash
   redis-cli FLUSHALL
   ```
   (No `EF_VER` bump is needed for translation-only changes — `.mo` files are not
   version-cached. Bump `EF_VER` in `functions.php` only if you change CSS/JS/templates.)
5. **Verify:** load `/en/kontakt/` (or `/uk/…`) and confirm the string is correct and the
   `[MT-REVIEW]` marker is gone.

### "Am I done?" check
When you have removed every `[MT-REVIEW]` from a language file, this returns 0:
```bash
grep -c '^msgstr.*\[MT-REVIEW\]' uk_UA.po      # 0 = fully reviewed
```
> Note: use the `^msgstr` form above. A plain `grep -c '\[MT-REVIEW\]' uk_UA.po` bottoms
> out at **1** even when fully reviewed, because the `X-Note` header line itself mentions
> the prefix. (`en_US.po` already returns 0 by this check.)

### If you edit the `.po` on your own machine
Edit, run `msgfmt`, then copy **both** `xx.po` and `xx.mo` back to the server's
`languages/` folder (owner `nginx:nginx`, mode `644`) and `redis-cli FLUSHALL`.

---

## 5. Adding or changing a theme string later

If a developer adds new visible text, wrap it in a translation function with the
text domain `elegant-fryzjer`, e.g. `esc_html_e( 'Nowy tekst', 'elegant-fryzjer' )`.
Then regenerate the template and merge into each language:
```bash
cd /var/www/wordpress/wp-content/themes/elegant-fryzjer
xgettext --no-wrap -k__ -k_e -kesc_html__ -kesc_html_e -kesc_attr__ -kesc_attr_e \
  --from-code=UTF-8 -o languages/elegant-fryzjer.pot \
  *.php inc/*.php
for L in pl_PL en_US uk_UA; do msgmerge --update languages/$L.po languages/elegant-fryzjer.pot; done
# translate the new msgids, then: msgfmt --check -o languages/$L.mo languages/$L.po
```

---

## 6. Dark/light theme toggle (Phase 1) — quick reference

- Palettes are CSS custom properties in `style.css`: a **light** `:root` block and a
  **dark** `:root[data-theme="dark"]` block (plus a `prefers-color-scheme` fallback for
  visitors with JS off).
- A tiny inline script in `header.php` sets `data-theme` **before first paint** (no
  flash). Order of precedence: saved choice (`localStorage['ef-theme']`) → OS preference.
- The header button toggles and persists the choice; `aria-pressed` reflects dark.
- Contrast was checked to **WCAG AA in both modes** (lowest pair ≈ 5.6:1).
- To tweak colours, edit the token values in the two palette blocks and bump `EF_VER`.

---

## 7. Backups / rollback

Timestamped copies of the live theme were taken before each deploy, outside the themes
folder so WordPress doesn't treat them as themes:
```
/home/opc/theme-backups/elegant-fryzjer.bak-20260621          (pre-Phase 1)
/home/opc/theme-backups/elegant-fryzjer.bak-phase2-20260621   (pre-Phase 2)
```
To roll back: `sudo cp -a <backup>/. /var/www/wordpress/wp-content/themes/elegant-fryzjer/`
then `redis-cli FLUSHALL`.

The editable source mirror of the theme lives at
`/home/opc/theme-build/elegant-fryzjer/` (this file is there too).

---

## Appendix A — All 171 strings (Polish ↔ EN ↔ UK)

`[MT-REVIEW]` prefixes are omitted below for readability. **Both the EN and UK columns are
now final** (deployed, no prefixes left in `en_US.po` or `uk_UA.po`). A few strings were
reworded from the raw draft per the conventions in §3 — EN: Usługi lead/meta → "full range
of services", "Clipper / razor shave"; UK: Usługi lead/meta → «Повний перелік послуг».

| # | Source | Polish (source of truth) | EN draft (drop `[MT-REVIEW]`) | UK draft (drop `[MT-REVIEW]`) | Flags |
|---|---|---|---|---|---|
| 1 | functions.php, header.php | Menu główne | Main menu | Головне меню |  |
| 2 | functions.php | Powiększone zdjęcie | Enlarged photo | Збільшене фото |  |
| 3 | functions.php | Zamknij | Close | Закрити |  |
| 4 | functions.php | Zarezerwuj online | Book online | Забронювати онлайн |  |
| 5 | functions.php | Zadzwoń: | Call: | Зателефонуйте: |  |
| 6 | functions.php, page-uslugi.php | Umów wizytę | Book an appointment | Записатися на візит |  |
| 7 | header.php | Przejdź do treści | Skip to content | Перейти до вмісту |  |
| 8 | header.php | Elegant Fryzjer — strona główna | Elegant Fryzjer — home page | Elegant Fryzjer — головна сторінка |  |
| 9 | header.php | Salon & Barber · Białołęka | Salon & Barber · Białołęka | Салон & Барбер · Білоленка | place: Białołęka |
| 10 | header.php | Przełącz tryb jasny lub ciemny | Toggle light or dark mode | Перемкнути світлий або темний режим |  |
| 11 | header.php | Przełącz motyw | Toggle theme | Перемкнути тему |  |
| 12 | header.php | Menu | Menu | Меню |  |
| 13 | footer.php, header.php, inc/i18n.php, page-uslugi.php | Usługi i cennik | Services & pricing | Послуги та ціни |  |
| 14 | footer.php, header.php, inc/i18n.php, page-o-nas.php | O nas | About us | Про нас |  |
| 15 | footer.php, header.php, inc/i18n.php, page-galeria.php | Galeria | Gallery | Галерея |  |
| 16 | footer.php, header.php, inc/i18n.php, page-kontakt.php | Kontakt | Contact | Контакти |  |
| 17 | footer.php | Gotowa/gotowy na nowy look? | Ready for a new look? | Готові до нового образу? |  |
| 18 | footer.php | Umów wizytę w Elegant Fryzjer na Białołęce. | Book an appointment at Elegant Fryzjer in Białołęka. | Запишіться на візит до Elegant Fryzjer у Білоленці. | place: Białołęka |
| 19 | footer.php, page-kontakt.php | Jak dojechać | How to get here | Як дістатися |  |
| 20 | footer.php, front-page.php, page-kontakt.php | Adres | Address | Адреса |  |
| 21 | footer.php, front-page.php, page-kontakt.php | Godziny otwarcia | Opening hours | Години роботи |  |
| 22 | footer.php | Do potwierdzenia przez właściciela | To be confirmed by the owner | Підлягає підтвердженню власником |  |
| 23 | footer.php, front-page.php, page-kontakt.php | [do potwierdzenia] | [to be confirmed] | [підлягає підтвердженню] |  |
| 24 | footer.php, front-page.php, page-kontakt.php | nieczynne | closed | зачинено |  |
| 25 | footer.php | Stopka | Footer | Підвал |  |
| 26 | footer.php | Nawigacja | Navigation | Навігація |  |
| 27 | front-page.php | Barber & Salon · Warszawa Białołęka | Barber & Salon · Warsaw Białołęka | Барбер & Салон · Варшава Білоленка | place: Białołęka; place: Warszawa; reworded 2026-06-22 |
| 28 | front-page.php | Elegancka fryzura blisko domu — na Białołęce | An elegant hairstyle close to home — in Białołęka | Елегантна зачіска поруч із домом — у Білоленці | place: Białołęka |
| 29 | front-page.php | Strzyżenie męskie, broda i barber — a także strzyżenie damskie, dziecięce i koloryzacja. Salon prowadzi <strong>Julia</strong> — z dbałością o każdy detal i Twój komfort. | Men's haircuts, beard and barber — plus women's and children's cuts and colouring. The salon is run by <strong>Julia</strong> — with attention to every detail and your comfort. | Чоловічі стрижки, борода та барбер — а також жіночі й дитячі стрижки та фарбування. Салон веде <strong>Юлія</strong> — з увагою до кожної деталі та вашого комфорту. | name: Julia; reworded 2026-06-22 |
| 30 | front-page.php | Zobacz usługi i cennik | See services & pricing | Переглянути послуги та ціни |  |
| 31 | front-page.php | Metamorfozy koloru & strzyżenia | Colour transformations & haircuts | Кольорові перетворення та стрижки |  |
| 32 | front-page.php | Co robimy | What we do | Що ми робимо |  |
| 33 | front-page.php | Barber i fryzjer dla całej rodziny | Barber & hairdresser for the whole family | Барбер і перукар для всієї родини | reworded 2026-06-22 |
| 34 | front-page.php | Jedno miejsce dla kobiet, mężczyzn i dzieci — od codziennego strzyżenia po pełną metamorfozę koloru i usługi barberskie. | One place for women, men and children — from everyday haircuts to full colour transformations and barber services. | Одне місце для жінок, чоловіків і дітей — від щоденних стрижок до повних кольорових перетворень і барбер-послуг. |  |
| 35 | front-page.php, inc/config.php | Strzyżenie damskie | Women's haircut | Жіноча стрижка |  |
| 36 | front-page.php | Strzyżenie, modelowanie i pielęgnacja dopasowane do Twoich włosów. | Cutting, styling and care tailored to your hair. | Стрижка, укладання та догляд, підібрані до вашого волосся. |  |
| 37 | front-page.php, inc/config.php | Strzyżenie męskie | Men's haircut | Чоловіча стрижка |  |
| 38 | front-page.php | Klasyczne i nowoczesne cięcia, stylizacja od ręki. | Classic and modern cuts, styling on the spot. | Класичні та сучасні стрижки, стилізація одразу. |  |
| 39 | front-page.php | Barber — broda | Barber — beard | Барбер — борода |  |
| 40 | front-page.php | Modelowanie i stylizacja brody, tradycyjne golenie. | Beard shaping and styling, traditional shaving. | Моделювання та стилізація бороди, традиційне гоління. |  |
| 41 | front-page.php, inc/config.php | Strzyżenie dziecięce | Children's haircut | Дитяча стрижка |  |
| 42 | front-page.php | Spokojnie i bez stresu — także dla najmłodszych. | Calm and stress-free — also for the youngest. | Спокійно та без стресу — також для найменших. |  |
| 43 | front-page.php | Koloryzacja | Colouring | Фарбування |  |
| 44 | front-page.php | Balayage, rozjaśnianie i metamorfozy koloru po konsultacji. | Balayage, lightening and colour transformations after a consultation. | Balayage, освітлення та кольорові перетворення після консультації. |  |
| 45 | front-page.php | Stylizacja i modelowanie | Styling and finishing | Стилізація та укладання |  |
| 46 | front-page.php | Układanie na specjalne okazje i na co dzień. | Styling for special occasions and every day. | Укладання для особливих подій і на щодень. |  |
| 47 | front-page.php | Pełna lista usług i cennik → | Full list of services & pricing → | Повний перелік послуг і цін → |  |
| 48 | front-page.php | Dlaczego my | Why us | Чому ми |  |
| 49 | front-page.php | Lokalny salon, w którym czujesz się dobrze | A local salon where you feel at ease | Місцевий салон, де ви почуваєтеся добре |  |
| 50 | front-page.php | Dla całej rodziny | For the whole family | Для всієї родини |  |
| 51 | front-page.php | Barber, strzyżenie męskie, damskie i dziecięce w jednym miejscu na Białołęce. | Barber, men's, women's and children's haircuts in one place in Białołęka. | Барбер, чоловічі, жіночі та дитячі стрижки в одному місці в Білоленці. | place: Białołęka; reworded 2026-06-22 |
| 52 | front-page.php | Doświadczenie i pasja | Experience and passion | Досвід і пристрасть |  |
| 53 | front-page.php | Salon prowadzi Julia — strzyżenia i koloryzacja z dbałością o detal. | The salon is run by Julia — haircuts and colouring with attention to detail. | Салон веде Юлія — стрижки та фарбування з увагою до деталей. | name: Julia |
| 54 | front-page.php | Wygodny dojazd | Easy to reach | Зручне розташування |  |
| 55 | front-page.php | W sercu Białołęki — %s. | In the heart of Białołęka — %s. | У серці Білоленки — %s. | place: Białołęka |
| 56 | front-page.php, page-galeria.php | Nasze realizacje | Our work | Наші роботи |  |
| 57 | front-page.php | Efekty pracy salonu | Results of the salon's work | Результати роботи салону |  |
| 58 | front-page.php | Prawdziwe metamorfozy i strzyżenia wykonane w Elegant Fryzjer. | Real transformations and haircuts done at Elegant Fryzjer. | Справжні перетворення та стрижки, виконані в Elegant Fryzjer. |  |
| 59 | front-page.php | Powiększ: %s | Enlarge: %s | Збільшити: %s |  |
| 60 | front-page.php | Zobacz całą galerię → | See the whole gallery → | Переглянути всю галерею → |  |
| 61 | front-page.php | Odwiedź nas | Visit us | Завітайте до нас |  |
| 62 | front-page.php | Adres i godziny | Address and hours | Адреса та години |  |
| 63 | front-page.php, page-kontakt.php | Telefon | Phone | Телефон |  |
| 64 | front-page.php | Mapa i dojazd | Map and directions | Карта та як дістатися |  |
| 65 | front-page.php | Opinie | Reviews | Відгуки |  |
| 66 | front-page.php | Co mówią klienci | What clients say | Що кажуть клієнти |  |
| 67 | index.php | Nie znaleziono strony | Page not found | Сторінку не знайдено |  |
| 68 | index.php | Strona, której szukasz, nie istnieje. | The page you are looking for does not exist. | Сторінка, яку ви шукаєте, не існує. |  |
| 69 | index.php | Wróć na stronę główną | Back to home page | Повернутися на головну |  |
| 70 | page-uslugi.php | Cennik | Pricing | Ціни |  |
| 71 | page-uslugi.php | Pełna oferta salonu Elegant Fryzjer na Białołęce. Ceny koloryzacji zależą od długości i gęstości włosów — dokładną wycenę podajemy po krótkiej konsultacji. | Full offer of Elegant Fryzjer salon in Białołęka. Colouring prices depend on hair length and thickness — we give an exact quote after a short consultation. | Повна пропозиція салону Elegant Fryzjer у Білоленці. Ціни на фарбування залежать від довжини та густоти волосся — точну вартість повідомляємо після короткої консультації. | place: Białołęka |
| 72 | page-uslugi.php | Kategorie usług | Service categories | Категорії послуг |  |
| 73 | page-uslugi.php | Cennik: %s | Price list: %s | Прайс-лист: %s |  |
| 74 | page-o-nas.php | Salon prowadzi Julia | The salon is run by Julia | Салон веде Юлія | name: Julia |
| 75 | page-o-nas.php | Elegant Fryzjer to kameralny salon fryzjerski i barber na warszawskiej Białołęce, w którym liczy się indywidualne podejście i dobre samopoczucie klienta. | Elegant Fryzjer is an intimate hair and barber salon in Warsaw's Białołęka, where an individual approach and the client's wellbeing matter most. | Elegant Fryzjer — це затишний перукарський і барбер-салон у варшавській Білоленці, де найважливіші індивідуальний підхід і добре самопочуття клієнта. | place: Białołęka |
| 76 | page-o-nas.php | Specjalizujemy się w strzyżeniach damskich, męskich i dziecięcych, koloryzacji i rozjaśnianiu oraz usługach barberskich — modelowaniu i stylizacji brody. | We specialise in women's, men's and children's haircuts, colouring and lightening, as well as barber services — beard shaping and styling. | Ми спеціалізуємося на жіночих, чоловічих і дитячих стрижках, фарбуванні та освітленні, а також барбер-послугах — моделюванні та стилізації бороди. |  |
| 77 | page-o-nas.php | Zobacz realizacje | See our work | Переглянути роботи |  |
| 78 | page-o-nas.php | Nasze podejście | Our approach | Наш підхід |  |
| 79 | page-o-nas.php | Na czym nam zależy | What matters to us | Що для нас важливо |  |
| 80 | page-o-nas.php | Konsultacja | Consultation | Консультація |  |
| 81 | page-o-nas.php | Zanim zaczniemy, rozmawiamy o Twoich oczekiwaniach i kondycji włosów. | Before we start, we talk about your expectations and the condition of your hair. | Перш ніж почати, ми обговорюємо ваші очікування та стан волосся. |  |
| 82 | page-o-nas.php | Jakość | Quality | Якість |  |
| 83 | page-o-nas.php | Sprawdzone produkty i staranne wykończenie każdej fryzury. | Trusted products and careful finishing of every hairstyle. | Перевірені продукти та ретельне завершення кожної зачіски. |  |
| 84 | page-o-nas.php | Komfort | Comfort | Комфорт |  |
| 85 | page-o-nas.php | Spokojna, przyjazna atmosfera — także dla dzieci. | A calm, friendly atmosphere — also for children. | Спокійна, доброзичлива атмосфера — також для дітей. |  |
| 86 | page-galeria.php | Prawdziwe metamorfozy, koloryzacje i strzyżenia wykonane w salonie Elegant Fryzjer. Kliknij zdjęcie, aby powiększyć. | Real transformations, colourings and haircuts done at the Elegant Fryzjer salon. Click a photo to enlarge it. | Справжні перетворення, фарбування та стрижки, виконані в салоні Elegant Fryzjer. Натисніть на фото, щоб збільшити. |  |
| 87 | page-galeria.php | Powiększ zdjęcie: %s | Enlarge photo: %s | Збільшити фото: %s |  |
| 88 | page-kontakt.php | Skontaktuj się z nami | Get in touch | Зв'яжіться з нами |  |
| 89 | page-kontakt.php | Umów wizytę lub zadaj pytanie — odpowiemy najszybciej, jak to możliwe. | Book an appointment or ask a question — we'll reply as soon as possible. | Запишіться на візит або поставте запитання — відповімо якнайшвидше. |  |
| 90 | page-kontakt.php | Napisz do nas | Write to us | Напишіть нам |  |
| 91 | page-kontakt.php | Dziękujemy! Wiadomość została wysłana — odezwiemy się wkrótce. | Thank you! Your message has been sent — we'll be in touch soon. | Дякуємо! Повідомлення надіслано — ми скоро зв'яжемося. |  |
| 92 | page-kontakt.php | Nie udało się wysłać wiadomości. Sprawdź pola i spróbuj ponownie. | The message could not be sent. Check the fields and try again. | Не вдалося надіслати повідомлення. Перевірте поля та спробуйте ще раз. |  |
| 93 | page-kontakt.php | Nie wypełniaj | Do not fill in | Не заповнюйте |  |
| 94 | page-kontakt.php | Imię i nazwisko | Full name | Ім'я та прізвище |  |
| 95 | page-kontakt.php | E-mail | E-mail | E-mail |  |
| 96 | page-kontakt.php | Wiadomość | Message | Повідомлення |  |
| 97 | page-kontakt.php | Wyślij wiadomość | Send message | Надіслати повідомлення |  |
| 98 | page-kontakt.php | Wysyłając formularz zgadzasz się na kontakt w sprawie zapytania. | By submitting the form you agree to be contacted regarding your enquiry. | Надсилаючи форму, ви погоджуєтеся на контакт щодо вашого запиту. |  |
| 99 | page-kontakt.php | Mapa Google ładuje się dopiero po kliknięciu (ochrona prywatności / RODO). | The Google map loads only after you click (privacy protection / GDPR). | Карта Google завантажується лише після натискання (захист приватності / GDPR). |  |
| 100 | page-kontakt.php | Pokaż mapę dojazdu | Show the map | Показати карту проїзду |  |
| 101 | page-kontakt.php | Otwórz w Mapach Google → | Open in Google Maps → | Відкрити в Google Maps → |  |
| 102 | page-kontakt.php | Mapa dojazdu do salonu Elegant Fryzjer | Directions map to Elegant Fryzjer salon | Карта проїзду до салону Elegant Fryzjer |  |
| 103 | inc/config.php, inc/i18n.php | Salon fryzjerski w Białołęce | Hair salon in Białołęka | Перукарський салон у Білоленці | place: Białołęka |
| 104 | inc/config.php | Poniedziałek | Monday | Понеділок |  |
| 105 | inc/config.php | Wtorek | Tuesday | Вівторок |  |
| 106 | inc/config.php | Środa | Wednesday | Середа |  |
| 107 | inc/config.php | Czwartek | Thursday | Четвер |  |
| 108 | inc/config.php | Piątek | Friday | П'ятниця |  |
| 109 | inc/config.php | Sobota | Saturday | Субота |  |
| 110 | inc/config.php | Niedziela | Sunday | Неділя |  |
| 111 | inc/config.php | Strzyżenie, modelowanie i pielęgnacja dopasowane do struktury Twoich włosów. | Cutting, styling and care tailored to your hair structure. | Стрижка, укладання та догляд, підібрані до структури вашого волосся. |  |
| 112 | inc/config.php | Strzyżenie damskie + modelowanie | Women's haircut + styling | Жіноча стрижка + укладання |  |
| 113 | inc/config.php | Modelowanie / układanie | Styling / blow-dry | Укладання |  |
| 114 | inc/config.php | Strzyżenie grzywki | Fringe trim | Стрижка чубчика |  |
| 115 | inc/config.php | Klasyczne i nowoczesne strzyżenia męskie, stylizacja od ręki. | Classic and modern men's haircuts, styling on the spot. | Класичні та сучасні чоловічі стрижки, стилізація одразу. |  |
| 116 | inc/config.php | Strzyżenie maszynką | Clipper cut | Стрижка машинкою |  |
| 117 | inc/config.php | Barber — broda i zarost | Barber — beard and stubble | Барбер — борода та щетина |  |
| 118 | inc/config.php | Stylizacja brody, modelowanie i tradycyjne golenie. | Beard styling, shaping and traditional shaving. | Стилізація бороди, моделювання та традиційне гоління. |  |
| 119 | inc/config.php | Strzyżenie brody / trymowanie | Beard trim | Стрижка бороди / тримінг |  |
| 120 | inc/config.php | Strzyżenie włosów + broda | Haircut + beard | Стрижка волосся + борода |  |
| 121 | inc/config.php | Golenie maszynką / brzytwą | Machine / razor shave | Гоління машинкою / бритвою |  |
| 122 | inc/config.php | Spokojnie i bez stresu — strzyżenie dla najmłodszych. | Calm and stress-free — haircuts for the youngest. | Спокійно та без стресу — стрижка для найменших. |  |
| 123 | inc/config.php | Strzyżenie dziecięce (do 12 lat) | Children's haircut (up to 12 years) | Дитяча стрижка (до 12 років) |  |
| 124 | inc/config.php | Koloryzacja i rozjaśnianie | Colouring and lightening | Фарбування та освітлення |  |
| 125 | inc/config.php | Koloryzacja, balayage, rozjaśnianie i metamorfozy koloru. Cena zależna od długości i gęstości włosów — dokładną wycenę podajemy po konsultacji. | Colouring, balayage, lightening and colour transformations. The price depends on hair length and thickness — we give an exact quote after a consultation. | Фарбування, balayage, освітлення та кольорові перетворення. Ціна залежить від довжини та густоти волосся — точну вартість повідомляємо після консультації. |  |
| 126 | inc/config.php | Koloryzacja jednolita | Single-colour dye | Однотонне фарбування |  |
| 127 | inc/config.php | Balayage / sombre | Balayage / sombre | Balayage / sombre |  |
| 128 | inc/config.php | Rozjaśnianie / dekoloryzacja | Lightening / bleaching | Освітлення / знебарвлення |  |
| 129 | inc/config.php | Koloryzacja kreatywna | Creative colouring | Креативне фарбування |  |
| 130 | inc/schema.php | Salon fryzjerski i barber w Warszawie na Białołęce — strzyżenie damskie, męskie i dziecięce, koloryzacja, stylizacja brody. Prowadzi Julia. | Hair and barber salon in Warsaw's Białołęka — women's, men's and children's haircuts, colouring, beard styling. Run by Julia. | Перукарський і барбер-салон у варшавській Білоленці — жіночі, чоловічі та дитячі стрижки, фарбування, стилізація бороди. Веде Юлія. | place: Białołęka; place: Warszawa; name: Julia |
| 131 | inc/schema.php | Usługi fryzjerskie i barberskie | Hairdressing and barber services | Перукарські та барбер-послуги |  |
| 132 | inc/gallery.php | Metamorfoza: koloryzacja balayage i modelowanie miękkich fal — efekt przed i po | Transformation: balayage colouring and soft waves styling — before and after | Перетворення: фарбування balayage та укладання м'яких хвиль — до та після | alt text |
| 133 | inc/gallery.php | Metamorfoza koloru: z ciemnego brązu na rozjaśniony blond z falami — przed i po | Colour transformation: from dark brown to lightened blonde with waves — before and after | Кольорове перетворення: з темно-коричневого на освітлений блонд з хвилями — до та після | alt text |
| 134 | inc/gallery.php | Rozjaśnianie włosów do platynowego blondu — efekt przed i po | Lightening hair to platinum blonde — before and after | Освітлення волосся до платинового блонду — до та після | alt text |
| 135 | inc/gallery.php | Metamorfoza koloru: z czerni na ciepły kasztan — przed i po | Colour transformation: from black to warm chestnut — before and after | Кольорове перетворення: з чорного на теплий каштан — до та після | alt text |
| 136 | inc/gallery.php | Damskie cieniowane strzyżenie i koloryzacja, długie włosy blond — widok z tyłu | Women's layered cut and colouring, long blonde hair — back view | Жіноча багатошарова стрижка та фарбування, довге світле волосся — вигляд ззаду | alt text |
| 137 | inc/gallery.php | Strzyżenie cieniowane na długich włosach blond — widok z tyłu | Layered cut on long blonde hair — back view | Багатошарова стрижка на довгому світлому волоссі — вигляд ззаду | alt text |
| 138 | inc/gallery.php | Koloryzacja blond z delikatnymi rozjaśnieniami, włosy do ramion | Blonde colouring with subtle highlights, shoulder-length hair | Світле фарбування з делікатними пасмами, волосся до плечей | alt text |
| 139 | inc/gallery.php | Długie włosy w odcieniu miedzi po koloryzacji — widok z tyłu | Long copper-toned hair after colouring — back view | Довге волосся мідного відтінку після фарбування — вигляд ззаду | alt text |
| 140 | inc/gallery.php | Długie, proste włosy w odcieniu kasztanu po koloryzacji | Long, straight chestnut-toned hair after colouring | Довге пряме волосся каштанового відтінку після фарбування | alt text |
| 141 | inc/gallery.php | Przygotowanie do koloryzacji — długie ciemne włosy, widok z tyłu | Preparation for colouring — long dark hair, back view | Підготовка до фарбування — довге темне волосся, вигляд ззаду | alt text |
| 142 | inc/gallery.php | Detal zabiegu koloryzacji — nałożony preparat na pasma włosów | Detail of the colouring process — product applied to hair strands | Деталь процесу фарбування — нанесений засіб на пасма волосся | alt text |
| 143 | inc/gallery.php | Kreatywna koloryzacja w odcieniach zieleni i żółci — widok z tyłu | Creative colouring in shades of green and yellow — back view | Креативне фарбування у відтінках зеленого та жовтого — вигляд ззаду | alt text |
| 144 | inc/gallery.php | Kreatywna koloryzacja neonowa — widok z góry | Creative neon colouring — top view | Креативне неонове фарбування — вигляд зверху | alt text |
| 145 | inc/gallery.php | Krótkie damskie strzyżenie bob — widok z tyłu | Short women's bob cut — back view | Коротка жіноча стрижка боб — вигляд ззаду | alt text |
| 146 | inc/gallery.php | Strzyżenie bob z wycieniowanym tyłem głowy | Bob cut with a tapered back | Стрижка боб з градуйованою потилицею | alt text |
| 147 | inc/gallery.php | Precyzyjne krótkie strzyżenie bob — widok z tyłu | Precise short bob cut — back view | Точна коротка стрижка боб — вигляд ззаду | alt text |
| 148 | inc/gallery.php | Strzyżenie męskie, krótkie włosy — widok z tyłu | Men's haircut, short hair — back view | Чоловіча стрижка, коротке волосся — вигляд ззаду | alt text |
| 149 | inc/gallery.php | Męskie strzyżenie i stylizacja — wnętrze salonu Elegant Fryzjer na Białołęce | Men's haircut and styling — interior of the Elegant Fryzjer salon in Białołęka | Чоловіча стрижка та стилізація — інтер'єр салону Elegant Fryzjer у Білоленці | alt text; place: Białołęka |
| 150 | inc/gallery.php | Męskie strzyżenie — widok z tyłu, salon Elegant Fryzjer | Men's haircut — back view, Elegant Fryzjer salon | Чоловіча стрижка — вигляд ззаду, салон Elegant Fryzjer | alt text |
| 151 | inc/i18n.php | Elegant Fryzjer — salon fryzjerski i barber w Warszawie na Białołęce. Strzyżenie damskie, męskie i dziecięce, koloryzacja, broda. Prowadzi Julia. | Elegant Fryzjer — hair and barber salon in Warsaw's Białołęka. Women's, men's and children's haircuts, colouring, beard. Run by Julia. | Elegant Fryzjer — перукарський і барбер-салон у варшавській Білоленці. Жіночі, чоловічі та дитячі стрижки, фарбування, борода. Веде Юлія. | place: Białołęka; place: Warszawa; name: Julia |
| 152 | inc/i18n.php | Pełna oferta i cennik salonu Elegant Fryzjer na Białołęce — strzyżenie damskie, męskie i dziecięce, koloryzacja, broda. | Full offer and pricing of the Elegant Fryzjer salon in Białołęka — women's, men's and children's haircuts, colouring, beard. | Повна пропозиція та ціни салону Elegant Fryzjer у Білоленці — жіночі, чоловічі та дитячі стрижки, фарбування, борода. | place: Białołęka |
| 153 | inc/i18n.php | Poznaj Elegant Fryzjer — kameralny salon fryzjerski i barber na warszawskiej Białołęce. Salon prowadzi Julia. | Meet Elegant Fryzjer — an intimate hair and barber salon in Warsaw's Białołęka. The salon is run by Julia. | Знайомтеся з Elegant Fryzjer — затишний перукарський і барбер-салон у варшавській Білоленці. Салон веде Юлія. | place: Białołęka; name: Julia |
| 154 | inc/i18n.php | Galeria realizacji salonu Elegant Fryzjer — metamorfozy koloru, koloryzacje i strzyżenia. | Gallery of work by the Elegant Fryzjer salon — colour transformations, colourings and haircuts. | Галерея робіт салону Elegant Fryzjer — кольорові перетворення, фарбування та стрижки. |  |
| 155 | inc/i18n.php | Kontakt i dojazd do salonu Elegant Fryzjer na Białołęce. Umów wizytę lub zadaj pytanie. | Contact and directions to the Elegant Fryzjer salon in Białołęka. Book an appointment or ask a question. | Контакти та як дістатися салону Elegant Fryzjer у Білоленці. Запишіться на візит або поставте запитання. | place: Białołęka |
| 156 | inc/i18n.php | Wybór języka | Language selection | Вибір мови |  |
| 157 | inc/gallery.php | Męskie strzyżenie z włosami zaczesanymi do tyłu i pełnym zarostem — profil | Men's slicked-back cut with a full beard — side profile | Чоловіча стрижка із зачесаним назад волоссям і повною бородою — профіль | gallery alt; men; added 2026-06-22 |
| 158 | inc/gallery.php | Męskie strzyżenie: teksturowana góra z przejściem (fade) i krótka broda — z boku | Men's textured top with a fade and short beard — side view | Чоловіча стрижка: текстурований верх із переходом (фейд) і коротка борода — збоку | gallery alt; men; added 2026-06-22 |
| 159 | inc/gallery.php | Klasyczny pompadour z uniesioną górą — ujęcie trzy czwarte z przodu | Classic pompadour with volume on top — front three-quarter view | Класичний помпадур з об'ємним верхом — вигляд три чверті спереду | gallery alt; men; added 2026-06-22 |
| 160 | inc/gallery.php | Rozłączony undercut z włosami zaczesanymi do tyłu i wysokim przejściem — profil | Disconnected undercut with swept-back top and high fade — side profile | Роз'єднаний андеркат із зачесаним назад волоссям і високим переходом — профіль | gallery alt; men; added 2026-06-22 |
| 161 | inc/gallery.php | Krótkie strzyżenie na jeża ze skórnym przejściem (skin fade) — z boku | Short buzz cut with a skin fade — side view | Коротка стрижка «їжачок» зі шкірним переходом (скін-фейд) — збоку | gallery alt; men; added 2026-06-22 |
| 162 | inc/gallery.php | Młodzieżowe strzyżenie typu crop z grzywką i niskim przejściem — z boku | Textured crop with a fringe and low fade — side view | Молодіжна стрижка кроп із чубчиком і низьким переходом — збоку | gallery alt; men; added 2026-06-22 |
| 163 | inc/gallery.php | Krótkie teksturowane strzyżenie męskie ze średnim przejściem — z boku | Short textured men's cut with a mid fade — side view | Коротка текстурована чоловіча стрижка із середнім переходом — збоку | gallery alt; men; added 2026-06-22 |
| 164 | inc/gallery.php | Męskie strzyżenie z krótkim, teksturowanym wierzchem i przyciętą brodą — z boku | Men's short textured top with a trimmed beard — side view | Чоловіча стрижка з коротким текстурованим верхом і підстриженою бородою — збоку | gallery alt; men; added 2026-06-22 |
| 165 | inc/gallery.php | Krótkie męskie strzyżenie z przejściem i lekkim zarostem — profil | Short men's fade with light stubble — side profile | Коротка чоловіча стрижка з переходом і легкою щетиною — профіль | gallery alt; men; added 2026-06-22 |
| 166 | inc/gallery.php | Krótkie męskie strzyżenie z przejściem i pełną brodą — od przodu | Short men's cut with a fade and full beard — front view | Коротка чоловіча стрижка з переходом і повною бородою — спереду | gallery alt; men; added 2026-06-22 |
| 167 | inc/gallery.php | Męskie strzyżenie z uniesioną górą i cieniowanym tyłem — widok z tyłu | Men's swept-up top with a tapered back — rear view | Чоловіча стрижка з піднятим верхом і градуйованою потилицею — вигляд ззаду | gallery alt; men; added 2026-06-22 |
| 168 | inc/gallery.php | Męskie strzyżenie typu crop z teksturą — od przodu | Textured crop haircut — front view | Чоловіча стрижка кроп із текстурою — спереду | gallery alt; men; added 2026-06-22 |
| 169 | inc/gallery.php | Krótkie męskie strzyżenie z pełną, wymodelowaną brodą — od przodu | Short men's cut with a full, shaped beard — front view | Коротка чоловіча стрижка з повною доглянутою бородою — спереду | gallery alt; men; added 2026-06-22 |
| 170 | inc/gallery.php | Bardzo krótkie strzyżenie na jeża ze skórnym przejściem — widok z tyłu | Very short buzz cut with a skin fade — rear view | Дуже коротка стрижка «їжачок» зі шкірним переходом — вигляд ззаду | gallery alt; men; added 2026-06-22 |
| 171 | inc/gallery.php | Młodzieżowe strzyżenie typu crop z teksturą — widok z tyłu | Textured crop — rear view | Молодіжна стрижка кроп із текстурою — вигляд ззаду | gallery alt; men; added 2026-06-22 |
