
$(document).ready(function () {
  $.ajax({
    type: "POST",
    url: "processing",
    data: { "activityList": true },
    success: function (data) {
      $("#activityDiv").html(data);
    }

  });
  return false;
});
$(document).on("click", ".paging", function () {
  $("a.active").removeClass("active");
  var pageNumber = $(this).data("number");
  $(this).addClass("active");
  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "activityList": true,
      "pageNumber": pageNumber
    },
    beforeSend: function () {
      KTApp.blockPage();
    },
    success: function (data) {
      setTimeout(function () {
        KTApp.unblockPage();
      }, 200);
      $("#activityDiv").html(data);
    }

  });
  return false;
});
$(document).on("click", "#activitySearch", function () {
  var searchTerm = $("#activitySearchInput").val();
  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "activityList": true,
      "searchTerm": searchTerm
    },
    beforeSend: function () {
      KTApp.blockPage();
    },
    success: function (data) {
      setTimeout(function () {
        KTApp.unblockPage();
      }, 200);
      $("#activityDiv").html(data);
    }

  });
  return false;
});
var KTDropzoneDemo = function () {
  // Private functions
  var demo1 = function () {
    // single file upload
    $('#activityDesktop').dropzone({
      url: "processing?deviceType=0", // Set the url for your upload script location
      paramName: "imageUpload", // The name that will be used to transfer the file
      maxFiles: 3,
      maxFilesize: 2, // MB
      addRemoveLinks: true,
      accept: function (file, done) {
        if (file.name == "justinbieber.jpg") {
          done("Naha, you don't.");
        } else {
          done();
        }
      }
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
$(document).on("click", ".activityDelete", function () {
  var dataId = $(this).data("id");
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
          dataType: "JSON",
          data: { "activityDelete": dataId },
          beforeSend: function () {
            KTApp.blockPage();
          },

          success: function (data) {
            setTimeout(function () {
              KTApp.unblockPage();
            }, 300);
            if (data[0] == "success") {
              Swal.fire({
                icon: data[0],
                title: data[1],
                showConfirmButton: false,
                timer: 1500,
              }).then(function () {
                location.reload();
              }, 300);
            }
            else {
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
      }
      else if (result.dismiss === "cancel") {
        Swal.fire(
          "İptal Edildi",
          "Silme İşlemi İptal Edildi",
          "error"
        )
      }
    });

});

