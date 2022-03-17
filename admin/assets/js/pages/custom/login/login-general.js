"use strict";

// Class Definition
var KTLogin = function () {
	var _login;

	var _showForm = function (form) {
		var cls = 'login-' + form + '-on';
		var form = 'kt_login_' + form + '_form';

		_login.removeClass('login-signin-on');

		_login.addClass(cls);

		KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
	}

	var _handleSignInForm = function () {
		var validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_signin_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Lütfen E-Posta Adresinizi Giriniz'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Lütfen Şifrenizi Giriniz'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					submitButton: new FormValidation.plugins.SubmitButton(),
					//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#kt_login_signin_submit').on('click', function (e) {
			e.preventDefault();
			var formdata = $("#kt_login_signin_form").serialize();
			validation.validate().then(function (status) {
				$.ajax({
					type: "POST",
					url: "processing",
					data: formdata,
					dataType: "json",
					success: function (data) {
						if (data[0] == "success") {
							Swal.fire({
								icon: data[0],
								title: data[1],
								showConfirmButton: false,
								timer: 1500
							}).then(function (data) {
								if (true) {
									window.location = "anasayfa";
								}
							})
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
			});
		});
	}

	// Public Functions
	return {
		// public functions
		init: function () {
			_login = $('#kt_login');
			_handleSignInForm();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function () {
	KTLogin.init();
});
