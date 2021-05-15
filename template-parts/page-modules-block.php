<?php 
global $post;
$section_type = get_sub_field('section_type');
$hexagon_image = get_sub_field('hexagon_image');
$section_image = get_sub_field('section_image');
switch($section_type) {
  case 0: 
    $class = 'flexible-section';
    break;
  case 1:
    $class = 'solution-section';
    break;
  case 2:
    $class = 'flexible-section footer-section';
    break;
}
?>
<section <?php echo ($args['row_index'] == 1) ? 'id="next-section"' : ''; ?> 
        class="section section-<?php echo $args['row_index']; ?> <?php echo $class ?>" 
        <?php echo ($section_image) ? ('style="background-image: url(' . $section_image['url'] . ')"') : ''; ?>>
  <?php if($hexagon_image): ?>
    <div class="hexagon-image">
      <img src="<?php echo $hexagon_image['url']; ?>" alt="<?php echo $hexagon_image['title']; ?>" />
    </div>
  <?php endif; ?>
  <?php if ($module_hexagon_image = get_sub_field('module_hexagon_image')) : ?>
  <style>
    .section-<?php echo $args['row_index']; ?> .has-hexagon::before {
      background-image: url(<?php echo $module_hexagon_image; ?>);
    }
  </style>
  <?php endif; ?>
  <?php if ($args['row_index'] == 1) : 
    if (have_rows('partners')): ?>
    <div class="module project-partners-module has-hexagon">
      <?php while(have_rows('partners')): the_row(); ?>
        <?php if (get_sub_field('title')): ?>
          <h4><?php echo get_sub_field('title'); ?></h4>
        <?php endif; ?>
        <?php if (have_rows('links')): 
          while (have_rows('links')): the_row(); 
            $link = get_sub_field('link'); ?>
            <a href="<?php echo $link['url']; ?>" target="_blank" class="link-external partners-link"
              ><?php echo $link['title']; ?></a
            >
          <?php endwhile;
        endif; ?>
      <?php endwhile; ?>
    </div>
  <?php endif; 
  endif; ?>
  <?php if (have_rows('modules')):
  while (have_rows('modules')) : the_row(); ?>
    <?php 
    // Text Module
    if (get_row_layout() == 'text_module'): ?>
      <?php $title = get_sub_field('title');
      $body = get_sub_field('body'); ?>
      <div class="module text-module has-hexagon">
        <?php if ($title): ?>
          <h4><?php echo $title; ?></h4>
        <?php endif;
        if ($body) : ?>
        <div class="text-module__body"><?php echo wpautop($body); ?></div>
        <?php endif; ?>
      </div>

    <?php
    // Imagery Text Module
    elseif (get_row_layout() == 'imagery_text_module') : 
      $title = get_sub_field('title'); 
      $contents = get_sub_field('contents'); ?>
      <div class="module imagery-text-module has-hexagon">
        <?php if ($title): ?>
          <h4><?php echo $title; ?></h4>
        <?php endif; ?>
        <?php if ($contents) : ?>
        <div class="imagery-text-module__contents">
          <?php echo wpautop($contents); ?>
        </div>
        <?php endif; ?>
        <?php if (have_rows('side_images')): 
        while (have_rows('side_images')) : the_row();
          $image = get_sub_field('image');
          $x_position = get_sub_field('x_position');
          $y_position = get_sub_field('y_position'); ?>
        <div class="imagery-text-module__image position-<?php echo $x_position; ?> position-<?php echo $y_position; ?>">
          <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" />
        </div>
        <?php endwhile;
        endif; ?>
      </div>

    <?php
    // Location Module
    elseif (get_row_layout() == 'location_module') : 
      $sub_title = get_sub_field('sub_title');
      $title = get_sub_field('title'); ?>
      <div class="module location-module has-hexagon">
        <?php if ($sub_title): ?>
          <h4><?php echo $sub_title; ?></h4>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2><?php echo $title; ?></h2>
        <?php endif; ?>
      </div>

    <?php
    // Call Actions Module
    elseif (get_row_layout() == 'call_actions_module') :
      $sub_title = get_sub_field('sub_title');
      $title = get_sub_field('title'); ?>
      <div class="module call-actions-module">
        <?php if ($sub_title): ?>
          <h4><?php echo $sub_title; ?></h4>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if (have_rows('links')): 
        while (have_rows('links')) : the_row(); 
        $link = get_sub_field('link'); ?>
          <a target="_blank" href="<?php echo $link['url']; ?>" class="btn btn-external">
            <?php echo $link['title']; ?>
            <svg
              width="11"
              height="10"
              viewBox="0 0 11 10"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M8.32845 1L5.53556 1L5.53556 0H9.53556H10.0356V0.5V4.5H9.03556L9.03556 1.70711L4.70711 6.03556L4 5.32845L8.32845 1Z"
                fill="#1D1D1D"
              />
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M1 9L1 0H0V9V10H1H10V9H1Z"
                fill="#1D1D1D"
              />
            </svg>
          </a>
          <?php endwhile;
        endif; ?>
      </div>
    
    <?php 
    // Contacts Module
    elseif (get_row_layout() == 'contacts_module') :
      $title = get_sub_field('title'); ?>
      <div class="module contacts-module has-hexagon">
        <?php if ($title): ?>
          <h4><?php echo $title; ?></h4>
        <?php endif; ?>
        <?php if (have_rows('contact')) :
        while (have_rows('contact')) : the_row(); 
          $name = get_sub_field('name');
          $job_title = get_sub_field('job_title'); 
          $company_name = get_sub_field('company_name'); 
          $email = get_sub_field('email'); ?>
          <div class="contact">
            <?php if ($name) : ?>
              <h5 class="contact-name"><?php echo $name; ?></h5>
            <?php endif; 
            if ($job_title): ?>
              <p class="contact-job-title"><?php echo $job_title; ?></p>
            <?php endif;
            if ($company_name) : ?>
              <p class="contact-company-name"><?php echo $company_name; ?></p>
            <?php endif; 
            if ($email): ?>
            <a href="mailto:<?php echo $email; ?>" class="contact-mail">
              <img src="<?php echo get_template_directory_uri() . '/assets/images/icon_email.svg'; ?>" alt="" />
            </a>
            <?php endif; ?>
          </div>
          <?php endwhile;
        endif; ?>
      </div>
    
    <?php 
    // Images Module
    elseif (get_row_layout() == 'images_module') : 
      $enable_carousel = get_sub_field('enable_carousel');
      ?>
      <div class="module image-captions-module no-border <?php echo ($enable_carousel) ? 'image-carousel' : ''; ?>">
        <?php if (have_rows('images')):
        while (have_rows('images')): the_row(); 
          $image = get_sub_field('image');
          $caption = get_sub_field('caption'); ?>
          <div class="image-wrapper">
            <div class="image">
              <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
              <?php if ($caption): ?>
                <div class="image-caption"><?php echo $caption; ?></div>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile;
        endif; ?>
      </div>

    <?php
    // Video Module
    elseif (get_row_layout() == 'video_module') :
      $video = get_sub_field('video');
      if ($video) : ?>
        <div class="module video-module no-border">
          <div class="embed-container">
            <?php echo $video; ?>
          </div>
        </div>
      <?php endif; ?>
      
    <?php
    // Download Module 
    elseif (get_row_layout() == 'download_module') :
      $file = get_sub_field('download_file'); ?>
      <div class="module share-module">
        <p class="text-primary">Share story</p>
				<?php echo do_shortcode('[addtoany]'); ?>
      </div>
      <?php if ($file) :  ?>
      <div class="module download-module no-border">
        <div class="download">
          <svg class="download-bg" width="152" height="176" viewBox="0 0 152 176" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M75.9999 175.422L0.5 131.712V44.2883L75.9999 0.57775L151.5 44.2883V131.712L75.9999 175.422Z" fill="#0A17A9" stroke="#0A17A9"/>
          </svg>
          <a href="<?php echo $file; ?>" class="download-link" download onclick="_gaq.push(['_trackEvent','Download','PDF',this.href]);">
            <span class="download-link__icon">
              <img src="<?php echo get_template_directory_uri() . '/assets/images/icon_download.svg'; ?>" alt="" />
            </span>
            <span class="download-link__text">Download story</span>
          </a>
        </div>
      </div>
      <?php endif; ?>
    
    <?php
    // Newsletter Module
    elseif (get_row_layout() == 'newsletter_module') : 
      $sub_title = get_sub_field('sub_title');
      $title = get_sub_field('title');
      $link = get_sub_field('link'); ?>
      <div class="module newsletter-module has-hexagon">
        <?php if ($sub_title): ?>
          <h4><?php echo $sub_title; ?></h4>
        <?php endif; ?>
        <?php if ($title): ?>
          <h2><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if ($link) : ?>
          <a target="_blank" href="<?php echo $link['url']; ?>" class="btn btn-external">
            <?php echo $link['title'];  ?>
          </a>
        <?php endif; ?>
      </div>

    <?php
    // List Text Module 
    elseif (get_row_layout() == 'list_text_module') : 
      $title = get_sub_field('title');
      $content = get_sub_field('content'); ?>
      <div class="module list-text-module has-hexagon">
        <?php if ($title) : ?><h4><?php echo $title; ?></h4><?php endif; ?>
        <?php echo $content; ?>
      </div>
      
    <?php endif;
    endwhile; 
  endif; ?>
</section>