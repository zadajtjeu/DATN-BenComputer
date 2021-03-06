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
    });

    /** add active class and stay opened when selected */
    var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('.sidebar ul.nav-sidebar a').filter(function() {
        return (this.href == url || url.href.indexOf(this.href) == 0) && !this.href.includes("#");
    }).addClass('active');
    // for treeview
    $('.sidebar ul.nav-treeview a').filter(function() {
        return (this.href == url || url.href.indexOf(this.href) == 0) && !this.href.includes("#");
    }).parentsUntil(".nav-sidebar > .nav-treeview").addClass('menu-open').prev('a').addClass('active');
});

window.change_alias = function(alias) {
    var str = alias;
    str= str.toLowerCase();
    str= str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g,"a");
    str= str.replace(/??|??|???|???|???|??|???|???|???|???|???/g,"e");
    str= str.replace(/??|??|???|???|??/g,"i");
    str= str.replace(/??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???/g,"o");
    str= str.replace(/??|??|???|???|??|??|???|???|???|???|???/g,"u");
    str= str.replace(/???|??|???|???|???/g,"y");
    str= str.replace(/??/g,"d");
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
    /* t??m v?? thay th??? c??c k?? t??? ?????c bi???t trong chu???i sang k?? t??? - */
    str = str.replace(/\-\-\-\-\-/gi, '-');
    str = str.replace(/\-\-\-\-/gi, '-');
    str = str.replace(/\-\-\-/gi, '-');
    str = str.replace(/\-\-/gi, '-');
    str= str.replace(/-+-/g,"-"); //thay th??? 2- th??nh 1-
    str= str.replace(/^\-+|\-+$/g,"");
    //c???t b??? k?? t??? - ??? ?????u v?? cu???i chu???i
    return str;
}
