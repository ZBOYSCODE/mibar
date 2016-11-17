var arg = {
    resultFunction: function(result) {
        $('body').append($('<li>' + result.format + ': ' + result.code + '</li>'));
    }
};
$("canvas").WebCodeCamJQuery(arg).data().plugin_WebCodeCamJQuery.play();