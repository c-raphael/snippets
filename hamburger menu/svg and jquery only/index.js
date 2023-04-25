jQuery(document).ready(function($) {
    let animate = document.getElementById("ham").querySelectorAll("animate");

    $('#ham').click(function() {
        if ($('#ham').hasClass("inactive")) {
            animate.forEach((value, key) => {
                if (value.classList.value == 'move-active') {
                    value.beginElement();
                }
            });

            $('#ham').removeClass("inactive");
        } else {
            animate.forEach((value, key) => {
                if (value.classList.value == 'move-inactive') {
                    value.beginElement();
                }
            });

            $('#ham').addClass("inactive");
        }
    });
});