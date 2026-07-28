<?php
/**
 * Theme-level internationalization (no plugin).
 *
 * Languages: pl (default / source, no URL prefix), en (/en/), uk (/uk/).
 *  - URL-prefix routing via rewrite rules + a public 'ef_lang' query var.
 *  - Per-request locale switch so gettext (__(), _e(), …) + .mo files translate
 *    every theme string, including the JSON-LD and per-language <title>/meta.
 *  - Language-aware internal links (ef_url), <html lang>, hreflang, og:locale.
 *
 * Business facts (NAP, phone, hours, prices) are NEVER translated — they live in
 * inc/config.php as plain literals and render identically in every language.
 * Polish remains the default and the SEO target; "/" is unchanged.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Supported languages. 'pl' is the default/source and carries no URL prefix.
 * 'prefix' is the first path segment; 'locale' is the WP locale to switch to.
 */
function ef_languages() {
	return array(
		'pl' => array( 'locale' => 'pl_PL', 'label' => 'Polski',     'hreflang' => 'pl', 'prefix' => ''   ),
		'en' => array( 'locale' => 'en_US', 'label' => 'English',    'hreflang' => 'en', 'prefix' => 'en' ),
		'uk' => array( 'locale' => 'uk_UA', 'label' => 'Українська', 'hreflang' => 'uk', 'prefix' => 'uk' ),
	);
}

/**
 * Resolve the current request language from the URL's first path segment.
 * Runs early (used by the 'locale' filter) so it cannot rely on query vars yet.
 * Falls back to 'pl'. Admin/login/cron keep the site default locale.
 */
function ef_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}
	$lang = 'pl';
	$path = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '/';

	// Normalise away a sub-directory install path, if any (e.g. /blog/en/…).
	$home_path = (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH );
	if ( '' !== $home_path && '/' !== $home_path && 0 === strpos( $path, $home_path ) ) {
		$path = '/' . substr( $path, strlen( $home_path ) );
	}

	$first = strtok( ltrim( $path, '/' ), '/' );
	foreach ( ef_languages() as $code => $l ) {
		if ( '' !== $l['prefix'] && $first === $l['prefix'] ) {
			$lang = $code;
			break;
		}
	}
	return $lang;
}

/** WP locale for a language code (defaults to the current request language). */
function ef_locale( $code = null ) {
	$code  = $code ?: ef_lang();
	$langs = ef_languages();
	return isset( $langs[ $code ] ) ? $langs[ $code ]['locale'] : 'pl_PL';
}

/* -------------------------------------------------------------------------
 * 1) Switch WordPress to the request locale (front-end only).
 *    This is what makes every __()/_e() in the theme resolve to en/uk.
 * ---------------------------------------------------------------------- */
function ef_set_locale( $locale ) {
	if ( is_admin() || ( defined( 'DOING_CRON' ) && DOING_CRON ) ) {
		return $locale; // never touch admin / cron / login locale
	}
	return ef_locale( ef_lang() );
}
add_filter( 'locale', 'ef_set_locale' );

