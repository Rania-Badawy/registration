	   
	     // light-box
	    jQuery(document).ready(function() {     
			$('#example6 a').Chocolat({
			overlayColor:'#000',
			leftImg:'images/leftw.gif',
			rightImg:'images/rightw.gif',
			closeImg:'images/closew.gif'});
		});
		
		
		
		  // tooltip
		$(function(){
		   $('a[title]').tooltip();
		});
		
		
		
		
		
		jQuery(document).ready(function($){
			
		  // change style box
		  
			var colorLi =$('.color-option ul li');
			colorLi
			.eq(0).css("backgroundColor","#fe4444").end()  // default theme
			.eq(1).css("backgroundColor","#6dcda7").end()  // light-green
			.eq(2).css("backgroundColor","#fbb829").end()  // light-orange
			.eq(3).css("backgroundColor","#025d8c").end()  // dark-blue
			.eq(4).css("backgroundColor","#ff6600").end()  // dark-orange
			.eq(5).css("backgroundColor","#f02311").end()  // dark-red
			.eq(6).css("backgroundColor","#9b2139").end()  // burgundy
			.eq(7).css("backgroundColor","#8cc732").end()  // green
			.eq(8).css("backgroundColor","#56ad48").end()  // dark-green
			.eq(9).css("backgroundColor","#544aa1").end()  // Purple
			.eq(10).css("backgroundColor","#40aae6").end() // blue
			.eq(11).css("backgroundColor","#1abc9c").end() // flat-green 
			
			colorLi.click(function(){
				$("link[href*='theme']").attr("href",$(this).attr("data-value"));
				
				});		
				
					
			// box-option
			$('.gear-check').click(function(){
				$('.color-option').toggle(10);

			});
			});
			
			
			//back to top	
		jQuery(document).ready(function($){
			// browser window scroll (in pixels) after which the "back to top" link is shown
			var offset = 300,
				//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
				offset_opacity = 1200,
				//duration of the top scrolling animation (in ms)
				scroll_top_duration = 700,
				//grab the "back to top" link
				$back_to_top = $('.cd-top');
		
			//hide or show the "back to top" link
			$(window).scroll(function(){
				( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
				if( $(this).scrollTop() > offset_opacity ) { 
					$back_to_top.addClass('cd-fade-out');
				}
			});
		
		
			//smooth scroll to top
			$back_to_top.on('click', function(event){
				event.preventDefault();
				$('body,html').animate({
					scrollTop: 0 ,
					}, scroll_top_duration
				);
			});
		
		});
		
		
			//owlCarousel
		  $(document).ready(function() {

			  $("#owl-demo").owlCarousel({
				items : 3,
				lazyLoad : true,
				navigation : true
			  });
		
			});
	

    $(document).ready(function() {
     
      //Sort random function
      function random(owlSelector){
        owlSelector.children().sort(function(){
            return Math.round(Math.random()) - 0.5;
        }).each(function(){
          $(this).appendTo(owlSelector);
        });
      }
	  
	  
     	//owlCarouse2
      $("#owl-demo2").owlCarousel({
        navigation: true,
        navigationText: [
          "<i class='fa fa-chevron-left'></i>",
          "<i class='fa fa-chevron-right'></i>"
          ],
        beforeInit : function(elem){
          //Parameter elem pointing to $("#owl-demo")
          random(elem);
        }
     
      });
     
    });


		//navbar-fixed-top
	  $(document).scroll(function(e){
		var scrollTop = $(document).scrollTop();
		if(scrollTop > 0){
			console.log(scrollTop);
			$('.navbar').removeClass('navbar-static-top').addClass('navbar-fixed-top');
		} else {
			$('.navbar').removeClass('navbar-fixed-top').addClass('navbar-static-top');
		}
		});
	
	
		//last news slider
	
<!--	$('.navbar-toggle').click();-->
    jQuery(document).ready(function($){
        //create the slider
        $('.cd-testimonials-wrapper').flexslider({
            selector: ".cd-testimonials > li",
            animation: "slide",
            controlNav: false,
            slideshow: false,
            smoothHeight: true,
            start: function(){
                $('.cd-testimonials').children('li').css({
                    'opacity': 1,
                    'position': 'relative'
                });
            }
        });
    
    
    });