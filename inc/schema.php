<?php
/**
 * LocalBusiness / HairSalon JSON-LD structured data.
 * Output once in <head> on the front page (canonical business entity).
 * Pulls every value from ef_config() so it never drifts from the visible NAP.
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function ef_schema_jsonld() {
	$c   = ef_config();
	$url = home_url( '/' );

	// Build openingHoursSpecification from the hours map.
	$day_map = array(
		'Mo' => 'Monday', 'Tu' => 'Tuesday', 'We' => 'Wednesday', 'Th' => 'Thursday',
		'Fr' => 'Friday', 'Sa' => 'Saturday', 'Su' => 'Sunday',
	);
	$hours = array();
	foreach ( $c['hours'] as $d => $range ) {
		if ( ! $range ) { continue; } // closed day -> omit
		$hours[] = array(
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => $day_map[ $d ],
			'opens'     => $range[0],
			'closes'    => $range[1],
		);
	}

	// Offer catalog from the service list (names only; prices are placeholders).
	$offers = array();
	foreach ( ef_services() as $svc ) {
		$offers[] = array(
			'@type'       => 'OfferCatalog',
			'name'        => $svc['title'],
			'itemListElement' => array_map( function ( $i ) {
				return array(
					'@type' => 'Offer',
					'itemOffered' => array( '@type' => 'Service', 'name' => $i['name'] ),
				);
			}, $svc['items'] ),
		);
	}

	$same_as = array_values( array_filter( array( $c['instagram'], $c['facebook'] ) ) );

	$data = array(
		'@context'  => 'https://schema.org',
		'@type'     => 'HairSalon',
		'@id'       => $url . '#business',
		'name'      => $c['name'],
		'description' => __( 'Salon fryzjerski i barber w Warszawie na Białołęce — strzyżenie damskie, męskie i dziecięce, barber i stylizacja brody. Prowadzi Julia.', 'elegant-fryzjer' ),
		'url'       => $url,
		'image'     => ef_uploads_url( ef_gallery_images()[0]['month'] ?? '2026/06' ) . '/' . ef_gallery_images()[0]['base'] . '-1024x1024.jpg',
		'priceRange' => '$$',
		'currenciesAccepted' => 'PLN',
		'address'   => array(
			'@type'           => 'PostalAddress',
			'streetAddress'   => $c['street'],
			'addressLocality' => $c['city'],
			'addressRegion'   => $c['region'],
			'postalCode'      => $c['postal'],   // [PLACEHOLDER] until confirmed
			'addressCountry'  => $c['country'],
		),
		'geo'       => array(
			'@type'     => 'GeoCoordinates',
			'latitude'  => $c['geo_lat'],         // [PLACEHOLDER] approximate
			'longitude' => $c['geo_lng'],
		),
		'areaServed' => array( 'Białołęka', 'Tarchomin', 'Nowodwory', 'Warszawa' ),
		'openingHoursSpecification' => $hours,
		'hasOfferCatalog' => array(
			'@type' => 'OfferCatalog',
			'name'  => __( 'Usługi fryzjerskie i barberskie', 'elegant-fryzjer' ),
			'itemListElement' => $offers,
		),
	);
	if ( $same_as )            { $data['sameAs']    = $same_as; }
	if ( ! empty( $c['phone_tel'] ) ) { $data['telephone'] = $c['phone_tel']; }
	if ( ! empty( $c['email'] ) )     { $data['email']     = $c['email']; }

	echo "\n<script type=\"application/ld+json\">\n"
		. wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT )
		. "\n</script>\n";
}
add_action( 'wp_head', 'ef_schema_jsonld', 20 );
