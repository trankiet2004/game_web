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
    
    $(".social-media-header").hover(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
    });

    $("#carouselExampleIndicators").hover(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
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
        $("#home-option-hover").slideDown("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");                
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
    });

    $("#products").delay(500).hover(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideDown("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
    });

    $("#shop").delay(500).hover(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideDown("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
    });

    $("#pages").delay(500).hover(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideDown("slow");
        $("#blogs-dropdown").slideUp("slow");
    });

    $("#blogs").delay(500).hover(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideDown("slow");
    });

    $("#home").mouseleave(function() {
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");

        $("#home-option-hover").hover(function() {
            $("#home-option-hover").show();
        });

        $("#home-option-hover").mouseleave(function() {
            $("#home-option-hover").slideUp("slow");
        });
    });

    $("#products").mouseleave(function() {
        $("#home-option-hover").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");

        $("#products-dropdown").hover(function() {
            $("#products-dropdown").show();
        });

        $("#products-dropdown").mouseleave(function() {
            $("#products-dropdown").slideUp("slow");
        });
    });

    $("#shop").mouseleave(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
        
        $("#shop-option-hover").hover(function() {
            $("#shop-option-hover").show();
        });

        $("#shop-option-hover").mouseleave(function() {
            $("#shop-option-hover").slideUp("slow");
        });
    });

    $("#pages").mouseleave(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#blogs-dropdown").slideUp("slow");
        
        $("#pages-dropdown").hover(function() {
            $("#pages-dropdown").show();
        });

        $("#pages-dropdown").mouseleave(function() {
            $("#pages-dropdown").slideUp("slow");
        });
    });

    $("#blogs").mouseleave(function() {
        $("#home-option-hover").slideUp("slow");
        $("#products-dropdown").slideUp("slow");
        $("#shop-option-hover").slideUp("slow");
        $("#pages-dropdown").slideUp("slow");
        
        $("#blogs-dropdown").hover(function() {
            $("#blogs-dropdown").show();
        });

        $("#blogs-dropdown").mouseleave(function() {
            $("#blogs-dropdown").slideUp("slow");
        });
    });

    function autoMoveAirpods() {
        $("#airpods-image").animate({
            top: "+=50px"
        }, 1000).animate({
            top: "-=50px"
        }, 1000, autoMoveAirpods);
    }

    function autoMoveHeadphones() {
        $("#headphones-image").animate({
            top: "+=50px"
        }, 1200).animate({
            top: "-=50px"
        }, 1200, autoMoveHeadphones);
    }

    autoMoveAirpods();
    autoMoveHeadphones();
})
