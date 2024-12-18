var Script = function () {











//    sidebar toggle





    $(function() {

        function responsiveView() {

            var wSize = $(window).width();

            if (wSize <= 768) {

                $('#container').addClass('sidebar-close');

                $('#sidebar > ul').hide();

            }



            if (wSize > 768) {

                $('#container').removeClass('sidebar-close');

                $('#sidebar > ul').show();

            }

        }

        $(window).on('load', responsiveView);

        $(window).on('resize', responsiveView);

    });



    $('.icon-reorder').click(function () {

        if ($('#sidebar > ul').is(":visible") === true) {

            $('#main-content').css({

                'margin-left': '0px'

            });

            $('#sidebar').css({

                'margin-left': '-180px'

            });

            $('#sidebar > ul').hide();

            $("#container").addClass("sidebar-closed");

        } else {

            $('#main-content').css({

                'margin-left': '180px'

            });

            $('#sidebar > ul').show();

            $('#sidebar').css({

                'margin-left': '0'

            });

            $("#container").removeClass("sidebar-closed");

        }

    });



// custom scrollbar

    $("#sidebar").niceScroll({styler:"fb",cursorcolor:"#DC9923", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', cursorborder: ''});



    $("html").niceScroll({styler:"fb",cursorcolor:"#DC9923", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', cursorborder: '', zindex: '999999999'});



// widget tools



    jQuery('.widget .tools .icon-chevron-down').click(function () {

        var el = jQuery(this).parents(".widget").children(".widget-body");

        if (jQuery(this).hasClass("icon-chevron-down")) {

            jQuery(this).removeClass("icon-chevron-down").addClass("icon-chevron-up");

            el.slideUp(200);

        } else {

            jQuery(this).removeClass("icon-chevron-up").addClass("icon-chevron-down");

            el.slideDown(200);

        }

    });



    jQuery('.widget .tools .icon-remove').click(function () {

        jQuery(this).parents(".widget").parent().remove();

    });



//    tool tips



    $('.tooltips').tooltip();



//    popovers



    $('.popovers').popover();







// custom bar chart



    if ($(".custom-bar-chart")) {

        $(".bar").each(function () {

            var i = $(this).find(".value").html();

            $(this).find(".value").html("");

            $(this).find(".value").animate({

                height: i

            }, 2000)

        })

    }





//custom select box



//    $(function(){

//

//        $('select.styled').customSelect();

//

//    });







}();