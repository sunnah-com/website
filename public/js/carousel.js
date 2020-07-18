
function carouselStart() {
    $caroIt = $("#hcarousel > li").first();
    $caroIt.addClass("show");
    carouselInterval = setInterval(carouselChange, 8000);
}

function carouselChange(forward = true) {
    $caroIt.removeClass("show");
    
    if ( forward ) {
        if ( $caroIt.is(":last-child") ) {
            $caroIt = $caroIt.siblings().first();
        } else {
            $caroIt = $caroIt.next("li");
        }
    } else {
        if ( $caroIt.is(":first-child") ) {
            $caroIt = $caroIt.siblings().last();
        } else {
            $caroIt = $caroIt.prev("li");
        }
    }

    $caroIt.addClass("show");
}

jQuery(document).ready(function() {

    $(".carousel_nav").on("click", function() {

        clearInterval(carouselInterval);

        if ( $(this).hasClass("back") ) {
            carouselChange(false)
        } else {
            carouselChange(true)
        }

        carouselInterval = setInterval(carouselChange, 8000);
    
    } );
});