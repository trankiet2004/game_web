$(document).ready(function() {
    $("#vietnamese-button").hide();
    $("#english-button").show();

    $("#vietnam").click(function() {
        $("#vietnamese-button").show();
        $("#english-button").hide();
    });

    $("#english").click(function() {
        $("#vietnamese-button").hide();
        $("#english-button").show();
    });

    $("#home-option-hover").hide();
    $("#products-dropdown").hide();
    $("#shop-option-hover").hide();
    $("#pages-dropdown").hide();
    $("#blogs-dropdown").hide();

    $("#home-option-hover").mouseleave(function() {
        $("#home-option-hover").stop(true, true).slideUp();
    });

    $("#products-dropdown").mouseleave(function() {
        $("#products-dropdown").stop(true, true).slideUp();
    });

    $("#shop-option-hover").mouseleave(function() {
        $("#shop-option-hover").stop(true, true).slideUp();
    });

    $("#pages-dropdown").mouseleave(function() {
        $("#pages-dropdown").stop(true, true).slideUp();
    });

    $("#blogs-dropdown").mouseleave(function() {
        $("#blogs-dropdown").stop(true, true).slideUp();
    });

    $("#products").on("click", function (event) {
        $("#products").removeClass("show");
    });

    $("#pages").on("click", function (event) {
        $("#pages").removeClass("show");
    });

    $("#blogs").on("click", function (event) {
        $("#blogs").removeClass("show");
    });
    
    $("#home").delay(500).hover(function() {
        $("#home-option-hover").slideDown();
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideUp();                
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideUp();
    });

    $("#products").delay(500).hover(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideDown();
        $("#shop-option-hover").slideUp();
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideUp();
    });

    $("#shop").delay(500).hover(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideDown();
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideUp();
    });

    $("#pages").delay(500).hover(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideUp();
        $("#pages-dropdown").slideDown();
        $("#blogs-dropdown").slideUp();
    });

    $("#blogs").delay(500).hover(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideUp();
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideDown();
    });

    $("#home").mouseleave(function() {
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideUp();
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideUp();

        if (!$("#home-option-hover").is(":hover")) {
            $("#home-option-hover").stop(true, false).slideUp();
        }

        $("#home-option-hover").hover(
            function() {
                $(this).stop(true, false).slideDown();
            },
            function() {
                $(this).stop(true, false).slideUp();
            }
        );
    });

    $("#products").mouseleave(function() {
        $("#home-option-hover").slideUp();
        $("#shop-option-hover").slideUp();
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideUp();

        if (!$("#products-dropdown").is(":hover")) {
            $("#products-dropdown").stop(true, false).slideUp();
        }

        $("#products-dropdown").hover(
            function() {
                $(this).stop(true, false).slideDown();
            },
            function() {
                $(this).stop(true, false).slideUp();
            }
        );
    });

    $("#shop").mouseleave(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideUp();
        $("#pages-dropdown").slideUp();
        $("#blogs-dropdown").slideUp();
        
        if (!$("#shop-option-hover").is(":hover")) {
            $("#shop-option-hover").stop(true, false).slideUp();
        }

        $("#shop-option-hover").hover(
            function() {
                $(this).stop(true, false).slideDown();
            },
            function() {
                $(this).stop(true, false).slideUp();
            }
        );
    });

    $("#pages").mouseleave(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideUp();
        $("#blogs-dropdown").slideUp();
        
        if (!$("#pages-dropdown").is(":hover")) {
            $("#pages-dropdown").stop(true, false).slideUp();
        }

        $("#pages-dropdown").hover(
            function() {
                $(this).stop(true, false).slideDown();
            },
            function() {
                $(this).stop(true, false).slideUp();
            }
        );
    });

    $("#blogs").mouseleave(function() {
        $("#home-option-hover").slideUp();
        $("#products-dropdown").slideUp();
        $("#shop-option-hover").slideUp();
        $("#pages-dropdown").slideUp();        
        
        if (!$("#blogs-dropdown").is(":hover")) {
            $("#blogs-dropdown").stop(true, false).slideUp();
        }
        
        $("#blogs-dropdown").hover(
            function() {
                $(this).stop(true, false).slideDown();
            },
            function() {
                $(this).stop(true, false).slideUp();
            }
        );
    });

    function autoMoveAirpods() {
        $("#airpods-image").animate({
            top: "+=50px"
        }, 1000).animate({
            top: "-=50px"
        }, 1000, autoMoveAirpods);
    } autoMoveAirpods();

    function autoMoveHeadphones() {
        $("#headphones-image").animate({
            top: "+=50px"
        }, 1200).animate({
            top: "-=50px"
        }, 1200, autoMoveHeadphones);
    } autoMoveHeadphones();
})