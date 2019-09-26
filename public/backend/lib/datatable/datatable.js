let DataTableClass = function () {
    this.table = null;
    this.element = null;

    this.init = function (table, columns, option) {
        this.element = $(table);
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            serverSide: true,
            processing: true,
            // dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            ordering: false,
            language: {
                search: '<span>Tìm</span> _INPUT_',
                searchPlaceholder: 'Nhập từ khóa...',
                lengthMenu: '<span>Hiển thị</span> _MENU_',
                //sInfo: 'Hiện _START_ - _END_ trong _TOTAL_ mục',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': '&rarr;',
                    'previous': '&larr;',
                },
                sEmptyTable: 'Chưa có dữ liệu trong bảng',
                sInfo: 'Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_',
                sProcessing: 'Đang tải dữ liệu ...',
                sInfoEmpty: ''
            }
        });
        let option_default = {
            ajax: this.element.attr('action'),
            columns: columns,
            fnInitComplete: function (oSettings, json) {
            },
            fnDrawCallback: function () {
                $('.dataTables_paginate > .pagination > li').addClass('page-item');
                $('.dataTables_paginate > .pagination > li > a').addClass('page-link');
            }
        };
        $.extend(option_default, option);
        $.fn.dataTableExt.sErrMode = 'throw'
        this.table = this.element.DataTable(option_default);
    };

    this.reload = function () {
        this.table.ajax.reload(null, false);
    };

    this.showDeleteButton = function (action) {
        return '<a class="btn btn-danger btn-action btn-action-delete-element" action="' + action + '" title="Xóa"><i class="fa fa-trash" aria-hidden="true"></i></a>'
    };
    this.showViewButton = function (url) {
        return '<a class="btn btn-info btn-action" target="_blank" href="' + url + '" title="Xem trên web"><i class="fa fa-external-link" aria-hidden="true"></i></a>'
    };
    this.showCopyButton = function (url) {
        return '<a class="btn btn-warning btn-action" href="' + url + '" title="Copy"><i class="fa fa-files-o" aria-hidden="true"></i></a>'
    };
    this.showActiveButton = function (data) {
        return '<a class="btn ' + (data.active ? 'btn-success' : 'btn-default') + ' btn-action btn-action-active" action="' + data.route_update_field + '" data-active="' + (data.active ? 0 : 1) + '" title="' + (data.active ? 'Ẩn' : 'Hiện') + '"><i class="fa fa-' + (data.active ? 'eye' : 'eye-slash') + '" aria-hidden="true"></i></a>'
    };
    this.showReadButton = function (data) {
        return '<a class="btn ' + (data.read ? 'btn-success' : 'btn-default') + ' btn-action btn-action-read" action="' + data.route_update + '" data-read="' + (data.read ? 0 : 1) + '" title="' + (data.read ? 'Đã đọc' : 'Chưa đọc') + '"><i class="fa fa-' + (data.read ? 'eye' : 'eye-slash') + '" aria-hidden="true"></i></a>'
    };
    this.showThumb = function (value) {
        return '<image src="' + value + '" width="150">';
    };

    this.showMove = function (data) {
        return '<a href="' + data.move_top + '" class="move text-default" onclick="return false;"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>' +
            '<a href="' + data.move_up + '" class="move text-default" onclick="return false;"><i class="fa fa-angle-up" aria-hidden="true"></i></a>' +
            '<a href="' + data.move_down + '" class="move text-default" onclick="return false;"><i class="fa fa-angle-down" aria-hidden="true"></i></a>' +
            '<a href="' + data.move_bottom + '" class="move text-default" onclick="return false;"><i class="fa fa-angle-double-down" aria-hidden="true"></i></a>'
    };

    return this;
};
