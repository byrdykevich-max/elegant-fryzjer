<?php
/**
 * Complete multilingual XML sitemap for Elegant Fryzjer.
 *
 * Lists all 15 per-language URLs (5 pages × pl/en/uk) with hreflang alternates
 * (incl. x-default → Polish). The WordPress-core sitemap (wp-sitemap.xml) is disabled
 * because it can only list real WP objects — it would miss the rewrite-virtual /en/ and
 * /uk/ URLs and carries no hreflang. Served at /sitemap.xml (advertised in robots.txt).
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
	echo "</urlset>\n";
	exit;
}, 0 );
