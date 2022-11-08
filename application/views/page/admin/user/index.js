$(document).ready(function (e) {
	var table = $("#data-user").DataTable({
		pageLength: 30,
		scrollX: true,
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: `${base_url}user/datatable`,
			type: "POST",
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
		dom: "rtip",
	});

	table.on("processing.dt", function (e, settings, processing) {
		if (processing) {
			showLoading();
		} else {
			hideLoading();
		}
	});

	$("#search").keyup(
		debounce(function () {
			table.search(this.value).draw();
			toggleHapusFilter(isFiltered());
		}, 200)
	);
});
//? function saat button hapus pada datatable di klik. delete dengan ajax
function deleteData(id) {
	Swal.fire({
		icon: "question",
		title: "Hapus user yang dipilih?",
		showCancelButton: true,
		cancelButtonText: "Batal",
		confirmButtonText: "Hapus",
		reverseButtons: true,
	}).then((result) => {
		if (result.isConfirmed) {
			showLoading();
			$.ajax({
				type: "post",
				dataType: "json",
				url: base_url + "user/ajaxDelete",
				data: {
					id: id,
				},
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
						$("#data-user").DataTable().ajax.reload();
					});
				},
				error: function (request, status, error) {
					Swal.fire({
						confirmButtonColor: "#3ab50d",
						icon: "error",
						title: `${status}`,
						text: `${error}`,
					});
				},
			});
		}
	});
}
