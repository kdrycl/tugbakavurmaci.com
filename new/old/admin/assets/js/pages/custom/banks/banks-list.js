"use strict";
// Class definition

var KTAppsUsersListDatatable = function () {
  // Private functions

  // basic demo
  var _demo = function () {
    var datatable = $('#category_datatable').KTDatatable({
      // datasource definition
      data: {
        type: 'remote',
        source: {
          read: {
            url: 'processing',
            headers: { 'banksList': 'true' },
          },
        },
        pageSize: 50, // display 20 records per page
      },

      // layout definition
      layout: {
        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
        footer: false, // display/hide footer
      },

      // column sorting
      sortable: true,

      pagination: true,

      search: {
        input: $('#bankSearch'),
        delay: 400,
        key: 'generalSearch'
      },

      // columns definition
      columns: [
        {
          field: 'bankNumber',
          title: '#',
          sortable: 'asc',
          width: 40,
          type: 'number',
          selector: false,
          textAlign: 'left',
          template: function (data) {
            return '<span class="font-weight-bolder">' + data.bankNumber + '</span>';
          }
        }, {
          field: 'bankName',
          title: 'Banka Adı',
          width: 450,
        }, {
          field: 'recordStatus',
          title: 'Durumu',
          width: 100,
          // callback function support for column rendering
          template: function (row) {
            var status = {
              1: {
                'title': 'Aktif',
                'class': ' label-light-success'
              },
              0: {
                'title': 'Pasif',
                'class': ' label-light-danger'
              }
            };
            return '<span class="label label-lg font-weight-bold ' + status[row.recordStatus].class + ' label-inline">' + status[row.recordStatus].title + '</span>';
          },
        }, {
          field: 'bankAccounts',
          title: 'Hesaplar',
          template: function (field) {
            return '\
            <a href="banka-hesaplarini-listele-'+ field.bankAccounts + '" class=" font-size-sm">Hesapları Listele</a>\
            ';
          }

        }, {
          field: 'actions',
          title: 'İşlemler',
          sortable: false,
          width: 110,
          overflow: 'visible',
          autoHide: false,
          template: function (field) {
            return '\
                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2 bankUpdate" data-id="'+ field.actions + '" data-toggle="modal" data-target="#newBankModal">\
                      <span class="svg-icon svg-icon-md">\
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                          <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                            <rect x="0" y="0" width="24" height="24"/>\
                            <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero"\ transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>\
                            <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>\
                          </g>\
                        </svg>\
                      </span>\
                    </a>\
										<button type="submit" data-id="'+ field.actions + '" class="bankDelete btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon" title="Delete">\
											<span class="svg-icon svg-icon-md">\
												<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
														<rect x="0" y="0" width="24" height="24"/>\
														<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>\
														<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>\
													</g>\
												</svg>\
											</span>\
										</a>\
								';
          },
        }],
    });

    $('#kt_datatable_search_status').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'Status');
    });

    $('#kt_datatable_search_type').on('change', function () {
      datatable.search($(this).val().toLowerCase(), 'Type');
    });
    datatable.on('click', 'button.bankDelete', function () {
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
              data: "deleteBankId=" + dataId,
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
                    datatable.reload();
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

    $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
  };

  return {
    // public functions
    init: function () {
      _demo();
    },
  };
}();

jQuery(document).ready(function () {
  KTAppsUsersListDatatable.init();
});

$(document).on('click', '#bankOperationButton', function () {
  var donationForm = $("#newBankForm").serialize();
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


$(document).on('click', '.bankUpdate', function () {
  var dataId = $(this).attr("data-id");
  $.ajax({
    type: "POST",
    url: "processing",
    data: {
      "bankDetailGet": dataId,
    },
    dataType: "JSON",
    success: function (data) {
      $("#bankName").val(data[0]['bankName']);
      $("#swiftCode").val(data[0]['swiftCode']);
      $("#bankOperation").val(data[0]['id']);


    }

  });
});