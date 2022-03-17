"use strict";
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

// Initialization
jQuery(document).ready(function () {
	KTSummernoteDemo.init();
});
// Class definition
var KTProjectsAdd = function () {
	// Base elements
	var _wizardEl;
	var _formEl;
	var _wizard;
	var _avatar;
	var _validations = [];

	// Private functions
	var initWizard = function () {
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
						text: "Lütfen Bilgileri Eksiksiz Bir Şekilde Doldurun",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Anladım!",
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

	// Form Validation
	var initValidation = function () {
		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		// Step 1
		_validations.push(FormValidation.formValidation(
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
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 2
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
					// Step 2
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
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
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
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 4
		_validations.push(FormValidation.formValidation(
			_formEl,
			{
				fields: {
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
								max: 25,
								message: 'Minimum 3 Maksimum 250 Karakter Girebilirsiniz'
							},
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()

				},
			}
		));
	}

	var initAvatar = function () {
		_avatar = new KTImageInput('kt_projects_add_avatar');
	}

	return {
		// public functions
		init: function () {
			_wizardEl = KTUtil.getById('kt_projects_add');
			_formEl = KTUtil.getById('kt_projects_add_form');

			initWizard();
			initValidation();
			initAvatar();
		}
	};
}();

jQuery(document).ready(function () {
	KTProjectsAdd.init();
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

$(document).on('click', '#submit', function () {
	var formdata = $("#kt_projects_add_form").serialize();
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
					//$(location).attr('href', 'etkinlikleri-listele');
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


