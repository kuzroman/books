var $openSubMenu = $('.js-topline-open-submenu');
var $subMenu = $('.js-topline-submenu');

init();

function init() {
    bindEvents();
}

function bindEvents() {

    $openSubMenu.on('mouseenter', function (e) {
        $(this).next().show();
    });
    $subMenu.on('mouseleave', function (e) {
        $(this).hide();
    });

    $('body').on('click', function () {
        $subMenu.hide();
    });
}
