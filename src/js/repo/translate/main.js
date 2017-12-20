$(".js-clicable").on('dblclick', function () {
    var sel = (document.selection && document.selection.createRange().text) ||
        (window.getSelection && window.getSelection().toString());
    console.log(sel);
});

// $(".js-clicable").on('click', function() {
//     var s = window.getSelection();
//     var range = s.getRangeAt(0);
//     var node = s.anchorNode;
//     while (range.toString().indexOf(' ') !== 0) {
//         range.setStart(node, (range.startOffset - 1));
//     }
//     range.setStart(node, range.startOffset + 1);
//     do {
//         range.setEnd(node, range.endOffset + 1);
//
//     } while (range.toString().indexOf(' ') === -1 && range.toString().trim() !== '' && range.endOffset < node.length);
//     var str = range.toString().trim();
//     console.log(str);
// });
