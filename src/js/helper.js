module.exports = (function () {

    var Twig = require('twig');

    var hp = {

        twig: function (data) {
            var preRender = Twig.twig(data);
            return preRender.render();
        }
    };

    return hp;
})();
