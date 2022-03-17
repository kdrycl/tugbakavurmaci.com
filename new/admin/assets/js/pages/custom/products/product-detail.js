var KTFormControls = function () {
    var _formEl;
    // Private functions
    var _initDemo1 = function () {
        FormValidation.formValidation(
            _formEl,
            {
                fields: {
                    productName: {
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
                    productShortDescription: {
                        validators: {
                            notEmpty: {
                                message: 'Bu alan boş bırakılamaz'
                            },
                            stringLength: {
                                min: 20,
                                max: 400,
                                message: 'Minimum 20 Maksimum 400 Karakter Girebilirsiniz'
                            },
                        }
                    },
                    seoTitle: {
                        validators: {
                            notEmpty: {
                                message: 'Bu alan boş bırakılamaz'
                            },
                            stringLength: {
                                min: 3,
                                max: 60,
                                message: 'Minimum 3 Maksimum 60 Karakter Girebilirsiniz'
                            },
                        }
                    },
                    seoKeywords: {
                        validators: {
                            stringLength: {
                                max: 400,
                                message: 'Maksimum 400 Karakter Girebilirsiniz'
                            },
                        }
                    },
                    seoDescription: {
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
                var formdata = $("#product_form").serialize();
                $.ajax({
                    type: "POST",
                    url: "processing",
                    data: formdata,
                    dataType: "json",
                    beforeSend: function (data) {
                        KTApp.blockPage();
                    },
                    success: function (data) {
                        setTimeout(function () {
                            KTApp.unblockPage();
                        }, 200);
                        if (data[0] == "success") {
                            Swal.fire({
                                icon: data[0],
                                title: data[1],
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                window.location = "https://" + window.location.hostname + "/admin/urun-detay-" + data[2] + "-TR";
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

    var modalDemos = function () {
        $('#kt_select2_modal').on('shown.bs.modal', function () {
            // multi select
            $('#kt_select2_3_modal').select2({
                placeholder: "SEO Etiketi Seçin",
            });

        });
    }

    return {
        // public functions
        init: function () {
            _formEl = KTUtil.getById('product_form');
            _initDemo1();
            modalDemos();
        }
    };
}();
jQuery(document).ready(function () {
    KTFormControls.init();
});
$(".imageDetailGet").click(function (e) {
    $("#imageUpdateId").val("");
    $("#orderNumber").val("");
    $("#title").val("");
    $("#content").text("");
    $("#hrefUrl").val("");
    var dataId = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        url: "processing",
        data: "imageDetailGet=" + dataId,
        dataType: "json",
        beforeSend: function (data) {
            KTApp.blockPage();
        },
        success: function (data) {
            setTimeout(function () {
                KTApp.unblockPage();
            }, 200);
            if (data[0] == "success") {
                $("#imageTableDiv").hide();
                if (data[1] != null) $("#imageUpdateId").val(data[1]);
                if (data[2] != null) $("#orderNumber").val(data[2]);
                if (data[3] != null) $("#title").val(data[3]);
                if (data[4] != null) $("#content").text(data[4]);
                if (data[5] != null) $("#hrefUrl").val(data[5]);
                if (data[7] == 4) {
                    if (data[6] != null) $("#imageTable").val(data[6]);
                    $("#imageTableDiv").show();
                }
                $('#imageDetailModal').modal('show');
            } else {
                alert("Hata Oluştu");
            }
        }

    });
    return false;
});

$("#imageDetailUpdateButton").click(function (e) {
    var formdata = $("#imageDetailForm").serialize();
    $.ajax({
        type: "POST",
        url: "processing",
        data: formdata,
        dataType: "json",
        beforeSend: function (data) {
            KTApp.blockPage();
        },
        success: function (data) {
            setTimeout(function () {
                KTApp.unblockPage();
            }, 200);
            if (data[0] == "success") {
                Swal.fire({
                    icon: data[0],
                    title: data[1],
                    showConfirmButton: false,
                    timer: 1500
                }).then(function () {
                    $('#imageDetailModal').modal('hide');

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
    return false;
});

$("#infoAdd").click(function (e) {
    var title = $("#infoTitle").val();
    var content = $("#infoContent").val();
    var productId = $("#productId").val();
    var productLang = $("#productLang").val();
    $.ajax({
        type: "POST",
        url: "processing",
        data: {
            title,
            content,
            productId,
            productLang,
            "infoProcess": "add"
        },
        dataType: "json",
        beforeSend: function (data) {
            KTApp.blockPage();
        },
        success: function (data) {
            setTimeout(function () {
                KTApp.unblockPage();
            }, 200);
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
    return false;
});

$(".infoUpdate").click(function (e) {
    var id = $(this).data("id");
    var infoId = $("#infoId" + id).val();
    var title = $("#infoTitle" + id).val();
    var content = $("#infoContent" + id).val();
    var productId = $("#productId" + id).val();
    var productLang = $("#productLang" + id).val();
    $.ajax({
        type: "POST",
        url: "processing",
        data: {
            "infoId": infoId,
            "title": title,
            "content": content,
            "productId": productId,
            "productLang": productLang,
            "infoProcess": "update"
        },
        dataType: "json",
        beforeSend: function (data) {
            KTApp.blockPage();
        },
        success: function (data) {
            setTimeout(function () {
                KTApp.unblockPage();
            }, 200);
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
    return false;
});

$(".infoDelete").click(function (e) {
    var dataId = $(this).attr("data-id");
    Swal.fire({
        title: "Emin misiniz?",
        text: "Bu işlem geri alınamayacaktır. Silmek istediğinize emin misiniz?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: 'Evet, Silinsin',
        cancelButtonText: "Hayır, Vazgeçtim",
        reverseButtons: true
    })
        .then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: "processing",
                    data: "deleteInfoId=" + dataId,
                    dataType: "JSON",
                    beforeSend: function (data) {
                        KTApp.blockPage();
                    },
                    success: function (data) {
                        setTimeout(function () {
                            KTApp.unblockPage();
                        }, 200);
                        if (data[0] == "success") {

                            Swal.fire({
                                icon: data[0],
                                title: data[1],
                                showConfirmButton: false,
                                timer: 1500,
                            }).then(function () {
                                $("#infoRow").load(" #infoRow");
                            });
                        } else {
                            Swal.fire({
                                icon: data[0],
                                title: data[1],
                                showConfirmButton: false,
                                timer: 3500
                            }).then(function (data) {

                            })
                        }
                    }

                });
            } else if (result.dismiss === "cancel") {
                Swal.fire(
                    "İptal Edildi",
                    "Silme İşlemi İptal Edildi",
                    "error"
                )
            }
        });

});
