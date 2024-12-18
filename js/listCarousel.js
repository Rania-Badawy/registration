(function( $ ) {

    $.fn.listCarousel = function() {

        this.parent = this;
        this.current = 0;
        this.firstSlide = this.parent.find('li').first();
        this.loop;
        this.controls = null;

        // Save 'this' reference for use in deeper scopes
        var _ = this;


        this.init = function() {

            //  If there's no jQuery, none of this can work, stop
            if(!$) return false;

            // if controls are already set up, stop
            if( $('#slider-controls').length ) return false;

            _.initControls();
            _.initObservers();
            _.initCSS();
            _.startLoop();
        }



        // Inserts <span>s to <ul> as controls for slider
        this.initControls = function() {

            // add new element to <ul>, save it as .controls
            _.controls = $('<div/>', {
                id: 'slider-controls'
            }).appendTo(_.parent);

            var span;

            // insert X number of buttons to new control div
            for (var i=0; i < _.parent.find('li').length; i++) {
               span = '<span data-slide="' + i + '"></span>';
                _.controls.append(span);
            }

            // insert 'previous' button
            $('<div/>', {
                id : 'slider-previous'
            }).appendTo(_.parent);

            // insert 'next' button
            $('<div/>', {
                id : 'slider-next'
            }).appendTo(_.parent);
        }



        // Sets up observers for controls
        this.initObservers = function() {

            _.parent.hover(function() {
                _.stopLoop();
            }, function() {
                _.startLoop();
            })

            _.controls.find('span').each(function() {
                $(this).on('click touchstart', function(event) {
                    _.moveTo( $(event.target).data('slide') );
                })
            });

            $('#slider-previous').on('click touchstart', function() {
                _.previous();
            });

            $('#slider-next').on('click touchstart', function() {
                _.next();
            });
        }



        // sets up things like <li> height and controls placement
        this.initCSS = function() {
            var liFontSize = _.parent.find('li').first().css('font-size');


            // <ul> and <li> styles
            _.parent.css({ 'font-size' : 0, 'overflow' : 'hidden', 'white-space' : 'nowrap', 'height' : '400px', 'margin' : '0 auto', 'padding' : '0', 'position' : 'relative' });
            _.parent.find('li').css({ 'min-height' : '100px', 'max-height' : $(this).width() * .565 + 'px', 'list-style' : 'none', 'font-size' : liFontSize, 'display' : 'inline-block', 'width' : '100%', 'margin' : 0, 'vertical-align' : 'top', 'overflow' : 'hidden'  });
            _.parent.find('img').css({'width' : '100%'});

      


            // previous/next button styles
            $('#slider-previous')
                .css({ 'color': "white", 'font-size': '2.4rem', 'cursor' : 'pointer', 'display': 'block', 'position': 'absolute', 'top': '50%,', 'top' : 'calc(50% - 36px)', 'left': '10px', 'height': '45px', 'width': '46px', 'background-image': 'url(images/left_ar.png)', 'background-repeat':'no-repeat' , 'padding' : '10px 20px' })
                .html('');
            $('#slider-next')
                .css({ 'color': "white", 'font-size': '2.4rem', 'cursor' : 'pointer', 'position': 'absolute', 'top': '50%,', 'top' : 'calc(50% - 36px)', 'right': '10px', 'height': '45px', 'width': '46px', 'background-image': 'url(images/right_ar.png)', 'background-repeat':'no-repeat' , 'padding' : '10px 20px' })
                .html('');


            // you can't select pseudoselectors via jQuery, so we do this to compensate
            $('head').append('<style>#slider-controls span.active:before{ content: "";position: absolute; top: 2px; left: 2px; display: block; width: 6px; height: 6px; background-color: white; border-radius: 50%; }</style>');
        }



        // moves to 'num'th slide
        this.moveTo = function(num) {
            if(num === -1) num = _.parent.find('li').length - 1;

            _.firstSlide.animate({
                'margin-left' : '-' + (num * _.firstSlide.outerWidth()) + 'px'
            });
            _.current = num;

            _.controls.find('span').eq(num).addClass('active').siblings().removeClass('active');
        }



        /* Hide current slide, show next slide */
        this.next = function() {
            // grab previous element
            if( _.parent.find('li').eq(_.current + 1).length ) {
                _.moveTo( _.current + 1 );
            } else {
                _.moveTo( 0 );
            }
        }



        /* Hide current slide, show previous slide */
        this.previous = function() {
            _.moveTo( _.current - 1 );
        }



        // loops through list elements
        this.startLoop = function() {

            _.loop = setInterval(function() {
                _.next();
            }, 3000);

        }


        // clears interval that controls looping
        _.stopLoop = function() {
            if(typeof _.loop !== undefined) clearInterval(_.loop);
        }




        this.init();

        return this;

        /// TO DO (IN ORDER OF PRIORITY) 14/05/2014 :
        /// CREATE HOVER EVENTS TO START/STOP LOOPING ON HOVER IN/HOVER OUT
        /// ADD ABILITY TO PASS OPTIONS (SPEED, ETC)

    };

}( jQuery ));