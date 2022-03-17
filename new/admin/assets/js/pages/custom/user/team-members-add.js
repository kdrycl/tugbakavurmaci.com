var KTSummernoteDemo = function () {
  // Private functions
  var demos = function () {
    $('#biography').summernote({
      height: 500
    });
  }

  return {
    // public functions
    init: function () {
      demos();
    }
  };
}();
var KTFormControls = function () {
  var _formEl;
  // Private functions
  var _initDemo1 = function () {
    FormValidation.formValidation(
      _formEl,
      {
        fields: {
          name: {
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
          surname: {
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
          phone: {
            validators: {
              stringLength: {
                min: 10,
                max: 11,
                message: 'Minimum 10 Maksimum 11 Karakter Girebilirsiniz'
              },
              digits: {
                message: 'Bu alana sadece rakam girebilirsiniz.'
              }
            }
          },
          email: {
            validators: {
              emailAddress: {
                message: 'Lütfen Geçerli Bir E-Posta Adresi Girin'
              },
              stringLength: {
                min: 3,
                max: 100,
                message: 'Minimum 3 Maksimum 100 Karakter Girebilirsiniz'
              },

            }
          },
          position: {
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
          job: {
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
        var formdata = $("#teamMembersForm").serialize();
        $.ajax({
          type: "POST",
          url: "processing",
          data: formdata,
          dataType: "json",
          mimeType: "multipart/form-data",
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
                location.attr('href', 'ekip-uyelerini-listele');
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
      _formEl = KTUtil.getById('teamMembersForm');
      _initDemo1();
    }
  };
}();
jQuery(document).ready(function () {
  KTFormControls.init();
});

