var $form = $('.js-sign-in-form');
var $warning = $('.js-signup-warning');
var $warningText = $warning.find('.js-signup-warning-text');

init();

function init() {
    bindEvents();
    $form.parsley();
}

function bindEvents() {

    $form.on('submit', function (e) {
        e.preventDefault();
        $form.parsley().validate();
        if ($form.parsley().isValid()) {
            submit().done(function () {
                console.log('verification');
            });
        }
    });
}

function submit() {
    return sign().done(function (data) {
        // console.log(data);
        $warningText.html(data.text);
        $warning.removeClass('hidden');

        if (data.error === 0) {
            // todo регистрация пользователя
        }
    });
}

function sign() {
    return $.ajax({
        url: '/php/ajax/sign/sign_in.php',
        data: $form.serialize(),
        dataType: 'json',
        error: function (err) {
            console.error('error', err);
        }
    });
}