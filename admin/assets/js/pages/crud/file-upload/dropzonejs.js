"use strict";
// Class definition

var KTDropzoneDemo = function () {
    // Private functions
    var demo1 = function () {
        var langCode = $("#langCode").val();

        // single file upload
        $('#productDesktop').dropzone({
            url: "processing?deviceType=0&imageType=2&langCode=" + langCode, // Set the url for your upload script location
            paramName: "imageUpload", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 2, // MB
            addRemoveLinks: true,
        });

        $('#blogDesktop').dropzone({
            url: "processing?deviceType=0&imageType=3", // Set the url for your upload script location
            paramName: "imageUpload", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 2, // MB
            addRemoveLinks: true,
        });

        $('#productGallery').dropzone({
            url: "processing?deviceType=0&imageType=4", // Set the url for your upload script location
            paramName: "imageUpload", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 2, // MB
            addRemoveLinks: true,
        });

        $('#pageDesktop').dropzone({
            url: "processing?deviceType=0&imageType=7", // Set the url for your upload script location
            paramName: "imageUpload", // The name that will be used to transfer the file
            maxFiles: 1,
            maxFilesize: 2, // MB
            addRemoveLinks: true,
        });

        $('#categoryDesktop').dropzone({
            url: "processing?deviceType=0&imageType=5", // Set the url for your upload script location
            paramName: "imageUpload", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 2, // MB
            addRemoveLinks: true,
        });

    }

    return {
        // public functions
        init: function () {
            demo1();
        }
    };
}();

KTUtil.ready(function () {
    KTDropzoneDemo.init();
});

$(document).on("click", ".imageDelete", function () {
    var imageId = $(this).data('id');
    Swal.fire({
        title: "Emin misiniz?",
        text: "Görsel silindikten sonra geri getirilemez. Silmek istediğinize emin misiniz?",
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
                    data: {
                        "imageDelete": true,
                        "imageId": imageId
                    },
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
                                location.reload();
                            }, 300);
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


$(document).on('click', '.imageSave', function () {
    var id = $(this).data("id");
    var lang = $(this).data("lang");
    $.ajax({
        type: "POST",
        url: "processing",
        data: {
            "imageSave": true,
            "id": id,
            "lang": lang
        },
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
                }, 300);
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
});