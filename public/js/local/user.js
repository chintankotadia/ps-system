var _oTable;
user = {

    init: function() {
        this.eventHandler();
    },

    userDatatable: function() {
        if(jQuery().dataTable) {
            _oTable = $("#user-table").dataTable({
                "autoWidth"         : true,
                "aLengthMenu"       : [[10, 25, 50], [10, 25, 50]],
                "aoColumns"         : [{'sClass': 'text-center', "bSearchable": false, "bSortable": false, "aTargets": [ 0 ]}, null, null, null, null, {'sClass': 'text-center'}, {'sClass': 'text-center', "bSearchable": false, "bSortable": false, "aTargets": [ 0 ]}],
                "bProcessing"       : true,
                "cache"             : false,
                "bStateSave"        : false,
                "bServerSide"       : true,
                "sAjaxSource"       : $.app.urls() +"/admin/user/ajax-datatable",
                "iDisplayLength"    : 10,
                fnPreDrawCallback   : function() {
                    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
                    $('.dataTables_length select').addClass('form-control');
                },
                fnRowCallback       : function( nRow, aData, iDisplayIndex ) {
                    setTimeout(function() {
                        $('.datatable').show();
                        $('[data-toggle="tooltip"]').tooltip();
                    }, 1000);
                }
            });
        }
    },

    deleteUser: function(id) {
        if(confirm("Are you sure you want to delete")) {
            $.app.get($.app.urls()+'/admin/user/delete-user/'+id, function(response) {
                if(response.success) {
                    _oTable.fnDraw();
                }
            });
        }
    },

    eventHandler: function() {
        this.userDatatable();
        $(document).off('click', '.delete-user').on('click', '.delete-user', function(e) {
            e.preventDefault();
            user.deleteUser($(this).attr('data-rel'));
        });
    }
};

$(document).ready(user.init());