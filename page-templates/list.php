<?php
/*
Template Name: List
Template Post Type: page
*/

get_header(); ?>
<div class="barba-wrapper" data-barba="wrapper">
  <!-- Begin Cursor -->
  <div class="cursor"></div>
  <div class="cursor-follower"></div>
  <!-- End Cursor -->
  <div data-barba="container" data-barba-namespace="list">
    <div class="page-list">
      <!-- Begin Header -->
      <header class="header" id="list_header">
        <a href="<?php echo esc_url(home_url( '/' )); ?>" class="map-link page-link">
          <span class="map-link__icon">
            <img src="<?php echo get_template_directory_uri() . '/assets/images/icon_map_view.svg'; ?>" alt="" />
          </span>
          <span class="map-link__text">MAP View</span>
        </a>
      </header>
      <!-- End Header -->
      <scroll class="change-cursor" data-color="white">
        <!-- Begin Content -->
        <main>
          <div class="table list-table">
            <div class="thead">
              <div class="th">Story Title</div>
              <div class="th">Benefits</div>
              <div class="th">Partners</div>
            </div>
            <div class="tbody">
              <?php
              $args = array(
                'post_type' => 'stories',
                'post_status' => 'publish',
                'order' => 'ASC',
                'post_per_page' => -1
              );
              $query = new WP_Query($args);
              if ($query->have_posts()) :
                while ($query->have_posts()) : $query->the_post();
                  $postID = get_the_ID(); 
                  $story_image = get_field('story_hexagon_image');
                  $story_title = get_field('story_title');
                  $under_construction = get_field('under_construction');
                  if (!$under_construction):
                  ?>
                  <div class="tr">
                    <?php if ($story_image): ?>
                      <a class="page-link avatar-link" href="<?php echo get_the_permalink(); ?>">
                        <img src="<?php echo $story_image['url']; ?>" alt="" />
                      </a>
                    <?php endif; ?>
                    <div class="td">
                      <?php if ($story_title): ?>
                        <a href="<?php echo get_the_permalink(); ?>" class="page-link">
                          <p class="title"><?php echo $story_title; ?></p>
                        </a>
                      <?php endif; ?>
                    </div>
                    <div class="td td-flex td-benefits">
                      <p class="td-title">Benefits</p>
                      <?php if ($benefits = get_field('benefits_list')): ?>
                      <div class="benefits"><?php echo $benefits; ?></div>
                      <?php endif; ?>
                    </div>
                    <div class="td td-flex">
                      <p class="td-title">Partners</p>
                      <div>
                        <?php 
                        if (have_rows('partners')) :
                          while (have_rows('partners')): the_row(); 
                            if (have_rows('links')): 
                              while (have_rows('links')) : the_row(); 
                                $link = get_sub_field('link'); ?>
                                <a href="<?php echo $link['url']; ?>" class="partners-link" target="_blank"><?php echo $link['title']; ?></a>
                        <?php endwhile;
                            endif;
                          endwhile;
                        endif; ?>
                      <div>
                    </div>
                      </div>
                      </div>
                  </div>
                <?php endif;
                endwhile;
              endif; ?>
            </div>
            <div class="tfooter">
              <?php if (have_rows('partners', 'options')) : ?>
              <div class="partners">
                <?php while (have_rows('partners', 'options')) : the_row(); 
                  $link = get_sub_field('link');
                  $image = get_sub_field('image') ?>
                  <a href="<?php echo $link; ?>" class="partners-link">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>">
                  </a>
                <?php endwhile; ?>
              </div>
              <?php endif; ?>
              <div class="footer-bar">
                <?php 
                $copyright = get_field('copyright', 'options');
                $privacy_policy = get_field('privacy_policy', 'options');
                $credits = get_field('credits', 'options');
                if ($copyright): ?>
                  <p><?php echo $copyright; ?> <?php echo date('Y'); ?></p>
                <?php endif;
                if ($privacy_policy) : ?>
                  <a href="<?php echo $privacy_policy['url']; ?>" class="page-link"><?php echo $privacy_policy['title']; ?></a>  
                <?php endif; 
                if ($credits) : ?>
                  <p><?php echo $credits; ?></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </main>
        <!-- End Content -->
      </scroll>
    </div>
  </div>
</div>
<?php get_footer(); ?>