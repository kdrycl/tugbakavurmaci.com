"use strict";

var KTUpdateUser = function () {
	// Private Variables
	var _formEl;
	var _validations = [];


	var _initValidations = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/

		// Validation Rules For Step 1
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					name: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							},
							stringLength: {
								min: 3,
								max: 75,
								message: 'Lütfen Minimum 3 Maksimum 75 Karakter Giriniz'
							}
						}
					},
					surname: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							},
							stringLength: {
								min: 3,
								max: 75,
								message: 'Lütfen Minimum 3 Maksimum 75 Karakter Giriniz'
							}
						}
					},
					email: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							},
							emailAddress: {
								message: 'Lüften Geçerli Bir E-Posta Adresi Giriniz'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	return {
		// public functions
		init: function () {
			_formEl = KTUtil.getById('user_detail');

			_initValidations();
		}
	};
}();

jQuery(document).ready(function () {
	KTUpdateUser.init();
});
$(document).on('click', '#user_detail_update', function () {
	var formdata = $("#user_detail").serialize();
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
					$(location).attr('href', 'kullanicilari-listele');
				})
			}
			else {
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
$('.upperCase').keyup(function () {
	this.value = this.value.toUpperCase();
});
$('#country').on('change', function () {
	var countryId = $(this).val();
	$.ajax({
		type: "POST",
		url: "processing",
		data: { "countryId": countryId },
		success: function (data) {
			$("#city").html(data);
		}

	});
});
$(document).on('click', '.permissionCheckbox', function () {
	var permissionId = $(this).data("permission-id");
	var userId = $(this).data("user-id");
	$.ajax({
		type: "POST",
		url: "processing",
		data: {
			"permissionUpdate": true,
			"userId": userId,
			"permissionId": permissionId
		},
		success: function (data) {
		}

	});
});