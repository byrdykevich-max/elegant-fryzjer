<?php
/**
 * Elegant Fryzjer — theme functions.
 * Lightweight custom theme: no page builder, minimal JS, mobile-first.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'EF_VER', '1.2.16' ); // bump to bust CSS/JS cache on changes (also flushes rewrite rules)

require_once get_template_directory() . '/inc/config.php';
require_once get_template_directory() . '/inc/gallery.php';
require_once get_template_directory() . '/inc/icons.php';
require_once get_template_directory() . '/inc/schema.php';
require_once get_template_directory() . '/inc/i18n.php';
require_once get_template_directory() . '/inc/sitemap.php';

/* -------------------------------------------------------------------------
 * Theme setup
 * ---------------------------------------------------------------------- */
function ef_setup() {
	add_theme_support( 'title-tag' );            // let WP manage <title>
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	register_nav_menus( array( 'primary' => __( 'Menu główne', 'elegant-fryzjer' ) ) );
}
add_action( 'after_setup_theme', 'ef_setup' );

/* -------------------------------------------------------------------------
 * Assets — one stylesheet, one tiny deferred script. No jQuery on the front end.
 * ---------------------------------------------------------------------- */
function ef_assets() {
	wp_enqueue_style( 'elegant-fryzjer', get_stylesheet_uri(), array(), EF_VER );
	wp_enqueue_script( 'ef-main', get_template_directory_uri() . '/assets/js/main.js', array(), EF_VER, true );
	// Translatable strings for the tiny front-end script (lightbox a11y labels).
	wp_localize_script( 'ef-main', 'EF_I18N', array(
		'lightboxLabel' => __( 'Powiększone zdjęcie', 'elegant-fryzjer' ),
		'close'         => __( 'Zamknij', 'elegant-fryzjer' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'ef_assets' );

// Drop WP emoji script/style — unused weight on a salon site (CWV).
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// The WP Site Icon is set (for wp-admin / login / customizer), but the front-end
// <head> icon set is curated by hand in header.php (.ico + SVG + versioned PNGs +
// manifest). Drop WP's auto front-end output to avoid duplicate icon tags. WP still
// emits the Site Icon on admin_head, so wp-admin/login keep their favicon.
remove_action( 'wp_head', 'wp_site_icon', 99 );

/* -------------------------------------------------------------------------
 * Booking CTA — the single swappable component.
 *  - Booksy URL set  -> primary CTA links to Booksy ("Zarezerwuj online").
 *  - else phone set  -> primary CTA is click-to-call ("Zadzwoń: <number>").
 *  - else (no data)  -> CTA links to the contact form; we never dial a fake number.
 *
 * @param string $variant 'primary' or 'ghost' (style); $label optional override.
 */
function ef_cta( $variant = 'primary', $label = '' ) {
	$c     = ef_config();
	$class = 'btn btn--' . ( $variant === 'ghost' ? 'ghost' : 'primary' );

	if ( ! empty( $c['booksy_url'] ) ) {
		$href  = esc_url( $c['booksy_url'] );
		$text  = $label ?: __( 'Zarezerwuj online', 'elegant-fryzjer' );
		$attrs = ' target="_blank" rel="noopener"';
	} elseif ( ! empty( $c['phone_tel'] ) ) {
		$href  = 'tel:' . preg_replace( '/[^+0-9]/', '', $c['phone_tel'] );
		// "Zadzwoń:" is translated; the number itself is a business fact, never translated.
		$text  = $label ?: ( __( 'Zadzwoń:', 'elegant-fryzjer' ) . ' ' . $c['phone_display'] );
		$attrs = '';
	} else {
		$href  = esc_url( ef_url( '/kontakt/#kontakt-form' ) );
		$text  = $label ?: __( 'Umów wizytę', 'elegant-fryzjer' );
		$attrs = '';
	}
	printf(
		'<a class="%1$s" href="%2$s"%3$s>%4$s</a>',
		esc_attr( $class ), $href, $attrs, esc_html( $text )
	);
}

/** Telephone link for the header utility bar (only when a real number exists). */
function ef_phone_link() {
	$c = ef_config();
	if ( empty( $c['phone_tel'] ) ) {
		return '<span class="phone-placeholder">[PLACEHOLDER – numer telefonu]</span>';
	}
	$tel = preg_replace( '/[^+0-9]/', '', $c['phone_tel'] );
	return sprintf(
		'<a class="phone-link" href="tel:%s"><span class="phone-link__icon" aria-hidden="true">☎</span> %s</a>',
		esc_attr( $tel ), esc_html( $c['phone_display'] )
	);
}

/**
 * Display-only note under the opening hours ("call to arrange another time").
 * DISPLAY text only — never fed into JSON-LD openingHours (schema takes literal
 * day/time). Single-sourced here so footer, front page and Kontakt stay in sync.
 */
function ef_hours_note() {
	echo '<p class="hours-note muted">'
		. esc_html__( 'Nie możesz w tych godzinach? Zadzwoń — po wcześniejszym uzgodnieniu istnieje możliwość umówienia wizyty w innym terminie.', 'elegant-fryzjer' )
		. '</p>';
}

/* -------------------------------------------------------------------------
 * Responsive <picture> with WebP + JPEG fallback for gallery images.
 * Uses pre-generated 768 / 1024 sizes; lazy-loaded, with explicit dimensions
 * to avoid layout shift (CLS).
 * ---------------------------------------------------------------------- */
function ef_picture( $base, $alt, $sizes = '(max-width: 700px) 90vw, 360px', $eager = false ) {
	$url = ef_uploads_url();
	$w768 = "$url/$base-768x768"; $w1024 = "$url/$base-1024x1024";
	$loading = $eager ? 'eager' : 'lazy';
	$fetch   = $eager ? ' fetchpriority="high"' : '';
	ob_start(); ?>
	<picture>
		<source type="image/webp"
		        srcset="<?php echo esc_url( "$w768.webp" ); ?> 768w, <?php echo esc_url( "$w1024.webp" ); ?> 1024w"
		        sizes="<?php echo esc_attr( $sizes ); ?>">
		<img src="<?php echo esc_url( "$w768.jpg" ); ?>"
		     srcset="<?php echo esc_url( "$w768.jpg" ); ?> 768w, <?php echo esc_url( "$w1024.jpg" ); ?> 1024w"
		     sizes="<?php echo esc_attr( $sizes ); ?>"
		     width="768" height="768"
		     loading="<?php echo esc_attr( $loading ); ?>" decoding="async"<?php echo $fetch; ?>
		     alt="<?php echo esc_attr( $alt ); ?>">
	</picture>
	<?php
	return ob_get_clean();
}

/* -------------------------------------------------------------------------
 * Per-page SEO meta description + Open Graph. Pulled from the page's excerpt,
 * or a sensible default. One source of truth so titles/descriptions stay unique.
 * ---------------------------------------------------------------------- */
function ef_meta_description() {
	// Author-set Polish excerpts win for the Polish view; otherwise use the
	// localized description (translated per language via gettext).
	if ( is_page() && 'pl' === ef_lang() ) {
		$ex = get_post_field( 'post_excerpt', get_queried_object_id() );
		if ( $ex ) return wp_strip_all_tags( $ex );
	}
	return ef_localized_description();
}
function ef_head_meta() {
	$desc  = ef_meta_description();
	$title = wp_get_document_title();
	$rel   = ef_current_relpath();
	$cur   = null !== $rel ? ef_lang_url( ef_lang(), $rel ) : home_url( '/' );
	// Self-referential canonical on the FRONT PAGE only (per language). WordPress emits
	// rel_canonical solely on singular views; the front page is the posts index, so it
	// would otherwise have no canonical. Sub-pages get theirs from core (ef_canonical_url),
	// so we must not emit here for them — hence the is_front_page() guard (no duplicates).
	if ( is_front_page() ) {
		echo "\n<link rel=\"canonical\" href=\"" . esc_url( $cur ) . "\">\n";
	}
	echo "\n<meta name=\"description\" content=\"" . esc_attr( $desc ) . "\">\n";
	echo '<meta property="og:type" content="' . ( is_front_page() ? 'website' : 'article' ) . "\">\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . "\">\n";
	echo '<meta property="og:description" content="' . esc_attr( $desc ) . "\">\n";
	echo '<meta property="og:locale" content="' . esc_attr( ef_locale() ) . "\">\n";
	// og:locale:alternate for the other languages.
	foreach ( ef_languages() as $code => $l ) {
		if ( $code !== ef_lang() ) {
			echo '<meta property="og:locale:alternate" content="' . esc_attr( $l['locale'] ) . "\">\n";
		}
	}
	echo '<meta property="og:url" content="' . esc_url( $cur ) . "\">\n";
	echo '<meta property="og:site_name" content="Elegant Fryzjer">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	// OG image: first gallery image (1024 webp) as a representative share image.
	$g = ef_gallery_images();
	if ( ! empty( $g ) ) {
		echo '<meta property="og:image" content="' . esc_url( ef_uploads_url() . '/' . $g[0]['base'] . '-1024x1024.jpg' ) . "\">\n";
	}
}
add_action( 'wp_head', 'ef_head_meta', 5 );

/**
 * Google Search Console verification tag. Rendered only when a token is set in
 * config (ef_config()['gsc_verification']). Independent of indexing settings, so
 * verification works even while the site is noindexed.
 */
function ef_gsc_verify() {
	$c = ef_config();
	$token = isset( $c['gsc_verification'] ) ? trim( $c['gsc_verification'] ) : '';
	if ( $token !== '' ) {
		echo '<meta name="google-site-verification" content="' . esc_attr( $token ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'ef_gsc_verify', 1 );

/* -------------------------------------------------------------------------
 * robots.txt — point crawlers at the WordPress core sitemap.
 * (WordPress serves a virtual robots.txt; we filter it.)
 * ---------------------------------------------------------------------- */
function ef_robots( $output ) {
	$output  = "User-agent: *\n";
	$output .= "Disallow: /wp-admin/\n";
	$output .= "Allow: /wp-admin/admin-ajax.php\n";
	$output .= 'Sitemap: ' . home_url( '/wp-sitemap.xml' ) . "\n";
	return $output;
}
add_filter( 'robots_txt', 'ef_robots', 10, 1 );

/* -------------------------------------------------------------------------
 * Contact form — server-side handler. No third-party plugin, no JS dependency.
 * Honeypot + nonce for spam/CSRF; delivers to the WP admin email via wp_mail.
 * ---------------------------------------------------------------------- */
function ef_handle_contact() {
	if ( empty( $_POST['ef_contact_nonce'] ) || ! wp_verify_nonce( $_POST['ef_contact_nonce'], 'ef_contact' ) ) {
		return; // not our form / bad nonce
	}
	// Honeypot: real users leave 'ef_website' empty.
	if ( ! empty( $_POST['ef_website'] ) ) {
		wp_safe_redirect( add_query_arg( 'wyslano', 'ok', wp_get_referer() ) ); exit;
	}
	$name  = sanitize_text_field( wp_unslash( $_POST['ef_name'] ?? '' ) );
	$email = sanitize_email( wp_unslash( $_POST['ef_email'] ?? '' ) );
	$msg   = sanitize_textarea_field( wp_unslash( $_POST['ef_message'] ?? '' ) );

	if ( ! $name || ! $msg || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'wyslano', 'blad', wp_get_referer() ) ); exit;
	}
	$to      = get_option( 'admin_email' );
	$subject = 'Zapytanie ze strony Elegant Fryzjer — ' . $name;
	$body    = "Imię: $name\nE-mail: $email\n\nWiadomość:\n$msg\n";
	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	wp_mail( $to, $subject, $body, $headers );

	wp_safe_redirect( add_query_arg( 'wyslano', 'ok', wp_get_referer() ) ); exit;
}
add_action( 'admin_post_nopriv_ef_contact', 'ef_handle_contact' );
add_action( 'admin_post_ef_contact', 'ef_handle_contact' );
