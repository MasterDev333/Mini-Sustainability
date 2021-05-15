<?php /*
Template Name: Privacy Policy
Template Post Type: page
*/
get_header();
?>
<div class="barba-wrapper" data-barba="wrapper">
  
  <!-- Begin Cursor -->
  <div class="cursor"></div>
  <div class="cursor-follower"></div>
  <!-- End Cursor -->
  
  <div data-barba="container" data-barba-namespace="privacy">
    <div class="page-privacy-policy">
      <!-- Begin Header -->
      <header class="header" id="privacy_header">
        <a href="<?php echo esc_url(home_url('/list/')) ?>" class="header-link page-link">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/list_view.svg" alt="" />
          <span>List View</span>
        </a>
        <a href="<?php echo esc_url(home_url( '/' )); ?>" class="header-link page-link">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/map_view.svg" alt="" />
          <span>MAP View</span>
        </a>
      </header>
      <!-- End Header -->
      <!-- Begin Content -->
      <main>
        <?php if (have_rows('privacy_block')): ?>
        <div class="sidebar">
          <ul>
            <?php while(have_rows('privacy_block')): the_row(); 
            $title = get_sub_field('title'); 
            if ($title): ?> 
            <li><a class="sidebar-link" href="#block_<?php echo get_row_index(); ?>"><?php echo $title; ?></a></li>
            <?php endif;
            endwhile; ?>
          </ul>
        </div>
        <?php endif; ?>
        <scroll>
          <div class="content">
            <h2 class="content-title"><?php echo get_the_title(); ?></h2>
            
            <?php if (have_rows('privacy_block')): 
              while(have_rows('privacy_block')): the_row();
              $title = get_sub_field('title');
              $content = get_sub_field('content');
              ?>
            <div class="privacy-block" id="block_<?php echo get_row_index(); ?>">
              <?php if ($title): ?>
                <h4 class="privacy-block__title"><?php echo $title; ?></h4>
              <?php endif; ?>
              <?php if ($content): ?>
                <div class="privacy-block__content">
                  <?php echo $content; ?>
                </div>
              <?php endif; ?>
            </div>
            <?php endwhile;
            endif; ?>

            <?php if (have_rows('privacy_table')): 
            while(have_rows('privacy_table')): the_row(); ?>
              <div>
                <?php 
                $headerItems = [];
                if (have_rows('header')) : 
                  while (have_rows('header')): the_row(); 
                    array_push($headerItems, get_sub_field('title')); 
                  endwhile;
                endif; ?>
                <?php if (have_rows('body')) :
                while(have_rows('body')): the_row(); ?>
                  <div class="privacy-items">
                    <?php if (have_rows('row')):
                    while (have_rows('row')): the_row(); 
                    $i = get_row_index() - 1; ?>
                      <div class="privacy-item">
                        <?php if ($headerItems[$i]): ?>
                          <p class="privacy-item__title"><?php echo $headerItems[$i]; ?></p>
                        <?php endif; ?>
                        <?php if (get_sub_field('content')): ?>
                          <div class="privacy-item__content">
                            <?php echo get_sub_field('content'); ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    <?php endwhile;
                    endif; ?>
                  </div>
                <?php endwhile;
                endif; ?>
              </div>
            <?php endwhile;
            endif; ?>

          </div>
        </scroll>
      </main>
      <!-- End Content -->
    </div>
  </div>
</div>
<?php get_footer(); ?>