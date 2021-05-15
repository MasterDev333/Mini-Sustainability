<?php 
$story_title = get_field('story_title');
$story_desc = get_field('story_description');
$mode = get_field('under_construction');
if ($mode) : ?> 
  <?php if (have_rows('construction_popup', 'options')):
    while (have_rows('construction_popup', 'options')) : the_row(); 
    $title = get_sub_field('title');
    $desc = get_sub_field('description');
    $button = get_sub_field('button');
    ?>
      <?php if ($title): ?>
        <h3 class="popup-title"><?php echo $title; ?></h3>
      <?php endif; 
      if ($desc): ?>
        <p class="popup-desc"><?php echo $desc; ?></p>
      <?php endif;
      if ($button): ?>
      <div class="popup-button__wrapper">
          <a href="<?php echo $button['url'] ?>" class="btn btn-internal" target="_blank">
              <?php echo $button['title']; ?>
          </a>
      </div>
      <?php endif; 
      endwhile;
    endif;?>
<?php else : ?>
  <?php if ($story_title) : ?>
    <h3 class="popup-title"><?php echo $story_title; ?></h3>
  <?php endif;
  if ($story_desc) : ?>
    <p class="popup-desc"><?php echo $story_desc; ?></p>
  <?php endif; ?>
  <div class="popup-button__wrapper">
      <a href="<?php echo get_the_permalink(); ?>" class="btn btn-internal btn-read-story">
          Read story
      </a>
  </div>
<?php endif; ?>
  