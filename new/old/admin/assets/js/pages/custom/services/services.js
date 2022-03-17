var KTFormControls = function () {
    var _formEl;
    // Private functions
    var _initDemo1 = function () {
        FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    servicesname: {
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
                    sorttext: {
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
                    detail:{
                        notEmpty: {
                            message: 'Bu alan boş bırakılamaz'
                        },
                        stringLength: {
                            min: 100,
                            message: 'Minimum 100 Karakter Girmelisiniz'
                        },
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    submitButton: new FormValidation.plugins.SubmitButton({}),
                },
            }
        )
            .on('core.form.valid', function () {
                var formdata = $("#services_form").serialize();
                $.ajax({
                    type: "POST",
                    url: "processing",
                    data: formdata+'&servicesAdd=true',
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
                    },
                    complete:function(){
                        KTApp.unblockPage();
                    }

                });

            })
    }

    return {
        // public functions
        init: function () {
            _formEl = KTUtil.getById('services_form');
            _initDemo1();
        }
    };
}();
jQuery(document).ready(function () {
    KTFormControls.init();
});