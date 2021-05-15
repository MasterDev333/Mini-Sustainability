<?php get_header(); ?>
<?php 
$bg = get_field('404_background', 'options');
if ($bg): ?>
<style>
    .error404 {
        background-image: url(<?php echo $bg['url']; ?>);
    }
</style>
<?php endif; ?>

<!-- Begin Cursor -->
<div class="cursor"></div>
<div class="cursor-follower"></div>
<!-- End Cursor -->

<!-- Begin Content -->
<main>
    <div class="page-content change-cursor" data-color="primary">
    <div class="page-content__inner">
        <h2 class="text-primary"><strong>404</strong>page not found</h2>
        <p>
        The link you are looking for is unavailable. Click the button below
        to go back and explore the map.
        </p>
        <a href="<?php echo esc_url(home_url( '/' )); ?>" class="page-link">
        <span class="map-icon">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon_map_view.svg" alt="" />
        </span>
        Return to map
        </a>
    </div>
    </div>
</main>
<!-- End Content -->
<?php get_footer(); ?>