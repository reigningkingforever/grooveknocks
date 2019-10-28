<?php
/**
 * The template for displaying archive pages.
 *
 * @since 1.0.0
 */
get_header();
global $wp_query;

$title = get_the_archive_title();
$description = get_the_archive_description();

if ( is_search() ) {
	$title = sprintf( __( 'Search Results for: <em>%s</em>', 'my-listing' ), get_search_query() );
}
?>

<div class="archive-page">
	<section class="i-section archive-heading <?php echo ! $description ? 'no-description' : '' ?>">
		<div class="container">
			<div class="row section-title reveal">
				<h1 class="case27-primary-text"><?php echo $title ?></h1>
			</div>

			<?php if ( $description ): ?>
				<div class="row section-body reveal archive-description text-center">
					<div class="col-md-12">
						<?php echo $description ?>
					</div>
				</div>
			<?php endif ?>
		</div>
	</section>

	<section class="i-section archive-posts">
		<div class="container">

		<?php if ( have_posts() ): ?>

				<div class="row section-body grid">
					<?php while ( have_posts() ): the_post();
						if ( get_post_type() == 'job_listing' ) {
	    					if ( class_exists( 'WP_Job_Manager' ) ) {
	    						global $post;
	    						$post->c27_options__wrap_in = 'col-md-4 col-sm-6 col-xs-12 reveal';
	    						get_job_manager_template_part( 'content', 'job_listing' );
	    					}
						} else {
							c27()->get_partial('post-preview', [
								'wrap_in' => 'col-md-4 col-sm-6 col-xs-12 ' . ( is_sticky() ? ' sticky ' : '' ),
							]);
						} ?>
					<?php endwhile ?>
				</div>

				<div class="blog-footer">
					<div class="row project-changer">
						<div class="text-center">
							<?php echo paginate_links([
								'total'   => $wp_query->max_num_pages,
								'format'  => '?paged=%#%',
								'current' => 0,
								'current' => get_query_var('paged') ?: 1,
								]) ?>
						</div>
					</div>
				</div>

			<?php else: ?>

				<div class="row text-center">
					<div>
						<i class="no-results-icon material-icons">mood_bad</i>
						<p><?php _e( 'No results. Try another search?', 'my-listing' ) ?></p>
						<?php echo get_search_form() ?>
					</div>
				</div>

			<?php endif ?>

		</div>
	</section>
</div>

<?php get_footer();
