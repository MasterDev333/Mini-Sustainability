<?php get_header(); ?>

<div class="barba-wrapper" data-barba="wrapper">
	<!-- Begin Cursor -->
	<div class="cursor"></div>
	<div class="cursor-follower"></div>
	<!-- End Cursor -->
	<div data-barba="container" data-barba-namespace="story">
		<div class="page-single-story">
			<!-- Begin Header -->
			<header class="header" id="story_header">
				<?php
				$map_view = get_field('map_view', 'options');
				if ($map_view): ?>
				<a href="<?php echo esc_url(home_url( '/' )); ?>" class="map-link page-link">
					<span class="map-link__icon">
						<img src="<?php echo get_template_directory_uri() . '/assets/images/icon_map_view.svg'; ?>" alt="" />
					</span>
					<span class="map-link__text">Return to Map</span>
				</a>
				<?php endif; ?>
				<a href="<?php echo esc_url(home_url( '/list' )); ?>" class="map-link list-link page-link">
					<span class="map-link__icon">
						<img src="<?php echo get_template_directory_uri() . '/assets/images/icon_list_view.svg'; ?>" alt="" />
					</span>
					<span class="map-link__text">Return to List</span>
				</a>
				<div class="social-buttons">
					<?php echo do_shortcode('[addtoany]'); ?>
				</div>
			</header>
			<!-- End Header -->
			<scroll>
				<!-- Begin Content -->
				<main>
					<section class="section section-banner">
						<?php 
						$featured_img_url = get_the_post_thumbnail_url(get_the_ID());
						$default_img_url = get_template_directory_uri() . '/assets/images/bg.jpg';
						$banner_img_url = ($featured_img_url) ?  $featured_img_url : $default_img_url; ?>
						<div
							class="section-banner__img"
							style="background-image: url(<?php echo $banner_img_url; ?>)"
						>
						</div>
						<div class="section-banner__content">
							<div class="container">
								<div class="left">
									<?php if (get_field('story_title')): ?>
										<h2 class="section-banner__title text-primary"><?php echo get_field('story_title'); ?></h2>
									<?php endif; ?>
									<?php if (get_field('story_description')): ?>
										<p class="section-banner__desc size-large"><?php echo get_field('story_description'); ?></p>
									<?php endif; ?>
								</div>
								<div class="right">
									<?php if (have_rows('partners')):
									while(have_rows('partners')): the_row(); ?>
									<?php if (get_sub_field('title')): ?>
										<p class="partners-title text-primary"><?php echo get_sub_field('title'); ?></p>
									<?php endif; ?>
									<?php if (have_rows('links')): 
										while (have_rows('links')): the_row(); 
											$link = get_sub_field('link'); ?>
											<a
												href="<?php echo $link['url']; ?>"
												class="link-external partners-link"
												target="_blank"
											>
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
									<?php endwhile;
									endif; ?>
								</div>
							</div>
						</div>
						<a href="#next-section" class="link-scroll-down btn-scroll-link">
							<svg
								width="17"
								height="26"
								viewBox="0 0 17 26"
								fill="none"
								xmlns="http://www.w3.org/2000/svg"
							>
								<path
									fill-rule="evenodd"
									clip-rule="evenodd"
									d="M17 17.3848L9.92893 24.4559L8.51472 25.8701L7.1005 24.4559L0.0294388 17.3848L1.44365 15.9706L7.51471 22.0417L7.51471 6.97427e-05L9.51471 6.99175e-05L9.51471 22.0417L15.5858 15.9706L17 17.3848Z"
									fill="#1D1D1D"
									fill-opacity="0.4"
								/>
							</svg>
						</a>
					</section>
					<?php 
					if (have_rows('page_sections')) :
						while (have_rows('page_sections')) : the_row(); 
							$row_index = get_row_index();
							if (get_row_layout() == 'section') :
								get_template_part ('template-parts/page-modules', 'block', array	(
									'row_index' => $row_index
								));
							endif;
						endwhile;
					endif; ?>
				</main>
				<!-- End Content -->

				<!-- Begin Footer -->
				<footer>	
					<?php 
					$next_post = get_next_post();
					if ( empty( $next_post ) ) {
						global $post;
						$args = array(
							'posts_per_page' => 1, 
							'post_type' => $post->post_type, 
							'post_status' => 'publish', 
							'orderby' => 'menu_order'
						);
						$next_post = new WP_QUERY( $args );
						$next_post->the_post();
					} 
					?>
					<section class="section next-section">
						<div
							class="next-section__content bg-primary change-cursor"
							data-color="white"
						>
							<div class="container">
								<h4>Next Story</h4>
								<?php	$title = get_field('story_title', $next_post->ID);
									if ($title): ?>
										<h2><?php echo $title; ?></h2>
									<?php endif; ?>
									<a href="<?php echo get_permalink( $next_post->ID ); ?>" class="btn btn-internal page-link">Read story</a>
							</div>
						</div>
						<?php $featured_img_url = get_the_post_thumbnail_url($next_post->ID);
						$default_img_url = get_template_directory_uri() . '/assets/images/bg.jpg';
						$banner_img_url = ($featured_img_url) ?  $featured_img_url : $default_img_url; ?>
						<div
							class="next-section__img"
							style="background-image: url(<?php echo $banner_img_url; ?>)"
						></div>
					</section>
				</footer>
				<!-- End Footer -->
			</scroll>
		</div>
	</div>
</div>

<?php get_footer(); ?>