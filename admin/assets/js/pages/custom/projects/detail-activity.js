var KTSummernoteDemo = function () {
  // Private functions
  var demos = function () {
    $('#longDescription').summernote({
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
          activityName: {
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
          activityType: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              }
            }
          },
          country: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              }
            }
          },
          city: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              }
            }
          },
          startTime: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              }
            }
          },
          endTime: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              }
            }
          },
          shortDescription: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              stringLength: {
                min: 3,
                max: 300,
                message: 'Minimum 3 Maksimum 300 Karakter Girebilirsiniz'
              },
            }
          },
          donationType: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              choice: {
                min: 1,
                max: 1,
                message: 'Lütfen sadece bir tane seçiniz'
              }
            }
          },
          unit1: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              digits: {
                message: 'Lütfen sadece sayı giriniz'
              }
            }
          },
          unit2: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              digits: {
                message: 'Lütfen sadece sayı giriniz'
              }
            }
          },
          unit3: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              digits: {
                message: 'Lütfen sadece sayı giriniz'
              }
            }
          },
          singleDonationAmount: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              digits: {
                message: 'Lütfen sadece sayı giriniz'
              }
            }
          },
          totalDonationAmount: {
            validators: {
              notEmpty: {
                message: 'Bu alan boş bırakılamaz'
              },
              digits: {
                message: 'Lütfen sadece sayı giriniz'
              }
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
        var formdata = $("#activityUpdateForm").serialize();
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
      _formEl = KTUtil.getById('activityUpdateForm');
      _initDemo1();
    }
  };
}();
jQuery(document).ready(function () {
  KTFormControls.init();
});
var KTAppsUsersListDatatable = function () {
  // Private functions

  // basic demo
  var _demo = function () {
    var uniqueId = $("#uniqueId").val();
    var datatable = $('#donorTable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: 'processing',
            headers: { 'donorsList': 'true' },
            params: {
              'uniqueId': uniqueId,
              'query': 'donorsList'
            }
          },
        },
        pageSize: 10, // display 10 records per page
      },

      // layout definition
      layout: {
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false, // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      // columns definition
      columns: [
        {
          field: 'userNumber',
          title: '#',
          sortable: 'asc',
          type: 'number',
          selector: false,
          width: 30,
          textAlign: 'left',
          template: function (data) {
            return '<span class="font-weight-bolder">' + data.userNumber + '</span>';
          }
        }, {
          field: 'name',
          title: 'Adı',
          width: 100,
          textAlign: 'center',

        }, {
          field: 'surname',
          title: 'Soyadı',
          width: 100,
          textAlign: 'center',
        }, {
          field: 'price',
          title: 'Bağış Tutarı',
          sortable: true,
          width: 115,
          textAlign: 'center',
          template: function (priceField) {
            return priceField.price + ' <b>₺</b>';
          },
        }, {
          field: 'donationType',
          title: 'Bağış Türü',
          width: 130,
          textAlign: 'center',
          template: function (result) {
            var type = {
              0: { 'title': 'Kredi Kartı', 'class': ' label-light-info' },
              1: { 'title': 'Havale/EFT', 'class': ' label-light-info' },
              2: { 'title': 'Elden Teslim', 'class': ' label-light-info' },
            };
            return '<span class="label label-lg font-weight-bold label-inline">' + type[result.donationType].title + '</span>';
          },
        }, {
          field: 'donationStatus',
          title: 'Bağış Durumu',
          sortable: true,
          width: 150,
          textAlign: 'center',
          // callback function support for column rendering
          template: function (row) {
            var status = {
              0: { 'title': 'Onaylanmadı', 'class': ' label-light-danger' },
              1: { 'title': 'Onaylandı', 'class': ' label-light-success' },
            };
            return '<span class="label label-lg font-weight-bold ' + status[row.donationStatus].class + ' label-inline">' + status[row.donationStatus].title + '</span>';
          },
        }, {
          field: 'recordType',
          title: 'Kayıt Nedeni',
          sortable: true,
          width: 110,
          textAlign: 'center',
          // callback function support for column rendering
          template: function (row) {
            var status = {
              0: { 'title': 'Bağış', 'class': ' label-light-info' },
              1: { 'title': 'İade', 'class': ' label-light-danger' },
            };
            return '<span class="label label-lg font-weight-bold ' + status[row.recordType].class + ' label-inline">' + status[row.recordType].title + '</span>';
          },
        }, {
          field: 'actions',
          title: 'İşlemler',
          sortable: false,
          width: 110,
          overflow: 'visible',
          autoHide: false,
          textAlign: 'center',
          template: function (field) {
            return '\
										<button type="button" id="donationDetailModalButton" data-toggle="modal" data-target="#donationDetailModal" data-id="' + field.actions + '" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit details">\
												<span class="svg-icon svg-icon-md">\
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
															<rect x="0" y="0" width="24" height="24"/>\
															<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>\
															<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
														</g>\
													</svg>\
												</span>\
										</a>\
								';
          },
        }],
    });

    $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
  };

  var _demo1 = function () {
    var uniqueId = $("#uniqueId").val();
    var datatables = $('#volunteerTable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: 'processing',
            headers: { 'volunteersList': 'true' },
            params: {
              'uniqueId': uniqueId
            }
          },
        },
        pageSize: 10, // display 20 records per page
      },

      // layout definition
      layout: {
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false, // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      // columns definition
      columns: [
        {
          field: 'userNumber',
          title: '#',
          sortable: 'asc',
          type: 'number',
          selector: false,
          width: 30,
          textAlign: 'left',
          template: function (data) {
            return '<span class="font-weight-bolder">' + data.userNumber + '</span>';
          }
        }, {
          field: 'name',
          title: 'Adı',
          width: 100,
          textAlign: 'center',

        }, {
          field: 'surname',
          title: 'Soyadı',
          width: 100,
          textAlign: 'center',
        }, {
          field: 'responsiblePersonal',
          title: 'Sorumlu Kişi',
          sortable: true,
          width: 115,
          textAlign: 'center',
        }, {
          field: 'volunteerStatus',
          title: 'Onay Durumu',
          sortable: true,
          width: 150,
          textAlign: 'center',
          // callback function support for column rendering
          template: function (row) {
            var status = {
              0: { 'title': 'Onaylanmadı', 'class': ' label-light-danger' },
              1: { 'title': 'Onaylandı', 'class': ' label-light-success' },
            };
            return '<span class="label label-lg font-weight-bold ' + status[row.volunteerStatus].class + ' label-inline">' + status[row.volunteerStatus].title + '</span>';
          },
        }, {
          field: 'actions',
          title: 'İşlemler',
          sortable: false,
          width: 110,
          overflow: 'visible',
          autoHide: false,
          textAlign: 'center',
          template: function (field) {
            return '\
										<button type="button" id="volunteerDetailModalButton" data-toggle="modal" data-target="#volunteerDetailModal " data-id="' + field.actions + '" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2" title="Edit details">\
												<span class="svg-icon svg-icon-md">\
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
														<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
															<rect x="0" y="0" width="24" height="24"/>\
															<path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>\
															<path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>\
														</g>\
													</svg>\
												</span>\
										</a>\
								';
          },
        }],
    });

    $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
  };

  return {
    // public functions
    init: function () {
      _demo();
      _demo1();
    },
  };
}();

