/**
 * Theme: Webadmin
 * Datatable
 */

!function($) {
    "use strict";

    var DataTable = function() {
        this.$dataTableButtons = $("#datatable-buttons")
    };
    DataTable.prototype.createDataTableButtons = function() {
        0 !== this.$dataTableButtons.length && this.$dataTableButtons.DataTable({
            dom: "lBfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-success"
            }, {
                extend: "csv"
            }, {
                extend: "excel"
            }, {
                extend: "pdf"
            }, {
                extend: "print"
            }],
            responsive: !0
        });
    },
    DataTable.prototype.init = function() {
        //creating table with button
        $('#datatable-responsive').DataTable();
        this.createDataTableButtons();
    },
    //init
    $.DataTable = new DataTable, $.DataTable.Constructor = DataTable

}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.DataTable.init();
}(window.jQuery);
