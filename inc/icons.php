<?php
/**
 * Inline SVG pictograms — audience icons (him/her/kids/care) for the cennik page,
 * and small icons for the "why us" info row. Simple geometric line-art, no photos,
 * no external assets. Decorative (aria-hidden) — always paired with a visible text
 * heading, so no separate label is needed.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function ef_pictogram( $key ) {
	$paths = array(
		'him'  => '<circle cx="20" cy="13" r="6"/><path d="M14.5 10c1.5-2 3-3 5.5-3s4 1 5.5 3"/><path d="M9 34c0-6.5 5-11.5 11-11.5S31 27.5 31 34"/>',
		'her'  => '<circle cx="20" cy="13" r="6"/><path d="M13.5 15c-.5 5 .5 10 1.5 15M26.5 15c.5 5-.5 10-1.5 15"/><path d="M9 34c0-6.5 5-11.5 11-11.5S31 27.5 31 34"/>',
		'kids' => '<circle cx="20" cy="15" r="5"/><path d="M20 10c1-1.5 2.5-2 3.5-1" stroke-linecap="round"/><path d="M11 34c0-5.5 4-9.5 9-9.5s9 4 9 9.5"/>',
		'care' => '<path d="M20 6c4 5 7 9.5 7 14a7 7 0 1 1-14 0c0-4.5 3-9 7-14z"/><path d="M13 31h14M15 35h10" stroke-linecap="round"/>',
	);
	if ( ! isset( $paths[ $key ] ) ) { return ''; }
	return '<svg class="pictogram" viewBox="0 0 40 40" width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $key ] . '</svg>';
}

function ef_info_icon( $key ) {
	$paths = array(
		'booking'    => '<rect x="6" y="8" width="28" height="24" rx="3"/><path d="M6 16h28M13 5v6M27 5v6"/><path d="M14 23l3.5 3.5L27 17" stroke-linejoin="round"/>',
		'punctual'   => '<circle cx="20" cy="20" r="14"/><path d="M20 12v8l6 4" stroke-linejoin="round"/>',
		'comfort'    => '<path d="M20 32s-11-6.8-11-15A6.5 6.5 0 0 1 20 12a6.5 6.5 0 0 1 11 5c0 8.2-11 15-11 15z" stroke-linejoin="round"/>',
		'experience' => '<path d="M20 6l3.5 7.5L31 15l-5.6 5.6L26.8 29 20 25l-6.8 4 1.4-8.4L9 15l7.5-1.5z" stroke-linejoin="round"/>',
	);
	if ( ! isset( $paths[ $key ] ) ) { return ''; }
	return '<svg class="info-icon" viewBox="0 0 40 40" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[ $key ] . '</svg>';
}

/**
 * Service-card pictogram (client-supplied raster PNG) — replaces ef_pictogram()
 * for the 6 homepage/uslugi service cards. Wrapped in the shared dark .icon-badge
 * chip (--sm variant): 3 of the 6 source PNGs are gold-toned and unreadable on
 * light backgrounds, and the /uslugi/ women's/kids/care block is pinned light
 * regardless of the site-wide theme toggle, so a fixed-dark chip is required
 * rather than relying on the toggle. ef_pictogram()/inc/icons.php's old SVG
 * paths are left in place for rollback — see ef_services() in inc/config.php.
 */
function ef_service_icon( $key ) {
	$map = array(
		'man'      => array( 'man.png', 28, 30 ),
		'woman'    => array( 'woman.png', 25, 30 ),
		'children' => array( 'children.png', 24, 30 ),
		'bottle'   => array( 'bottle.png', 14, 30 ),
		'scissors' => array( 'scissors.png', 26, 30 ),
		'chair'    => array( 'chair.png', 26, 30 ),
	);
	if ( ! isset( $map[ $key ] ) ) { return ''; }
	list( $file, $w, $h ) = $map[ $key ];
	ob_start();
	?>
	<span class="icon-badge icon-badge--sm"><?php ef_pictogram_img( $file, $w, $h ); ?></span>
	<?php
	return ob_get_clean();
}