/** Load the theme's translation files from /languages. */
function ef_load_textdomain() {
	load_theme_textdomain( 'elegant-fryzjer', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'ef_load_textdomain' );

/* -------------------------------------------------------------------------
 * 2) URL routing: /en/ and /uk/ prefixes -> front page / pages.
 * ---------------------------------------------------------------------- */
function ef_add_query_var( $vars ) {
	$vars[] = 'ef_lang';
	return $vars;
}
add_filter( 'query_vars', 'ef_add_query_var' );

function ef_rewrite_rules() {
	foreach ( ef_languages() as $code => $l ) {
		if ( '' === $l['prefix'] ) {
			continue; // pl: default routing, no prefix
		}
		$p = $l['prefix'];
		// /en/            -> front page in en
		add_rewrite_rule( '^' . $p . '/?$', 'index.php?ef_lang=' . $code, 'top' );
		// /en/uslugi/     -> page "uslugi" in en
		add_rewrite_rule( '^' . $p . '/([^/]+)/?$', 'index.php?pagename=$matches[1]&ef_lang=' . $code, 'top' );
	}
}
add_action( 'init', 'ef_rewrite_rules' );

/**
 * Flush rewrite rules exactly once after a theme version change (deploy),
 * so the /en/ and /uk/ routes register without a manual Permalinks re-save.
 */
function ef_maybe_flush_rewrites() {
	if ( get_option( 'ef_rewrite_ver' ) !== EF_VER ) {
		flush_rewrite_rules( false );
		update_option( 'ef_rewrite_ver', EF_VER );
	}
}
add_action( 'init', 'ef_maybe_flush_rewrites', 99 );

/* -------------------------------------------------------------------------
 * 3) Language-aware links.
 * ---------------------------------------------------------------------- */
/** Internal URL in the CURRENT language (use instead of home_url() in templates). */
function ef_url( $path = '/' ) {
	return ef_lang_url( ef_lang(), '/' . ltrim( $path, '/' ) );
}

/** Build an internal URL for a specific language code + root-relative path. */
function ef_lang_url( $code, $rel = '/' ) {
	$langs  = ef_languages();
	$prefix = isset( $langs[ $code ] ) ? $langs[ $code ]['prefix'] : '';
	$prefix = '' !== $prefix ? '/' . $prefix : '';
	if ( '/' === $rel ) {
		return home_url( '' === $prefix ? '/' : $prefix . '/' );
	}
	return home_url( $prefix . $rel );
}

/** Keep assigned-menu item URLs in-language (the fallback menu uses ef_url directly). */
function ef_localize_menu( $items ) {
	if ( 'pl' === ef_lang() ) {
		return $items;
	}
	$home = home_url( '/' );
	foreach ( $items as $it ) {
		if ( isset( $it->url ) && 0 === strpos( $it->url, $home ) ) {
			$rel    = '/' . ltrim( substr( $it->url, strlen( $home ) ), '/' );
			$it->url = ef_lang_url( ef_lang(), $rel );
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'ef_localize_menu' );

/**
 * Keep prefixed URLs intact: stop WordPress's canonical redirect from stripping
 * /en/ or /uk/ back to the bare Polish permalink.
 */
function ef_keep_prefixed_url( $redirect_url ) {
	return ( 'pl' !== ef_lang() ) ? false : $redirect_url;
}
add_filter( 'redirect_canonical', 'ef_keep_prefixed_url' );

/**
 * Self-referential canonical per language: on /en/uslugi/ the canonical must be
 * /en/uslugi/, NOT the Polish /uslugi/ (otherwise hreflang collapses).
 */
function ef_canonical_url( $url ) {
	if ( 'pl' === ef_lang() ) {
		return $url;
	}
	$rel = ef_current_relpath();
	return $rel ? ef_lang_url( ef_lang(), $rel ) : $url;
}
add_filter( 'get_canonical_url', 'ef_canonical_url' );

/* -------------------------------------------------------------------------
 * 4) The canonical root-relative path of the current view (front page or page),
 *    used to build the per-language alternates and the switcher links.
 *    Returns null for views we don't expose alternates for (404, etc.).
 * ---------------------------------------------------------------------- */
function ef_current_relpath() {
	// Porady routes (index/single/category — see inc/blog.php) are Polish-only
	// and must never get hreflang/alternates. Must be checked BEFORE
	// is_front_page(): WP's own front-page fallback (show_on_front === 'posts')
	// misclassifies the unrecognised /porady/ index query as the front page.
	if ( get_query_var( 'ef_blog' ) || is_singular( 'post' ) || is_category() ) {
		return null;
	}
	if ( is_front_page() ) {
		return '/';
	}
	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		if ( $slug ) {
			return '/' . $slug . '/';
		}
	}
	return null;
}

/* -------------------------------------------------------------------------
 * 5) hreflang alternates (+ x-default -> pl). Output high in <head>.
 * ---------------------------------------------------------------------- */
function ef_hreflang_tags() {
	$rel = ef_current_relpath();
	if ( null === $rel ) {
		return;
	}
	foreach ( ef_languages() as $code => $l ) {
		printf(
			'<link rel="alternate" hreflang="%s" href="%s">' . "\n",
			esc_attr( $l['hreflang'] ),
			esc_url( ef_lang_url( $code, $rel ) )
		);
	}
	// x-default points at Polish (the default / SEO target).
	printf(
		'<link rel="alternate" hreflang="x-default" href="%s">' . "\n",
		esc_url( ef_lang_url( 'pl', $rel ) )
	);
}
add_action( 'wp_head', 'ef_hreflang_tags', 6 );

/* -------------------------------------------------------------------------
 * 6) Per-language <title> and meta description.
 *    Site name "Elegant Fryzjer" is a brand and is never translated.
 * ---------------------------------------------------------------------- */
function ef_title_parts( $parts ) {
	if ( get_query_var( 'ef_blog' ) ) {
		// Porady blog index (custom route — see inc/blog.php), checked first:
		// WP's front-page fallback (show_on_front === 'posts') misclassifies this
		// unrecognised query as the front page, so an is_front_page() branch
		// above this one would win and print the wrong title. Core's own
		// wp_get_document_title() also runs its is_front_page() branch BEFORE
		// this filter, pre-setting $parts['tagline'] (site description) instead
		// of $parts['site'] (site name) — swap that back so the title reads
		// "Porady – Elegant Fryzjer" like every other non-front page.
		$parts['title'] = __( 'Porady', 'elegant-fryzjer' );
		unset( $parts['tagline'] );
		$parts['site'] = get_bloginfo( 'name' );
	} elseif ( is_front_page() ) {
		$parts['tagline'] = __( 'Salon fryzjerski w Białołęce', 'elegant-fryzjer' );
	} elseif ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$map  = array(
			'uslugi'  => __( 'Usługi i cennik', 'elegant-fryzjer' ),
			'o-nas'   => __( 'O nas', 'elegant-fryzjer' ),
			'galeria' => __( 'Galeria', 'elegant-fryzjer' ),
			'kontakt' => __( 'Kontakt', 'elegant-fryzjer' ),
			'polityka-prywatnosci' => __( 'Polityka prywatności', 'elegant-fryzjer' ),
		);
		if ( isset( $map[ $slug ] ) ) {
			$parts['title'] = $map[ $slug ];
		}
	}
	// Single posts and category archives get their title from WordPress core
	// as usual (post title / category name) — no branch needed here for those.
	return $parts;
}
add_filter( 'document_title_parts', 'ef_title_parts' );

/**
 * Per-page meta description (translatable). Front page + the four pages get a
 * distinct, localized description; everything else uses the localized default.
 */
function ef_localized_description() {
	$default = __( 'Elegant Fryzjer — salon fryzjerski i barber w Warszawie na Białołęce. Strzyżenie damskie, męskie i dziecięce, barber, broda. Prowadzi Julia.', 'elegant-fryzjer' );
	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$map  = array(
			'uslugi'  => __( 'Pełna oferta i cennik salonu Elegant Fryzjer na Białołęce — strzyżenie damskie, męskie i dziecięce, barber, broda.', 'elegant-fryzjer' ),
			'o-nas'   => __( 'Poznaj Elegant Fryzjer — kameralny salon fryzjerski i barber na warszawskiej Białołęce. Salon prowadzi Julia.', 'elegant-fryzjer' ),
			'galeria' => __( 'Galeria realizacji salonu Elegant Fryzjer — metamorfozy koloru, koloryzacje i strzyżenia.', 'elegant-fryzjer' ),
			'kontakt' => __( 'Kontakt i dojazd do salonu Elegant Fryzjer na Białołęce. Umów wizytę lub zadaj pytanie.', 'elegant-fryzjer' ),
			'polityka-prywatnosci' => __( 'Polityka prywatności salonu Elegant Fryzjer — jak przetwarzamy dane osobowe odwiedzających i klientów.', 'elegant-fryzjer' ),
		);
		if ( isset( $map[ $slug ] ) ) {
			return $map[ $slug ];
		}
	}
	return $default;
}

