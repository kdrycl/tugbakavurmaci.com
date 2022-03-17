"use strict";

// Class Definition
var KTAddUser = function () {
	// Private Variables
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _avatar;
	var _validations = [];

	// Private Functions
	var _initWizard = function () {
		// Initialize form wizard
		_wizard = new KTWizard(_wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: true  // allow step clicking
		});

		// Validation before going to next page
		_wizard.on('beforeNext', function (wizard) {
			_validations[wizard.getStep() - 1].validate().then(function (status) {
				if (status == 'Valid') {
					_wizard.goNext();
					KTUtil.scrollTop();
				} else {
					Swal.fire({
						text: "Lütfen Bilgileri Eksiksiz Olarak Giriniz!",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Anladım",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light"
						}
					}).then(function () {
						KTUtil.scrollTop();
					});
				}
			});

			_wizard.stop();  // Don't go to the next step
		});

		// Change Event
		_wizard.on('change', function (wizard) {
			KTUtil.scrollTop();
		});
	}

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
					identificationNumber: {
						validators: {
							stringLength: {
								min: 11,
								max: 11,
								message: 'Lütfen 11 Karakter Giriniz'
							},
							digits: {
								message: 'Lütfen Sadece Rakam Giriniz'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// Step 2
					password: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							}
						}
					},
					option: {
						validators: {
							notEmpty: {
								message: 'Lütfen Boş Bırakmayınız'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
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
					phoneNumber: {
						validators: {
							phone: {
								country: 'TR',
								message: 'Lütfen Geçerli Bir Telefon Numarası Giriniz'
							},
							stringLength: {
								min: 10,
								max: 10,
								message: 'Lütfen Başında 0 olmadan 10 Karakter Olarak Giriniz'
							},
							digits: {
								message: 'Lütfen Sadece Rakam Giriniz'
							}
						}
					},
					city: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							}
						}
					},
					district: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							}
						}
					},
					phone: {
						validators: {
							notEmpty: {
								message: 'Bu Alan Boş Bırakılamaz'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));
	}

	var _initAvatar = function () {
		_avatar = new KTImageInput('kt_user_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_wizard');
			_formEl = KTUtil.getById('kt_form');

			_initWizard();
			_initValidations();
			_initAvatar();
		}
	};
}();

jQuery(document).ready(function () {
	KTAddUser.init();
});
$(document).on('click', '#submit', function () {
	var formdata = $("#kt_form").serialize();
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
var KTDropzoneDemo = function () {
	// Private functions
	var demo1 = function () {
		// single file upload
		$('#userImage').dropzone({
			url: "processing?deviceType=0&imageType=2", // Set the url for your upload script location
			paramName: "imageUpload", // The name that will be used to transfer the file
			maxFiles: 1,
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