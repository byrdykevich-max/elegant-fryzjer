<?php
/**
 * Gallery image set — real photos from Julia's own work (Instagram @juli_fryzjer plus
 * a 2026-07-06 client-photo batch from the salon), selected from the full Media Library.
 * Identifiable-face photos are cleared for use (owner-confirmed 2026-06-22).
 *
 * Order = display priority. Client mix is ~80% men, so men's / barber work leads and
 * dominates (drives the hero, OG image, JSON-LD image and the gallery-page order);
 * women's colour work, then children's cuts, follow. Current ratio = 25 men / 5 women /
 * 3 children (first children's photos — 2026-07-08).
 *
 * Each entry: 'base' = filename stem (sizes/webp are derived), 'month' = the uploads
 * subfolder the file lives in (defaults to 2026/06 if omitted — the original Instagram
 * batch; the 2026-07-06 batch lives in 2026/07), 'alt' = descriptive Polish alt text
 * (accessibility + SEO; translated per language via gettext).
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function ef_gallery_images() {
	return array(
		// --- Men's / barber work (leads; ~80%) ---
		array( 'base' => 'juli_fryzjer_1686590133_3123666898524198197_14892312004', 'alt' => __( 'Męskie strzyżenie i stylizacja — wnętrze salonu Elegant Fryzjer na Białołęce', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656320_3124222114852137259_14892312004', 'alt' => __( 'Męskie strzyżenie: teksturowana góra z przejściem (fade) i krótka broda — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686618782_3123907224593473058_14892312004', 'alt' => __( 'Klasyczny pompadour z uniesioną górą — ujęcie trzy czwarte z przodu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656039_3124219754012654141_14892312004', 'alt' => __( 'Krótkie strzyżenie na jeża ze skórnym przejściem (skin fade) — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656383_3124222641488867340_14892312004', 'alt' => __( 'Młodzieżowe strzyżenie typu crop z grzywką i niskim przejściem — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686655755_3124217379323558063_14892312004', 'alt' => __( 'Krótkie teksturowane strzyżenie męskie ze średnim przejściem — z boku', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1611572070_2494369772245657089_14892312004', 'alt' => __( 'Krótkie męskie strzyżenie z przejściem i lekkim zarostem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'IMG_20230612_192448_737', 'month' => '2026/07', 'alt' => __( 'Zaczesany do tyłu wierzch z przejściem i pełną brodą — profil, wnętrze zakładu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656320_3124222114994679573_14892312004', 'alt' => __( 'Męskie strzyżenie z uniesioną górą i cieniowanym tyłem — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686590133_3123666898549415366_14892312004', 'alt' => __( 'Męskie strzyżenie typu crop z teksturą — od przodu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656039_3124219754062982891_14892312004', 'alt' => __( 'Bardzo krótkie strzyżenie na jeża ze skórnym przejściem — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'juli_fryzjer_1686656383_3124222641489007519_14892312004', 'alt' => __( 'Młodzieżowe strzyżenie typu crop z teksturą — widok z tyłu', 'elegant-fryzjer' ) ),
		// --- Men's / barber work, 2026-07-06 batch ---
		array( 'base' => 'photo_249@06-07-2026_06-33-54', 'month' => '2026/07', 'alt' => __( 'Krótkie męskie strzyżenie z przejściem — profil, wnętrze zakładu', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_250@06-07-2026_06-34-09', 'month' => '2026/07', 'alt' => __( 'Krótkie męskie strzyżenie z wysokim przejściem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_257@06-07-2026_06-41-07', 'month' => '2026/07', 'alt' => __( 'Męskie strzyżenie z zarostem w klimacie barbershopu — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_258@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Teksturowany, zaczesany do tyłu wierzch z przejściem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_259@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Zaczesane do tyłu włosy z przejściem — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_260@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Krótkie strzyżenie z przejściem i zarostem — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_261@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Bardzo krótkie strzyżenie na jeża — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_262@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Krótkie strzyżenie z wyraźnym przejściem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_263@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Krótkie, jasne strzyżenie z przejściem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_264@06-07-2026_06-45-00', 'month' => '2026/07', 'alt' => __( 'Jasne, krótkie strzyżenie z przejściem — profil, wnętrze barbershopu', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_266@06-07-2026_06-46-04', 'month' => '2026/07', 'alt' => __( 'Teksturowany wierzch z przejściem — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_276@06-07-2026_07-49-43', 'month' => '2026/07', 'alt' => __( 'Krótkie strzyżenie z wyraźnym przejściem — profil, wnętrze barbershopu', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_277@06-07-2026_08-03-03', 'month' => '2026/07', 'alt' => __( 'Detal strzyżenia męskiego — przedziałek i przejście z góry', 'elegant-fryzjer' ) ),
		// --- Women's (secondary) ---
		array( 'base' => 'juli_fryzjer_1611572919_2494376897160184876_14892312004', 'alt' => __( 'Strzyżenie bob z wycieniowanym tyłem głowy', 'elegant-fryzjer' ) ),
		// --- Women's colour work, 2026-07-06 batch (portfolio pieces, not on the current price list) ---
		array( 'base' => 'photo_254@06-07-2026_06-36-11', 'month' => '2026/07', 'alt' => __( 'Koloryzacja: blond z delikatnymi refleksami — widok z tyłu', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_256@06-07-2026_06-38-12', 'month' => '2026/07', 'alt' => __( 'Koloryzacja: platynowy blond, krótkie cięcie pixie — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_267@06-07-2026_06-46-21', 'month' => '2026/07', 'alt' => __( 'Koloryzacja balayage w odcieniach brązu i blondu — profil', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_268@06-07-2026_06-46-44', 'month' => '2026/07', 'alt' => __( 'Koloryzacja: platynowy blond, undercut — profil', 'elegant-fryzjer' ) ),
		// --- Children's, 2026-07-06 batch (first children's photos) ---
		array( 'base' => 'photo_265@06-07-2026_06-45-37', 'month' => '2026/07', 'alt' => __( 'Chłopięce strzyżenie z teksturą i przejściem', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_273@06-07-2026_07-47-43', 'month' => '2026/07', 'alt' => __( 'Dziewczęce strzyżenie bob — portret', 'elegant-fryzjer' ) ),
		array( 'base' => 'photo_274@06-07-2026_07-47-43', 'month' => '2026/07', 'alt' => __( 'Dziewczęce strzyżenie bob — widok z tyłu', 'elegant-fryzjer' ) ),
	);
}

/** Upload dir URL + path helpers. $month is the uploads subfolder (default = original 2026/06 batch). */
function ef_uploads_url( $month = '2026/06' ) {
	$u = wp_upload_dir();
	return trailingslashit( $u['baseurl'] ) . $month;
}
function ef_uploads_path( $month = '2026/06' ) {
	$u = wp_upload_dir();
	return trailingslashit( $u['basedir'] ) . $month;
}
