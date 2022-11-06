$(document).ready(function (e) {
	var table = $("#data-tanah").DataTable({
		pageLength: 30,
		scrollX: true,
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: `${base_url}tanah/datatable`,
			type: "POST",
		},
		columnDefs: [
			{
				targets: [0, 5, 7, 9],
				orderable: false,
			},
			{
				render: function (data, type, full, meta) {
					return "<div class='text-wrap width-300'>" + data + "</div>";
				},
				targets: 9,
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
