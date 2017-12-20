// run all time
var $contentCenter = $('.js-content-center');
var hp = require("./helper.js");

// lazy load by page

// load by page
var tmplOneBook = require("../../tmpl/oneBook.twig");
var tmplItem = require("../../tmpl/item.twig");

init();

function init() {
    bindEvents();
    updateContentByPage();
}

function bindEvents() {

    window.onhashchange = function () {
        // console.log('onhashchange');
        updateContentByPage();
    };
}

function updateContentByPage() {
    var page = getPageByUrl(), def, tmpl;
    if (page === 'index') {
        def = getBooksWithDesc();
        tmpl = tmplOneBook;
    } else if (page === 'elementary' || page === 'pre-intermediate' || page === 'intermediate' ||
        page === 'upper-intermediate' || page === 'advanced') {
        def = getBooks(page);
        tmpl = tmplItem;
    } else if (page === 'book') {
        def = getBooksWithDesc({limit: 1});
        tmpl = tmplOneBook;
    } else if (page === 'author') {
        def = getBooksWithDesc({author: getAuthorByUrl()});
        tmpl = tmplOneBook;
    }

    if (def) {
        def.done(function (list) {
            // console.log(list);
            var html = hp.twig({data: tmpl({books: list})});
            $contentCenter.html(html);
        });
    }
}

function getPageByUrl() {
    var page = '';

    if (location.pathname === '/' && location.hash === '') {
        page = 'index';
    } else if (location.hash.match(/level/)) {
        var hash = location.hash.replace('#!/level/', '');
        if (hash) {
            page = hash;
        }
    } else if (location.hash.match(/book/)) {
        page = 'book';
    } else if (location.hash.match(/author/)) {
        page = 'author';
    }
    console.log('page', page);
    return page;
}

function getAuthorByUrl() {
    var arr = location.hash.split('/');
    return arr[arr.length - 1];
}

function getBooksWithDesc(data) {
    var innerData = data || {};
    // todo добавить прелоадер
    return $.ajax({
        url: '/php/ajax/getBooksWithDesc.php',
        data: innerData,
        dataType: 'json',
        error: function (err) {
            console.error('error', err);
        }
    });
}

function getBooks(level) {
    // todo добавить прелоадер
    return $.ajax({
        url: '/php/ajax/getBooks.php',
        data: {level: level},
        dataType: 'json',
        error: function (err) {
            console.error('error', err);
        }
    });
}

// изменить значение если оно отлично от прошлого
// function changeWithCheck(name, val) {
//     var isEqual = false;
//     var self = changeWithCheck;
//     if (!self[name]) {
//         self[name] = val;
//         return isEqual
//     }
//     isEqual = self[name] === val;
//     self[name] = val;
//     return isEqual;
// }