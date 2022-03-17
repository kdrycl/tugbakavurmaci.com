var KTFormControls = function () {
  var _formEl;
  // Private functions
  var _initDemo1 = function () {
    FormValidation.formValidation(
      _formEl,
      {
        fields: {
          categoryName: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                min: 3,
                max: 100,
                message: 'Minimum 3 Maksimum 100 Karakter Girebilirsiniz'
              },
            }
          },
          categoryDescription: {
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
                max: 60,
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
        var formdata = $("#category_form").serialize();
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
                window.location = "https://" + window.location.hostname + "/admin/kategori-detay-" + data[2] + "-TR";
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
      _formEl = KTUtil.getById('category_form');
      _initDemo1();
    }
  };
}();
jQuery(document).ready(function () {
  KTFormControls.init();
});