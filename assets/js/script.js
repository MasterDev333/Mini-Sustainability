/**
 * This is script for index page
 */
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin, Draggable);

(function ($) {
	$(document).ready(function () {
		// Function to add and remove the page transition screen
		const loader = document.querySelector(".loader");
		// Horizontal Page Transition
		function loaderIn() {
			// GSAP tween to stretch the loading screen across the whole screen
			return gsap.fromTo(
				loader,
				{
					rotation: 10,
					scaleX: 0,
					scaleY: 1,
					xPercent: -5,
				},
				{
					duration: 0.8,
					xPercent: 0,
					scaleX: 1,
					scaleY: 1,
					rotation: 0,
					ease: "Power4.inOut",
					transformOrigin: "left center",
				}
			);
		}
		function loaderAway(container) {
			// GSAP tween to hide the loading screen
			return gsap
				.timeline({ delay: 1 })
				.add("load")
				.to(loader, {
				duration: 0.8,
				scaleX: 0,
				scaleY: 1,
				xPercent: 5,
				rotation: -10,
				transformOrigin: "right center",
				ease: "Power4.inOut",
			})
				.call(contentAnimation, [container], "load");
		}
		// Vertical Page Transition
		function loaderDown() {
			// GSAP tween to stretch the loading screen across the whole screen
			return gsap.fromTo(
				loader,
				{
					xPercent: 0,
					skewY: 0,
					scaleY: 0,
					scaleX: 1,
					rotation: 0,
					transformOrigin: "left bottom",
				},
				{
					duration: 0.8,
					xPercent: 0,
					skewY: "10deg",
					scaleX: 1,
					scaleY: 1,
					rotation: 0,
					ease: "Power4.inOut",
					transformOrigin: "left bottom",
				}
			);
		}
		function loaderUp(container) {
			// GSAP tween to hide the loading screen
			return gsap
				.timeline({ delay: 1 })
				.add("load")
				.to(loader, {
				duration: 0.8,
				xPercent: 0,
				skewY: 0,
				scaleX: 1,
				scaleY: 0,
				rotation: 0,
				transformOrigin: "left top",
				ease: "Power4.inOut",
			})
				.call(contentAnimation, [container], "load");
		}
		// Function to animate the content of each page
		function contentAnimation() {
			// Reload scripts
			initCursor();
			initScroll();
			initSlider();
			initAnimations();
			initPopup();
			if ($(".page-map").length > 0) {
				initMap();
			}
		}
		//
		function initLoader() {
			if ($(".page-single-story").length > 0) {
				gsap.set(loader, {
					skewY: 0,
					scaleY: 0,
					yPercent: -50,
					transformOrigin: "left bottom",
					autoAlpha: 1,
					backgroundColor: "#0a17a9",
				});
			} else {
				gsap.set(loader, {
					scaleX: 0,
					rotation: 10,
					xPercent: -5,
					yPercent: -50,
					transformOrigin: "left center",
					autoAlpha: 1,
					backgroundColor: "#00b176",
				});
			}
		}

		// Init Barba
		function initBodyClass(data) {
			var response = data.next.html.replace(
				/(<\/?)body( .+?)?>/gi,
				"$1notbody$2>",
				data.next.html
			);
			var bodyClasses = $(response).filter("notbody").attr("class");
			$("body").attr("class", bodyClasses);
		}
		if ($(".barba-wrapper").length > 0) {
			initLoader();

			barba.hooks.before(() => {
				document.querySelector("html").classList.add("is-transitioning");
			});
			barba.hooks.after(() => {
				document.querySelector("html").classList.remove("is-transitioning");
				initLoader();
			});

			barba.init({
				transitions: [
					{
						async leave(data) {
							await loaderIn();
							data.current.container.remove();
						},
						async enter(data) {
							initBodyClass(data);
							await loaderAway(data.next.container);
						},
					},
					{
						name: "story-story",
						from: {
							namespace: "story",
						},
						to: {
							namespace: "story",
						},
						async leave(data) {
							await loaderDown();
							data.current.container.remove();
						},
						async enter(data) {
							initBodyClass(data);
							await loaderUp(data.next.container);
						},
					},
				],
			});
		}

		// CURSOR
		initCursor();
		function initCursor() {
			let cursor = $(".cursor"),
				follower = $(".cursor-follower");
			cursor.removeAttr("class");
			cursor.addClass("cursor");
			follower.removeAttr("class");
			follower.addClass("cursor-follower");
			let posX = 0,
				posY = 0;
			let mouseX = 0,
				mouseY = 0;
			TweenMax.to({}, 0.016, {
				repeat: -1,
				onRepeat: function () {
					posX += (mouseX - posX) / 9;
					posY += (mouseY - posY) / 9;

					TweenMax.set(follower, {
						css: {
							left: posX - 12,
							top: posY - 12,
						},
					});

					TweenMax.set(cursor, {
						css: {
							left: mouseX,
							top: mouseY,
						},
					});
				},
			});
			$(document).on("mousemove", function (e) {
				mouseX = e.clientX;
				mouseY = e.clientY;
			});
			// Change cursor on links
			$(document).on("mouseenter", "a, button", function () {
				cursor.addClass("active");
				follower.addClass("active");
			});
			$(document).on("mouseleave", "a, button", function () {
				cursor.removeClass("active");
				follower.removeClass("active");
			});
			// Change cursor colors
			$(document).on("mouseenter", ".change-cursor", function () {
				let color = $(this).attr("data-color");
				cursor.addClass(color);
				follower.addClass(color);
			});
			$(document).on("mouseleave", ".change-cursor", function () {
				let color = $(this).attr("data-color");
				cursor.removeClass(color);
				follower.removeClass(color);
			});
			$(document).on("mouseenter", ".download-link", function () {
				let color = $(this).attr("data-color");
				cursor.addClass("white");
				follower.addClass("white");
			});
			$(document).on("mouseleave", ".download-link", function () {
				let color = $(this).attr("data-color");
				cursor.removeClass("white");
				follower.removeClass("white");
			});
		}

		// Init scroller
		initScroll();
		function initScroll() {
			const scroller = document.querySelector("scroll");
			if (scroller) {
				const bodyScrollBar = Scrollbar.init(scroller, {
					damping: 0.1,
				});
				ScrollTrigger.scrollerProxy("scroll", {
					scrollTop(value) {
						if (arguments.length) {
							bodyScrollBar.scrollTop = value;
						}
						return bodyScrollBar.scrollTop;
					},
				});
				bodyScrollBar.track.xAxis.element.remove();
				bodyScrollBar.addListener(ScrollTrigger.update);
				ScrollTrigger.defaults({ scroller: scroller });
				bodyScrollBar.addListener((status) => {
					$(window).trigger("scroll");
				});
				// Scroll To links
				$(document).on(
					"click touchend",
					".sidebar a, .btn-scroll-link",
					function (e) {
						let target = $(this).attr("href");
						const targetEl = document.querySelector(target);
						const targetRect = targetEl.getBoundingClientRect();
						e.preventDefault();
						var topY =
							$(target).offset().top - $(".scroll-content").offset().top - 100;
						gsap.to(bodyScrollBar, {
							duration: 1,
							scrollTo: {
								y: topY,
								autoKill: true,
							},
							offsetY: 80,
							ease: "power4",
						});
					}
				);
			}
		}
		initSlider();
		// Init Slider
		function initSlider() {
			if ($(".image-carousel").length > 0) {
				$(".image-carousel").slick({
					arrows: false,
					autoplay: true,
					autoplaySpeed: 2000,
					dots: true,
					infinite: true,
					speed: 300,
					slidesToShow: 1,
					slidesToScroll: 1,
					fade: true,
					cssEase: "linear",
					adaptiveHeight: true,
				});
			}
		}
		// Animations
		initAnimations();
		function initAnimations() {
			// Map page
			if (
				$(".page-map").length > 0 &&
				!sessionStorage.getItem("splash_shown")
			) {
				let tl = gsap.timeline();
				tl.delay(3);
				tl.to(".splash-screen", {
					backgroundColor: "transparent",
					ease: "none",
					duration: 2,
				});
				tl.to(
					".splash-screen__title",
					{
						x: -200,
						opacity: 0,
						duration: 1,
					},
					1.5
				);
				tl.to(
					".splash-screen__desc",
					{
						x: -200,
						opacity: 0,
						duration: 1,
					},
					1.7
				);
				tl.to(
					".logos",
					{
						x: -200,
						opacity: 0,
						duration: 1,
					},
					1.9
				);
				tl.to(".splash-screen", {
					display: "none",
				});
			}
			// Privacy policy sidebar
			if ($(".page-privacy-policy").length > 0) {
				gsap.fromTo(
					".sidebar ul",
					{ y: "220px" },
					{
						y: "30px",
						ease: "none",
						scrollTrigger: {
							trigger: ".content",
							start: "top top",
							end: "220",
							scrub: true,
						},
					}
				);
				$(".sidebar-link").on("click", function () {
					$(".sidebar-link").removeClass("active");
				});
				// Active anchors when section appears on screen
				gsap.utils.toArray(".privacy-block").forEach((block) => {
					let id = $(block).attr("id");
					let anchor = $('a[href="#' + id + '"]');
					ScrollTrigger.create({
						trigger: block,
						start: "top 200",
						end: "bottom 100",
						toggleClass: {
							targets: anchor,
							className: "active",
						},
					});
				});
			}
			// Story page Header
			if ($(".page-single-story").length > 0) {
				$("#story_header").css({
					opacity: 0,
				});
				gsap.to("#story_header", {
					opacity: 1,
					ease: "none",
					scrollTrigger: {
						trigger: ".section-banner",
						start: "center top",
						scrub: true,
					},
				});
				ScrollTrigger.create({
					trigger: ".solution-section",
					start: "top top+=250",
					end: "bottom top+=250",
					toggleClass: {
						targets: "#story_header .map-link, #story_header .social-buttons a",
						className: "color--white",
					},
				});

				ScrollTrigger.create({
					trigger: ".next-section",
					start: "top top+=300",
					bottom: "bottom top+=300",
					toggleClass: {
						targets: "#story_header .map-link, #story_header .social-buttons a",
						className: "hide",
					},
				});
				// gsap.to("#story_header .map-link, #story_header .social-buttons a", {
				//   opacity: 0,
				//   scrollTrigger: {
				//     trigger: ".next-section",
				//     start: "top top+=250",
				//     bottom: "bottom top+=250",
				//   },
				// });
				let mquery = window.matchMedia(
					"(min-width: 1200px) and (min-height: 500px) and (max-height: 820px)"
				);
				if (mquery.matches) {
					gsap.to(".btn-scroll-link", {
						top: 700,
						ease: "none",
						scrollTrigger: {
							trigger: ".section-banner",
							start: "top top+=320",
							end: "bottom top",
							scrub: true,
						},
					});
				}

				// Add share via
				if ($(".addtoany_shortcode").length > 0) {
					$(".addtoany_shortcode a").each(function () {
						$(this).append("<span>Share via</span>");
					});
				}
			}
		}

		// Init Popup
		initPopup();
		function initPopup() {
			// Show splash screen only once
			if (
				$(".splash-screen").length > 0 &&
				!sessionStorage.getItem("splash_shown")
			) {
				$(".splash-screen").css({ display: "flex" });
				sessionStorage.setItem("splash_shown", true);
			}
			// Init popup
			if ($(".popup").length > 0) {
				$(".popup-close").on("click", function () {
					let popup = $(this).closest(".popup");
					$(popup).removeClass("active");
					if ($(this).closest('.popup').attr('id') == 'story-popup') {
						Draggable.get("#map").applyBounds();
					}
				});
				$(".btn-popup").on("click", function () {
					let popup = $(this).attr("data-target");
					$(popup).addClass("active");
				});
			}
		}

		// Init Map
		if ($(".page-map").length > 0) {
			initMap();
		}

		// Story Popup
		$(document).on("click", ".map-button", function () {
			if (!$(this).hasClass("clicked")) {
				$(".map-button.clicked").removeClass("clicked");
			}
			$(this).toggleClass("clicked");
			let postID = $(this).attr("data-post-id");
			if ($(this).hasClass("clicked")) {
				let $building = $(this);
				$.ajax({
					url: ajaxurl,
					type: "POST",
					data: {
						action: "loadStoryPopup",
						postID: postID,
					},
					beforeSend: function () {
						$("#story-popup .popup-body").html("");
					},
					success: function (response) {
						let result = $.parseJSON(response);
						$("#story-popup .popup-body").html(result);
						$("#story-popup").addClass("active");
					},
					complete: function() {
						let boundingRect = $building.get(0).getBoundingClientRect();
						let moveX = boundingRect.x - $(window).width() * 0.3 + boundingRect.width / 2;
						let moveY = boundingRect.y - $(window).height() * 0.5;
						if (moveX > 0 || moveY < 0) {
							let currX = gsap.getProperty('#map', 'x');
							let currY = gsap.getProperty('#map', 'y');
							let offsetX = currX - moveX;
							let offsetY = currY - moveY;
							if (offsetX > 0) offsetX = 0;
							if (offsetY > 0) offsetY = 0;
							
							gsap.to('#map', {
								x: offsetX,
								y: offsetY
							});
						}
					}
				});
			} else {
				$("#story-popup").removeClass("active");
			}
		});
		$(document).on("mouseenter", ".map-button", function () {
			$(this).addClass("hover");
		});
		$(document).on("mouseleave", ".map-button", function () {
			$(this).removeClass("hover");
		});
		// Hide story popup
		$(document).on("click", ".map", function () {
			if ($("#story-popup").hasClass("active")) {
				$(".map-button.clicked").removeClass("clicked");
				$("#story-popup").removeClass("active");
			}
		});
		
		// Update GSAP Draggable bound
		function applyBounds() {
			let scale = $('.map-inner').attr('data-scale');
			let vw = $(window).width();
			let vh = $(window).height();
			let mapWidth = document.getElementById("map").getBoundingClientRect()
			.width * scale,
				mapHeight = document.getElementById("map").getBoundingClientRect()
			.height * scale;
			let minX = vw - mapWidth;
			let minY = vh - mapHeight;
			console.log (minX, minY, mapWidth, mapHeight, $('#map').offset());
			Draggable.get("#map").applyBounds({
				top: -(vh - mapHeight),
				left: -(vw - mapWidth),
				minX: minX,
				minY: minY,
				maxX: 0,
				maxY: 0,
			});
		}
		function initMap() {
			centerMap();

			// Load Map from Ajax
			$.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					action: "loadMap",
				},
				success: function (response) {
					let result = $.parseJSON(response);
					$(".map-inner").html(result.output);
				},
				complete: function () {
					// background image
					setTimeout(() => {
						$(".map-inner").css(
							"background-image",
							'url("/wp-content/themes/sustainability/assets/images/filter-2.png")'
						);
					}, 1000);

					// Show Map element animation
					var mapElements = $(".map-item").toArray();
					gsap.set(".map-item", { opacity: 0, y: 100 });
					$(".map-item").each(function (index) {
						let tl = gsap.timeline({
							defaults: { duration: 0.8, ease: Power1.easeInOut },
						});
						if ($(this).hasClass("map-button")) {
							tl.to(this, { opacity: 1, y: -200 });
							tl.to(this, { y: -150 });
							tl.to(this, { y: -180 });
							tl.to(this, { y: 0 }, "+=0.4");
						} else {
							if (index % 3 == 0) {
								tl.to(this, { opacity: 1, y: -100 }, "+=0.2");
								tl.to(this, { y: -50 });
								tl.to(this, { y: -80 });
								tl.to(this, { y: 0 });
							} else if (index % 3 == 1) {
								tl.to(this, { opacity: 1, y: -120 }, "+=0.4");
								tl.to(this, { y: -60 });
								tl.to(this, { y: -100 });
								tl.to(this, { y: 0 });
							} else {
								tl.to(this, { opacity: 1, y: -80 }, "+=0.6");
								tl.to(this, { y: -30 });
								tl.to(this, { y: -50 });
								tl.to(this, { y: 0 });
							}
						}
					});
				},
			});
			// Init arrow buttons
			let map = ".map .map-inner";
			let mapOffset,
				mapWidth = document.getElementById("map").getBoundingClientRect().width,
				mapHeight = document.getElementById("map").getBoundingClientRect().height;
			$(".btn-map-control").on("click", function () {
				let boundingRect = document.getElementById("map").getBoundingClientRect();
				let scale = $('#map').attr('data-scale');
				mapOffset = $(map).offset();
				mapWidth = boundingRect.width;
				mapHeight = boundingRect.height;
				let direction = $(this).attr("data-direction");
				let offsetVal = 100;
				let scaledX = (2850 * (scale - 1)) / 2;
				let scaledY = (1770 * (scale - 1)) / 2;
				switch (direction) {
					case "top":
						if (mapOffset.top + offsetVal <= 0)
							gsap.to(map, { y: "+=" + offsetVal });
						else gsap.to(map, { y: scaledY });
						break;
					case "bottom":
						if (mapOffset.top + mapHeight - offsetVal >= $(window).height())
							gsap.to(map, { y: "-=" + offsetVal });
						else gsap.to(map, { y: -(mapHeight - $(window).height() - scaledY) });
						break;
					case "left":
						if (mapOffset.left + offsetVal <= 0)
							gsap.to(map, { x: "+=" + offsetVal });
						else gsap.to(map, { x: scaledX });
						break;
					case "right":
						if (mapOffset.left + mapWidth - offsetVal >= $(window).width())
							gsap.to(map, { x: "-=" + offsetVal });
						else gsap.to(map, { x: -(mapWidth - $(window).width() - scaledX) });
						break;
				}
				Draggable.get("#map").applyBounds();
// 				applyBounds();
			});
			// Remove active map element when click popup close
			$("#story-popup .popup-close").on("click", function () {
				$(".map-button.clicked").removeClass("clicked");
			});

			// Make map draggable
			var draggable = Draggable.create("#map", {
				type: "x,y",
				edgeResistance: 0,
				allowNativeTouchScrolling: false,
				bounds : '.map',
				dragClickables: true,
				allowEventDefault: true,
				throwProps: true,
			});
			Draggable.get("#map").applyBounds();
// 			applyBounds();
			// Zoom and zoomout
			let scale = 1;
			$(".btn-zoom").on("click", function () {
				let mode = $(this).attr("data-zoom");
				let $zoomOut = $(".btn-zoom-out"),
					$zoomIn = $(".btn-zoom-in");
				let minScale = 1;
				switch (mode) {
					case "in":
						scale += 0.1;
						if (scale > 1.5) {
							scale = 1.5;
							$zoomIn.addClass("disabled");
						}
						if (scale > minScale) {
							$zoomOut.removeClass("disabled");
						}
						break;
					case "out":
						scale -= 0.1;
						if (scale < minScale) {
							scale = minScale;
							$zoomOut.addClass("disabled");
						}
						if (scale < 1.5) {
							$zoomIn.removeClass("disabled");
						}
						break;
				}
				let tl = new TimelineMax({
					onComplete: function () {
						Draggable.get("#map").applyBounds();
// 						applyBounds();
					},
				});
				tl.to(map, {
					scaleX: scale,
					scaleY: scale,
				});
				$('.map-inner').attr('data-scale', scale);
			});
		}
		// Make Draggable center of viewport
		function centerMap() {
			let vw = $(window).width();
			let vh = $(window).height();
			let scale = $('.map-inner').attr('data-scale');
			let mapWidth = document.getElementById("map").getBoundingClientRect()
			.width * scale,
				mapHeight = document.getElementById("map").getBoundingClientRect()
			.height * scale;
			var start_x = -(mapWidth - vw) / 2;
			var start_y = -(mapHeight - vh) / 2;
			TweenLite.set("#map", {
				x: start_x,
				y: start_y,
				transformOrigin: "center center",
			});
		}
		// Update Map on screen resize and load
		$(window).on("load resize", function () {
			if ($(".page-map").length > 0) {
				let tl = new TimelineMax({
					onComplete: function () {
						Draggable.get("#map").applyBounds();
// 						applyBounds();
						centerMap();
					},
				});
				if (window.matchMedia("(max-width: 767px").matches) {
					tl.to("#map", { scale: 1 });
					$('.map-inner').attr('data-scale', 1);
				} else {
					tl.to("#map", { scale: 1.2 });
					$('.map-inner').attr('data-scale', 1.2);
				}
			}
		});
	});
})(jQuery);
