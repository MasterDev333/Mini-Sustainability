<?php
/*
Template Name: Map
Template Post Type: page
*/
$assets_uri = get_template_directory_uri() . '/assets/images/';
get_header(); ?>	
<div class="barba-wrapper" data-barba="wrapper">
	<!-- Begin Cursor -->
	<div class="cursor"></div>
	<div class="cursor-follower"></div>
	<!-- End Cursor -->
	<div data-barba="container" data-barba-namespace="map">
		<div class="page-map">
			<!-- Begin Splash -->
			<div class="popup change-cursor splash-screen" data-color="white">
				<?php 
				$splash_title = get_field('splash_title');
				$splash_content = get_field('splash_content'); 
				if ($splash_title): ?>
					<h1 class="splash-screen__title"><?php echo $splash_title; ?></h1>
				<?php endif; 
				if ($splash_content): ?>
					<p class="splash-screen__desc size-large"><?php echo $splash_content; ?></p>
				<?php endif; ?>
				<?php if (have_rows('partners_logo')): ?>
					<div class="logos">
					<?php while (have_rows('partners_logo')) : the_row(); 
					$image = get_sub_field('logo'); ?>
						<img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" />
					<?php endwhile; ?>
				</div>
				<?php endif; ?>
			</div>
			<!-- End Splash -->
			<!-- Begin Header -->
			<header class="header" id="map_header">
				<a href="<?php echo esc_url(home_url( '/list/' )) ?>" class="header-link header-link__list">
					<img src="<?php echo $assets_uri . 'list_view.svg'; ?>" alt="" />
					<span>List View</span>
				</a>
				<div class="controls">
					<button class="btn-popup btn-instruction" data-target="#instruction-popup">
						<svg
							width="12"
							height="20"
							viewBox="0 0 12 20"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								d="M4.34363 13.813V9.211C5.92963 9.211 7.18629 8.87733 8.11363 8.21C9.04096 7.54267 9.50463 6.689 9.50463 5.649C9.50463 4.791 9.13196 4.076 8.38663 3.504C7.64996 2.932 6.70096 2.646 5.53963 2.646C4.21363 2.646 2.94396 3.179 1.73063 4.245L0.443625 2.477C2.00363 1.151 3.79329 0.488 5.81263 0.488C7.00863 0.488 8.08329 0.730666 9.03663 1.216C9.98996 1.70133 10.718 2.33833 11.2206 3.127C11.732 3.907 11.9876 4.752 11.9876 5.662C11.9876 6.936 11.5153 8.04533 10.5706 8.99C9.62596 9.93467 8.36496 10.524 6.78763 10.758V13.813H4.34363ZM4.43463 18.857C4.13129 18.545 3.97963 18.1593 3.97963 17.7C3.97963 17.2407 4.13129 16.8593 4.43463 16.556C4.74663 16.244 5.13229 16.088 5.59163 16.088C6.05096 16.088 6.43229 16.244 6.73562 16.556C7.04763 16.8593 7.20363 17.2407 7.20363 17.7C7.20363 18.1593 7.04763 18.545 6.73562 18.857C6.43229 19.1603 6.05096 19.312 5.59163 19.312C5.13229 19.312 4.74663 19.1603 4.43463 18.857Z"
								fill="#0A17A9"
							/>
						</svg>
					</button>
					<button class="btn-zoom btn-zoom-in" data-zoom="in">
						<svg
							width="20"
							height="20"
							viewBox="0 0 20 20"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								d="M10 0.399902V19.5999"
								stroke="#0A17A9"
								stroke-width="2"
							/>
							<path
								d="M19.6001 10L0.400096 10"
								stroke="#0A17A9"
								stroke-width="2"
							/>
						</svg>
					</button>
					<button class="btn-zoom btn-zoom-out" data-zoom="out">
						<svg
							width="20"
							height="2"
							viewBox="0 0 20 2"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<path
								d="M19.6001 1L0.400096 0.999999"
								stroke="#0A17A9"
								stroke-width="2"
							/>
						</svg>
					</button>
				</div>
			</header>
			<!-- End Header -->
			<!-- Begin Map -->
			<section class="map-view">
				<div class="map-wrapper">
					<div class="map">
						<div class="map-inner" id="map"></div>
					</div>
					<div class="map-controls">
						<button class="btn-map-control top" data-direction="top">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/arrow.svg'; ?>" alt="" />
						</button>
						<button class="btn-map-control left" data-direction="left">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/arrow.svg'; ?>" alt="" />
						</button>
						<button class="btn-map-control bottom" data-direction="bottom">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/arrow.svg'; ?>" alt="" />
						</button>
						<button class="btn-map-control right" data-direction="right">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/arrow.svg'; ?>" alt="" />
						</button>
					</div>
				</div>
			</section>
			<!-- End Map -->
			<!-- Begin Popups -->
			<div class="popup change-cursor" data-color="white" id="instruction-popup">
				<button class="popup-close">
					<span class="popup-close__img">
						<svg
							width="88"
							height="88"
							viewBox="0 0 88 88"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<circle cx="44" cy="44" r="44" fill="white" />
							<path d="M60 28L28 60" stroke="#00B176" stroke-width="4" />
							<path d="M28 28L60 60" stroke="#00B176" stroke-width="4" />
						</svg>
					</span>
					<span class="popup-close__text">Close</span>
				</button>
				<div class="popup-body">
					<?php 
					$instruction_title = get_field('instructions_title');
					$instruction_description = get_field('instructions_description');
					$sign_up = get_field('sign_up_link');
					if ($instruction_title): ?>
						<p class="popup-title"><?php echo $instruction_title; ?></p>	
					<?php endif; 
					if ($instruction_description): ?>
						<div class="popup-content"><?php echo $instruction_description; ?></div>
					<?php endif; ?>
					<div class="popup-footer">
						<div class="popup-footer__left">
							<a target="_blank" href="https://constructioninnovationhub.org.uk">
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-constructionhub.svg" alt="">
							</a>
							<p>The ‘World of What If…’ is a Construction Innovation Hub initiative, sharing stories of sustainable initiatives across the construction sector which are driving better social, environmental and economic outcomes for our future.</p>
						</div>
						<?php if ($sign_up): ?>
						<div class="popup-footer__right popup-button__wrapper">
							<a 
								href="<?php echo $sign_up['url']; ?>" 
								class="btn btn-internal btn-sign-up" target="_blank">
								<?php echo $sign_up['title']; ?>
							</a>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="popup change-cursor" data-color="white" id="story-popup">
				<button class="popup-close">
					<span class="popup-close__img">
						<svg
							width="88"
							height="88"
							viewBox="0 0 88 88"
							fill="none"
							xmlns="http://www.w3.org/2000/svg"
						>
							<circle cx="44" cy="44" r="44" fill="white" />
							<path d="M60 28L28 60" stroke="#00B176" stroke-width="4" />
							<path d="M28 28L60 60" stroke="#00B176" stroke-width="4" />
						</svg>
					</span>
					<span class="popup-close__text">Close</span>
				</button>
				<div class="popup-body">
					<!-- Ajax contents goes here -->
				</div>
			</div>
			<!-- End Popups -->
		</div>
	</div>
</div>
<?php get_footer(); ?>