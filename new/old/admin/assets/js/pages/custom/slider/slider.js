var KTFormControls = function () {
    var _formEl;
    // Private functions
    var _initDemo1 = function () {
        FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    text1: {
                        validators: {
                            notEmpty: {
                                message: 'Bu alan boş bırakılamaz'
                            },
                            stringLength: {
                                min: 3,
                                max: 250,
                                message: 'Minimum 3 Maksimum 250 Karakter Girebilirsiniz'
                            },
                        }
                    },
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    submitButton: new FormValidation.plugins.SubmitButton({}),
                },
            }
        )
            .on('core.form.valid', function () {
                var formdata = $("#slider_form").serialize();
                $.ajax({
                    type: "POST",
                    url: "processing",
                    data: formdata+'&sliderAdd=true',
                    dataType: "json",
                    beforeSend: function (data) {
                        KTApp.blockPage();
                    }, 
                    success: function (data) {
                        KTApp.unblockPage();
                        if (data[0] == "success") {
                            Swal.fire({
                                icon: data[0],
                                title: data[1],
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                location.reload();
                            })
                        } else {
                            Swal.fire({
                                icon: data[0],
                                title: data[1],
                                showConfirmButton: false,
                                timer: 3500
                            }).then(function () {
                            })
                        }
                    }

                });

            })
    }

    return {
        // public functions
        init: function () {
            _formEl = KTUtil.getById('slider_form');
            _initDemo1();
        }
    };
}();
jQuery(document).ready(function () {
    KTFormControls.init();
});