/* -------------------------------------------------------------------------
 * 7) Accessible language switcher (rendered in the header).
 * ---------------------------------------------------------------------- */
function ef_language_switcher() {
	$rel = ef_current_relpath();
	if ( null === $rel ) {
		$rel = '/'; // e.g. 404 — still let visitors pick a language home
	}
	$current = ef_lang();
	$label   = esc_attr__( 'Wybór języka', 'elegant-fryzjer' );

	// Disclosure dropdown. The trigger shows the current language code; the menu
	// lists all languages (current marked aria-current). Without JS the .js class
	// is absent, so CSS hides the trigger and shows the menu inline (links still work).
	echo '<nav class="lang-switcher" aria-label="' . $label . '" data-lang-switcher>';
	printf(
		'<button class="lang-switcher__toggle" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="ef-lang-menu" data-lang-toggle>'
			. '<span class="lang-switcher__current" aria-hidden="true">%1$s</span>'
			. '<svg class="lang-switcher__caret" width="12" height="12" viewBox="0 0 12 12" aria-hidden="true" focusable="false"><path fill="currentColor" d="M6 8.5 1.5 4h9z"/></svg>'
			. '<span class="screen-reader-text">%2$s</span>'
			. '</button>',
		esc_html( strtoupper( $current ) ),
		$label
	);
	echo '<ul class="lang-switcher__menu" id="ef-lang-menu">';
	foreach ( ef_languages() as $code => $l ) {
		$is_current = ( $code === $current );
		printf(
			'<li><a class="lang-switcher__link%1$s" href="%2$s" hreflang="%3$s" lang="%3$s" data-ef-lang="%4$s"%5$s>%6$s</a></li>',
			$is_current ? ' is-current' : '',
			esc_url( ef_lang_url( $code, $rel ) ),
			esc_attr( $l['hreflang'] ),
			esc_attr( $code ),
			$is_current ? ' aria-current="true"' : '',
			esc_html( $l['label'] )
		);
	}
	echo '</ul></nav>';
}
