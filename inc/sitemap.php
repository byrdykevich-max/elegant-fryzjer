<?php
/**
 * Complete multilingual XML sitemap for Elegant Fryzjer.
 *
 * Lists all 15 per-language URLs (5 pages × pl/en/uk) with hreflang alternates
 * (incl. x-default → Polish). The WordPress-core sitemap (wp-sitemap.xml) is disabled
 * because it can only list real WP objects — it would miss the rewrite-virtual /en/ and
 * /uk/ URLs and carries no hreflang. Served at /sitemap.xml (advertised in robots.txt).
 *
 * Also lists the Polish-only Porady blog (inc/blog.php): the /porady/ index plus
 * one entry per published post, as plain <url><loc>+<lastmod></url> — no
 * <xhtml:link> alternates, since there is no other-language version to link to.
 *
 * Served even while the site is noindexed — it's just an XML file, ready to submit at
 * launch; crawlers still honour the page-level noindex until that is lifted.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

// 1) Disable the incomplete WP-core sitemap so there is a single source of truth.
add_filter( 'wp_sitemaps_enabled', '__return_false' );

// 2) Advertise our sitemap in the (virtual) robots.txt.
add_filter( 'robots_txt', function ( $out ) {
	$out = preg_replace( '/^Sitemap:.*$/mi', '', $out );
	return rtrim( $out ) . "\n\nSitemap: " . home_url( '/sitemap.xml' ) . "\n";
}, 20 );

// 3) Serve /sitemap.xml — all per-language URLs + hreflang alternates.
add_action( 'init', function () {
	$path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
	if ( '/sitemap.xml' !== $path ) {
		return;
	}

	$paths = array( '/', '/uslugi/', '/o-nas/', '/galeria/', '/kontakt/' );
	$langs = ef_languages(); // pl / en / uk

	if ( ! headers_sent() ) {
		header( 'Content-Type: application/xml; charset=UTF-8' );
		header( 'X-Robots-Tag: noindex', true ); // the sitemap file itself need not be indexed
	}
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
	foreach ( $paths as $rel ) {
		foreach ( array_keys( $langs ) as $code ) {
			echo "\t<url>\n\t\t<loc>" . esc_url( ef_lang_url( $code, $rel ) ) . "</loc>\n";
			foreach ( array_keys( $langs ) as $alt ) {
				echo "\t\t" . '<xhtml:link rel="alternate" hreflang="' . esc_attr( $langs[ $alt ]['hreflang'] )
					. '" href="' . esc_url( ef_lang_url( $alt, $rel ) ) . '"/>' . "\n";
			}
			echo "\t\t" . '<xhtml:link rel="alternate" hreflang="x-default" href="' . esc_url( ef_lang_url( 'pl', $rel ) ) . '"/>' . "\n";
			echo "\t</url>\n";
		}
	}

	// 4) Porady blog — plain entries, no <xhtml:link> alternates: Polish-only
	//    content (see inc/blog.php), so there is nothing to cross-link. Dynamic —
	//    reflects whatever is actually published, no separate maintenance needed
	//    as posts go live. Category archives are intentionally NOT listed here
	//    (thin/duplicate listing content — see the noindex guard in inc/blog.php).
	echo "\t<url>\n\t\t<loc>" . esc_url( home_url( '/porady/' ) ) . "</loc>\n";
	$blog_index_lastmod = get_lastpostmodified( 'gmt', 'post' );
	if ( $blog_index_lastmod ) {
		echo "\t\t<lastmod>" . esc_html( mysql2date( 'c', $blog_index_lastmod, false ) ) . "</lastmod>\n";
	}
	echo "\t</url>\n";

	$blog_posts = get_posts( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );
	foreach ( $blog_posts as $bp ) {
		echo "\t<url>\n\t\t<loc>" . esc_url( get_permalink( $bp ) ) . "</loc>\n";
		echo "\t\t<lastmod>" . esc_html( get_the_modified_date( 'c', $bp ) ) . "</lastmod>\n";
		echo "\t</url>\n";
	}

	echo "</urlset>\n";
	exit;
}, 0 );