jQuery(document).ready(function () {
  KTAppsUsersListDatatable.init();
});

// Class definition
var KTSelect2 = function () {
  // Private functions
  var demos = function () {
    // basic
    $('#newDonationUser').select2({
      placeholder: "Bağış Yapan Kullanıcıyı Seçin",
      width: '100%',
      allowClear: true
    });
    $('#newVolunteerUser').select2({
      placeholder: "Gönüllü Kullanıcıyı Seçin",
      width: '100%',
      allowClear: true
    });
    $('#responsiblePersonal').select2({
      placeholder: "Gönüllü Kullanıcıdan Sorumlu Kişiyi Seçin",
      width: '100%',
      allowClear: true
    });
  }
  // Public functions
  return {
    init: function () {
      demos();
    }
  };
}();

// Initialization
jQuery(document).ready(function () {
  KTSelect2.init();
});

$(document).on('click', '#addDonationButton', function () {
  var donationForm = $("#newDonationForm").serialize();
  $.ajax({
    type: "POST",
    url: "processing",
    data: donationForm,
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
          $("#newDonationModal").hide();
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

$(document).on('click', '#donationDetailModalButton', function () {
  if ($('.donationDetailModal').length > 0) {
  }

  var donationId = $(this).data("id");
  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "donationDetail": true,
      "donationId": donationId
    },
    success: function (data) {
      $('body').append(data);
      $('#donationDetailModal').modal('toggle');
      $('#donationDetailModal').modal('show');
    }

  });
});

$(document).on('click', '#volunteerDetailModalButton', function () {
  if ($('.donationDetailModal').length > 0) {
  }

  var volunteerId = $(this).data("id");
  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "volunteerDetail": true,
      "volunteerId": volunteerId
    },
    success: function (data) {
      $('body').append(data);
      $('#volunteerDetailModal').modal('show');
      $('#volunteerDetailModal').modal('toggle');
    }

  });
});

$(document).on('click', '#close', function () {
  $('#donationDetailModal').modal('hide');
  $('.donationDetailModal').remove();
  $('.modal-backdrop').remove();

});

$(document).on('change', '.paymentStatus', function () {
  var activityId = $(this).data("activity-id");
  var userId = $(this).data("user-id");
  var recordNumber = $(this).data("record-number");

  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "paymentStatusChange": true,
      "activityId": activityId,
      "userId": userId,
      "recordNumber": recordNumber
    },
    dataType: "JSON",
  });
});

$(document).on('click', '#addVolunteerButton', function () {
  var volunteerForm = $("#newVolunteerForm").serialize();
  $.ajax({
    type: "POST",
    url: "processing",
    data: volunteerForm,
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
          $("#newDonationModal").hide();
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

$(document).on('click', '.approvalStatusButton', function () {
  var volunteerId = $(this).data("id");
  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "approvalStatusChange": true,
      "volunteerId": volunteerId,
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
});

$(document).on('click', '.statusChange', function () {
  var id = $(this).data("id");
  var type = $(this).data("type");
  $.ajax({
    type: "POST",
    url: "processing",
    dataType: "json",
    data: {
      "activityStatusChange": type,
      "activityId": id
    },
    success: function (data) {
      setTimeout(function () {
        KTApp.unblockPage();
      }, 200);
      Swal.fire({
        icon: data[0],
        title: data[1],
        showConfirmButton: false,
        timer: 3500,
      }).then(function () {
        location.reload();
      }, 700);

    }

  });
});