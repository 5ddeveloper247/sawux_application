//  icon rotate
$(document).ready(function () {
    $(".main-links-for-submenu").on("click", function () {
        $(this)
            .find(".dropdown-indicator-icon-wrapper")
            .toggleClass("rotate-90");
    });

    $(".nav-link").on("click", function () {
        $(".nav-link-text").css("color", "");

        $(this).find(".nav-link-text").css("color", "#3874ff");
    });
});

//  dropdown mouse event none
$(document).ready(function () {
    $(".crm").hover(
        function () {
            $(".crm-dropdown").css("opacity", "1");
            $(".mail, .landing").addClass("disabled");
        },
        function () {
            $(".crm-dropdown").css("opacity", "0");
            $(".mail, .landing").removeClass("disabled");
        }
    );

    $(".mail").hover(
        function () {
            $(".mail-dropdown").css("opacity", "1");
            $(".crm, .landing").addClass("disabled");
        },
        function () {
            $(".mail-dropdown").css("opacity", "0");
            $(".crm, .landing").removeClass("disabled");
        }
    );

    $(".landing").hover(
        function () {
            $(".landing-dropdown").css("opacity", "1");
            $(".crm, .mail").addClass("disabled");
        },
        function () {
            $(".landing-dropdown").css("opacity", "0");
            $(".crm, .mail").removeClass("disabled");
        }
    );
});