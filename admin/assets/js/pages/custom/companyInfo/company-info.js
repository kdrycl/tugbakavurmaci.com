var KTFormControls = function () {
  var _formEl;
  // Private functions
  var _initDemo1 = function () {
    FormValidation.formValidation(
      _formEl,
      {
        fields: {
          companyName: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                min: 3,
                max: 400,
                message: 'Minimum 3 Maksimum 400 Karakter Girebilirsiniz'
              },
            }
          },
          phone1: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                min: 10,
                max: 11,
                message: 'Başında 0 olmadan 10 karakter olarak giriniz'
              },
            }
          },
          phone2: {
            validators: {
              stringLength: {
                min: 10,
                max: 11,
                message: 'Başında 0 olmadan 10 karakter olarak giriniz'
              },
            }
          },
          phone3: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                min: 10,
                max: 11,
                message: 'Başında 0 olmadan 10 karakter olarak giriniz'
              },
            }
          },
          facebook: {
            validators: {
              stringLength: {
                min: 3,
                max: 255,
                message: 'Minimum 3 Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          instagram: {
            validators: {
              stringLength: {
                min: 3,
                max: 255,
                message: 'Minimum 3 Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          twitter: {
            validators: {
              stringLength: {
                min: 3,
                max: 255,
                message: 'Minimum 3 Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          mail1: {
            validators: {
              stringLength: {
                min: 3,
                max: 255,
                message: 'Minimum 3 Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          mail2: {
            validators: {
              stringLength: {
                min: 3,
                max: 255,
                message: 'Minimum 3 Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          adress: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                min: 3,
                max: 400,
                message: 'Minimum 3 Maksimum 400 Karakter Girebilirsiniz'
              },
            }
          },
          mapCode: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              }
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
        var formdata = $("#companyForm").serialize();
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
      _formEl = KTUtil.getById('companyForm');
      _initDemo1();
    }
  };
}();
jQuery(document).ready(function () {
  KTFormControls.init();
});