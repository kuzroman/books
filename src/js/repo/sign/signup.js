var $form = $('.js-signup-form');
// var $submit = $form.find('.js-signup-submit');
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
            submit();
        }
    });

}

function submit() {
    signUp().done(function (data) {
        // console.log(data);
        $warningText.html(data.text);
        $warning.removeClass('hidden');

        if (data.error === 0) {
            // todo регистрация пользователя
        }
    });
}

function signUp() {
    return $.ajax({
        url: '/php/ajax/signup.php',
        data: $form.serialize(),
        dataType: 'json',
        error: function (err) {
            console.error('error', err);
        }
    });
}