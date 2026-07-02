<?php
/**
 * Generic page template (used for any Page without a specific page-{slug}.php).
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
while ( have_posts() ) : the_post(); ?>
<section aria-labelledby="page-title">
	<div class="container" style="max-width:760px">
		<h1 id="page-title"><?php the_title(); ?></h1>
		<div class="entry-content"><?php the_content(); ?></div>
	</div>
</section>
<?php endwhile; get_footer(); ?>
