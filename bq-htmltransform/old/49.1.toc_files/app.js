/**
 *  18/09/2014.
 */

var ArticleLinker = {};

/* Module QA Tool */
ArticleLinker.QATool = (function() {

    /* Dependencies */
    var $j = jQuery.noConflict();

    /* Events */
    $j(document).on("keydown", function(event) {
        if (event.ctrlKey && event.which == 81) {
            $j('#qatool').modal();
        }
    });

    /* Private vars */
    var logs = {};

    /* Private Methods*/
    var stringify = function(o) {
        var str = '';
        for (var p in o) { if (o.hasOwnProperty(p)) { str += '<b>'+p+'</b>: '+o[p]+'<br />'; } }
        return str;
    };

    /* Public Methods*/
    return {
        log: function(service, log) {

            if (log instanceof Object) { log = stringify(log); }
            if (logs === undefined) { logs = {}; }
            logs[service] = [];
            logs[service].push({log: log, created_at: new Date().toISOString()});
            var rows = "";
            $j.each(logs[service].reverse(), function (index, element) {
                rows+="<tr><td>"+element.log+"</td></tr>";
            });
            $j("#qatool-body-table").html(rows);
        },
        show: function() { $j('#qatool').modal(); }
    };

})();