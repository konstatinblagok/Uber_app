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

    const table = $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${BASE_URL}/employees`,
        dom: "lBfrtip",
        buttons: [
            { extend: "print", className: "btn-success"},
            { extend: "pdf" },
            { extend: "excel" },
            { extend: "csv" },
        ],
        columns: [
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'name', name: 'fst_name',},
            {data: 'id', name: 'id'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'hourly_rate', name: 'hourly_rate'},
            {data: 'is_active', name: 'is_active'},
            {data: 'address', name: 'address'},
        ]
    });

    const docsTable = $('#documents-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${BASE_URL}/employees/documents?emp_id=${$('#empId').val()}`,
        dom: "frtip",
        columns: [
            {data:'action', name: 'action', orderable: false, searchable: false,},
            {data: 'name', name: 'name',},
            {data: 'type', name: 'type'},
            {data: 'created_at', name: 'created_at'},
            {data: 'is_approved', name: 'is_approved'},
        ]
    });
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.DataTable.init();
}(window.jQuery);
