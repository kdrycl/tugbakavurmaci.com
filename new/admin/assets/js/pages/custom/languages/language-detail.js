var KTFormControls = function () {
  var _formEl;
  var _formEl2;

  // Private functions
  var _initDemo1 = function () {
    FormValidation.formValidation(
      _formEl,
      {
        fields: {
          langName: {
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
          categorySlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          tagSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          pageSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          blogSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          productSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          searchSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
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
        var formdata = $("#language_form").serialize();
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
                window.location = "https://" + window.location.hostname + "/admin/dil-bilgileri-" + data[2];
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

  var _initDemo2 = function () {
    FormValidation.formValidation(
      _formEl2,
      {
        fields: {
          langName: {
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
          categorySlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          tagSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          pageSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          blogSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          productSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
              },
            }
          },
          searchSlug: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                max: 255,
                message: 'Maksimum 255 Karakter Girebilirsiniz'
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
        let data = new FormData();
        let newdata = $("#constant_form").serializeArray();
        let degiskenler = new Array();
        $.each(newdata, function (index, value) {
          degiskenler.push({ name: value.name, value: value.value });
        });
        var lang = $("#langConstUpdate").val();
        data.append('degiskenler', JSON.stringify(degiskenler));
        data.append('langConstUpdate', lang);
        // var formdata = $("#constant_form").serialize();
        $.ajax({
          type: "POST",
          url: "processing",
          data: data,
          processData: false,
          contentType: false,
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
      _formEl = KTUtil.getById('language_form');
      _formEl2 = KTUtil.getById('constant_form');

      _initDemo1();
      _initDemo2();
    }
  };
}();
jQuery(document).ready(function () {
  KTFormControls.init();
});
