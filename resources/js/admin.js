$(document).ready(function() {
    //upload image
    (function( $ ) {
        $.fn.attachmentUploader = function() {
            const uploadControl = $(this).find('.js-form-upload-control');
            const btnClear = $(this).find('.btn-clear');
            $(uploadControl).on('change', function(e) {
                const preview = $(this).closest('.form-upload').children('.form-upload__preview');
                const files   = e.target.files;

                function previewUpload(file) {
                    if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
                        var reader = new FileReader();
                        reader.addEventListener('load', function () {
                            const html =
                                '<div class=\"form-upload__item col-2 align-self-center\">' +
                                    '<div class=\"form-upload__close\">x</div>' +
                                    '<img class="img-fluid mb-2 form-upload__item-thumbnail" src="' + this.result + '">' +
                                '</div>';
                            preview.html( html );
                            btnClear.addClass('d-block').removeClass('d-none');
                        }, false);
                        reader.readAsDataURL(file);
                    } else {
                        alert('Please upload image only');
                        uploadControl.val('');
                    }
                }

            [].forEach.call(files, previewUpload);

            btnClear.on('click', function() {
                $('.form-upload__item').remove();
                uploadControl.val('');
                $(this).addClass('d-none').removeClass('d-block');
            })
          })
        }

    })( jQuery )

    $('.form-upload').attachmentUploader();

    $('.form-upload__preview').on('click', '.form-upload__close', function() {
        $(this).closest('.form-upload__item').remove();
        if ($('.form-upload__preview').find('.form-upload__item').length == 0) {
            $('.btn-clear').addClass('d-none').removeClass('d-block');
        }
    })
});

window.change_alias = function(alias) {
    var str = alias;
    str= str.toLowerCase();
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ợ|ở|ỡ|ớ/g,"o");
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
    str= str.replace(/đ/g,"d");
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
    /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
    str = str.replace(/\-\-\-\-\-/gi, '-');
    str = str.replace(/\-\-\-\-/gi, '-');
    str = str.replace(/\-\-\-/gi, '-');
    str = str.replace(/\-\-/gi, '-');
    str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
    str= str.replace(/^\-+|\-+$/g,"");
    //cắt bỏ ký tự - ở đầu và cuối chuỗi
    return str;
}
