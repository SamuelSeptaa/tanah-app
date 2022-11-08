$(document).ready(function (e) {
	$(".edit-forms").submit(function (e) {
		e.preventDefault();
		const formData = new FormData(this);
		$.ajax({
			type: "post",
			url: base_url + "pemilik/ajaxEdit",
			data: formData,
			contentType: false,
			processData: false,
			beforeSend: function () {
				showLoading();
			},
			complete: function () {
				hideLoading();
			},
			success: function (response) {
				Swal.fire({
					confirmButtonColor: "#3ab50d",
					icon: "success",
					title: `${response.message.title}`,
				}).then((result) => {
					document.location.href = base_url + "pemilik";
				});
			},
			error: function (jqXHR, textStatus, errorThrown) {
				const response = jqXHR.responseJSON;
				response.data.forEach(function ({ field, message }, index) {
					$(`.invalid-feedback[for="${field}"]`).html(message);
					$(`#${field}`).addClass("is-invalid");
				});
				$(window).scrollTop(
					$(`#${response.data[0]["field"]}`).parent().offset().top
				);
			},
		});
	});

	$(".edit-forms")
		.find("input, select, textarea")
		.on("input change", function (e) {
			$(this).removeClass("is-invalid");
		});
});
