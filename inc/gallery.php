<?php
/**
 * Gallery image set — real photos from Julia's own work (Instagram @juli_fryzjer),
 * selected from the full Media Library. Identifiable-face photos are cleared for use
 * (owner-confirmed 2026-06-22).
 *
 * Order = display priority. Client mix is ~80% men, so men's / barber work leads and
 * dominates (drives the hero, OG image, JSON-LD image and the gallery-page order);
 * women's colour work follows. Current ratio = 16 men / 5 women / 0 children.
 * No children's photos exist yet — add a children slot when supplied.
 *
 * Each entry: 'base' = filename stem in /wp-content/uploads/2026/06/ (sizes/webp are
 * derived), 'alt' = descriptive Polish alt text (accessibility + SEO; translated per
 * language via gettext).
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function ef_gallery_images() {
	return array(
		// --- Men's / barber work (leads; ~80%) ---
		array( 'base' => 'juli_fryzjer_1686590133_3123666898524198197_14892312004', 'alt' => __( 'Męskie strzyżenie i stylizacja — wnętrze salonu Elegant Fryzjer na Białołęce', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686591070_3123674754942350202_14892312004', 'alt' => __( 'Męskie strzyżenie z włosami zaczesanymi do tyłu i pełnym zarostem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656320_3124222114852137259_14892312004', 'alt' => __( 'Męskie strzyżenie: teksturowana góra z przejściem (fade) i krótka broda — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686618782_3123907224593473058_14892312004', 'alt' => __( 'Klasyczny pompadour z uniesioną górą — ujęcie trzy czwarte z przodu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1611571398_2494364135151371432_14892312004', 'alt' => __( 'Rozłączony undercut z włosami zaczesanymi do tyłu i wysokim przejściem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656039_3124219754012654141_14892312004', 'alt' => __( 'Krótkie strzyżenie na jeża ze skórnym przejściem (skin fade) — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656383_3124222641488867340_14892312004', 'alt' => __( 'Młodzieżowe strzyżenie typu crop z grzywką i niskim przejściem — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686655755_3124217379323558063_14892312004', 'alt' => __( 'Krótkie teksturowane strzyżenie męskie ze średnim przejściem — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686591138_3123675328781974063_14892312004', 'alt' => __( 'Męskie strzyżenie z krótkim, teksturowanym wierzchem i przyciętą brodą — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1611572070_2494369772245657089_14892312004', 'alt' => __( 'Krótkie męskie strzyżenie z przejściem i lekkim zarostem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686655883_3124218450817146031_14892312004', 'alt' => __( 'Krótkie męskie strzyżenie z przejściem i pełną brodą — od przodu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656320_3124222114994679573_14892312004', 'alt' => __( 'Męskie strzyżenie z uniesioną górą i cieniowanym tyłem — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686590133_3123666898549415366_14892312004', 'alt' => __( 'Męskie strzyżenie typu crop z teksturą — od przodu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686591138_3123675328546985208_14892312004', 'alt' => __( 'Krótkie męskie strzyżenie z pełną, wymodelowaną brodą — od przodu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656039_3124219754062982891_14892312004', 'alt' => __( 'Bardzo krótkie strzyżenie na jeża ze skórnym przejściem — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656383_3124222641489007519_14892312004', 'alt' => __( 'Młodzieżowe strzyżenie typu crop z teksturą — widok z tyłu', 'elegant-fryzjer' ) ),
		// --- Women's colour work (secondary; ~20%) ---
		// All tiles render as uniform 1:1 squares (object-fit: cover; sources are square so
		// nothing is cropped). The balayage collage has white baked into its file, so it
		// carries 'zoom' => a small CSS center-zoom that pushes the white out of the square
		// (back-of-head shot — no face clipped). See .gallery__item--zoom in style.css.
		// The brown→blonde collage already fills its square, so it needs no zoom.
		array( 'base' => 'juli_fryzjer_1611571933_2494368629826447091_14892312004', 'zoom' => true, 'alt' => __( 'Metamorfoza: koloryzacja balayage i modelowanie miękkich fal — efekt przed i po', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1611572298_2494371691181785523_14892312004', 'alt' => __( 'Metamorfoza koloru: z ciemnego brązu na rozjaśniony blond z falami — przed i po', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1611571802_2494367527345080737_14892312004', 'alt' => __( 'Kreatywna koloryzacja w odcieniach zieleni i żółci — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1611572919_2494376897160184876_14892312004', 'alt' => __( 'Strzyżenie bob z wycieniowanym tyłem głowy', 'elegant-fryzjer' ) ),
		// --- Women's colour metamorphosis (before/after; back-of-head, no face) ---
		array( 'base' => 'juli_fryzjer_1611572524_2494373581420409837_14892312004', 'alt' => __( 'Metamorfoza koloru: rozjaśnienie z ciemnego blondu na platynowy blond — efekt przed i po, widok z tyłu', 'elegant-fryzjer' ) ),
	);
}

/** Upload dir URL + path helpers (images live in the 2026/06 uploads folder). */
function ef_uploads_url() {
	$u = wp_upload_dir();
	return trailingslashit( $u['baseurl'] ) . '2026/06';
}
function ef_uploads_path() {
	$u = wp_upload_dir();
	return trailingslashit( $u['basedir'] ) . '2026/06';
}
