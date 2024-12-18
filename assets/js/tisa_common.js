/* common functions */

	//* detect touch devices
	function is_touch_device() {
		return !!('ontouchstart' in window);
	} 

	/*
	* debouncedresize: special jQuery event that happens once after a window resize
	*
	* latest version and complete README available on Github:
	* https://github.com/louisremi/jquery-smartresize
	*
	* Copyright 2012 @louis_remi
	* Licensed under the MIT license.
	*
	* This saved you an hour of work? 
	* Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
	*/
	(function(a){var d=a.event,b,c;b=d.special.debouncedresize={setup:function(){a(this).on("resize",b.handler)},teardown:function(){a(this).off("resize",b.handler)},handler:function(a,f){var g=this,h=arguments,e=function(){a.type="debouncedresize";d.dispatch.apply(g,h)};c&&clearTimeout(c);f?e():c=setTimeout(e,b.threshold)},threshold:150}})(jQuery);

	$(function() {
		// side navigation
		tisa_side_navigation.init();
		// top dropdown navigation
		tisa_top_navigation.init();
		// default tooltips, popovers iniy
		tisa_tooltips_popovers.init();
		// custom color picker
		tisa_custom_color_picker.init();
	})

	// side navigation
	tisa_side_navigation = {
		init: function() {
			if($('#side_nav').length) {
				
				var nav_timeout = 425, rightPos = 220;
				
				$('#side_nav > ul > li').each(function() {
					if($(this).children('.sub_panel').length) {
						$(this).addClass('nav_trigger');
					}
				});
				
				// disable click event on link (if section has subsection)
				$('.nav_trigger > a').on('click',function(e) {
					e.preventDefault();
				})
				
				// adjust nav position
				var nav_side_position = ($('body').hasClass('side_nav_narrow') || $(window).width() <= 992) ? '70' : '80';
				
				
				
					// click event for touch devices
						
					$('body').addClass('side_nav_click');
					
					$('#side_nav .nav_trigger > a').on('click',function(e){
						e.stopPropagation();
						e.preventDefault();
						var $this = $(this),$this_parent = $this.closest('.nav_trigger');
						
						if ($this_parent.hasClass('nav_open')) {
							$this_parent.removeClass('nav_open').find('.sub_panel').stop(true, true).animate({right : -rightPos}, nav_timeout, 'easeInOutExpo');
						} else {
							$('#side_nav .nav_trigger').removeClass('nav_open').find('.sub_panel').stop(true, true).animate({right : -rightPos}, nav_timeout, 'easeInOutExpo');
							console.log($this_parent);
							$this_parent.addClass('nav_open').find('.sub_panel').stop(true, true).animate({right : nav_side_position}, nav_timeout, 'easeInOutExpo',function() {
								tisa_side_navigation.scroll_bar();
							});
						}
						tisa_side_navigation.scroll_bar();
					})
					
				
				// update side navigation position on viewport resize/orientation change
				$(window).on("debouncedresize", function( event ) {
					$('#side_nav .nav_trigger').removeClass('nav_open').find('.sub_panel').stop(true, true).animate({right : -rightPos}, nav_timeout, 'easeInOutExpo');
					nav_side_position = ($('body').hasClass('side_nav_narrow') || $(window).width() <= 992) ? '50' : '80';
				});
				
			}
		},
		scroll_bar: function() {
			// side menu scroll bar
			if (!$('.nav_open .side_inner').hasClass('ps-ready')) {
				$('.nav_open .side_inner').addClass('ps-ready').height($('.nav_open .sub_panel').height() - 42).perfectScrollbar({
					wheelSpeed:100,
					suppressScrollX: true
				});
			} else {
				$('.nav_open .ps-ready').height($('.nav_open .sub_panel').height() - 42).scrollTop(0).perfectScrollbar('update');
			}
		}
	}

	// top dropdown navigation (mobile nav)
	tisa_top_navigation = {
		init: function() {
			$('.top_links').tinyNav({
				active: 'selected',
				select_class: 'form-control input-sm',
				header: '-- Nav --'
			});
		}
	}

	// default tooltips, popovers init
	tisa_tooltips_popovers = {
		init: function() {
			$('[data-toggle=tooltip]').tooltip({
				container: "body"
			})
			$('[data-toggle=popover]').popover({
				container: "body"
			});
		}
	}
	
	// custom color picker
	tisa_custom_color_picker = {
		init: function() {
			
			$('.ts_label').each(function() {
				$(this)
				.append('<ul class="ts_picker" style="display:none"><li class="color_a"></li><li class="color_b"></li><li class="color_c"></li><li class="color_d"></li><li class="color_e"></li><li class="color_f"></li><li class="color_g"></li><li class="color_h"></li><li class="color_i"></li></ul>')
				.children('span').click(function() {
					$('.ts_picker').hide();
					$('.ts_label').children('span').removeClass('act_picker');
					$(this).toggleClass('act_picker');
					if($(this).hasClass('act_picker')) {
						$(this).next('.ts_picker').show();
					} else {
						$(this).next('.ts_picker').hide();
					}
					
				});
			})
			
			$('.ts_picker').on('click','li',function() {
				var this_color = $(this).attr('class');
				$(this).closest('.ts_picker').hide().prev().removeAttr('class').addClass(this_color);
			})
			
		}
	}