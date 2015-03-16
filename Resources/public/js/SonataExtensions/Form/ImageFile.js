SonataExtensions.Form.ImageFile = {
    validator: /jpg|jpeg|png/i,
    onLoad: function () {
        this.bindAll();
    },
    bindAll: function () {
        $('body').on('change', '.se-type-image-file input[type=file]', function (e) {
            var container = $(this).closest('.se-type-image-file');
            if (SonataExtensions.Form.ImageFile.isFileAPISupported) {
                var files = e.target.files;
                if (files[0].type.match(SonataExtensions.Form.ImageFile.validator)) {
                    var file = files[0];
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        container.find('.thumbnail img').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('You can select only images!');
                }
            }
        });
    },
    isFileAPISupported: function () {
        return (window.File && window.FileReader && window.FileList && window.Blob);
    }
};