$('body').on('click', '.sm-sub > a', function(e) {
    e.preventDefault();
    let x = $(this).closest('.sm-sub');
    x.find('ul').slideToggle(200);
    x.toggleClass('toggled');
});


$(document).ready(function () {
    //SEO
    var seo_title = 'Tiêu đề seo website không vượt quá 70 kí tự (tốt nhất từ 60-70 kí tự)';
    var seo_description = 'Miêu tả seo website không vượt quá 155 kí tự (tốt nhất từ 100-155 kí tự). Là những đoạn mô tả ngắn gọn về website, bài viết...';

    var $title = $('#title');
    var $slug = $('#slug');
    var $seo_title = $('#seo_title');
    var $seo_description = $('#seo_description');

    var flag_slug = $slug.val() ? false : true;
    var flag_seo_title = $seo_title.val() ? false : true;

    $title.keyup(function () {
        var value = $(this).val();
        if (!$slug.val()) {
            flag_slug = true;
        }
        if (flag_slug) {
            var slug = createUrl(value);
            $('#slug').val(slug);
            $('.slug').html(slug);
        }
        if (flag_seo_title) {
            $('#seo_title').html(value);
        }
        return false;
    });
    $seo_title.keyup(function () {
        var value = $(this).val();
        $('.title').html(value);
        return false;
    });
    $seo_description.keyup(function () {
        var value = $(this).val();
        if (value == '') {
            $('.seo_description').html(seo_description);
            return false;
        }
        $('.seo_description').html(value);
        return false;
    });

});

function _ajax(url, method, data) {
    $.ajax({
        type: method,
        url: url,
        data: data,
        success: function (response) {
            if (response.redirect) {
                setTimeout(function () {
                    window.location.href = response.redirect;
                }, 1500);
            } else if (response.reload) {
                setTimeout(function () {
                    location.reload();
                }, 1500);
            }else if (response.datatable) {
                return DataTableCallback();
            } else {
                notifyAjax(response);
            }
        }
    });
}

$(document).on('click', '.btn-action-delete-element', function () {
    let data = $(this).data();
    let action = $(this).attr('action');
    data._token = _token;
    swal({
            title: "Bạn có chắc xóa?",
            text: "Bạn sẽ không khôi phục được dữ liệu này!",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Hủy",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Đồng ý",
            closeOnConfirm: true
        },
        function () {
            _ajax(action, 'DELETE', data)
        });
});


(function ($) {

    $.fn.filemanager = function () {

        this.on('click', function (e) {
            let target_input = $(this).data('input');
            let $target_input = $('#' + target_input);
            console.log($target_input);
            let target_preview = $(this).data('preview');
            let $target_preview = $('#' + target_preview);

            CKFinder.popup({
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function (finder) {
                    finder.on('files:choose', function (evt) {
                        let file = evt.data.files.first();
                        let data = file.getUrl();
                        console.log($target_input.val(data).trigger('change'));
                        $target_input.val(data).trigger('change');
                        $target_preview.attr('src', data).trigger('change');
                    });
                    finder.on('file:choose:resizedImage', function (evt) {
                        var output = document.getElementById(elementId);
                        output.value = evt.data.resizedUrl;
                    });
                }
            });

            return false;
        });
    }

})(jQuery);

$('.filemanager_single').filemanager();


