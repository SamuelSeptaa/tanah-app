mapboxgl.accessToken =
	"pk.eyJ1Ijoic2FtdWVsc2VwdGEiLCJhIjoiY2t6czJvYTkwMzliODJ1cGFhaThpMGs4NCJ9.OsDTB6dWDaNla3EJTNpThQ";
const map = new mapboxgl.Map({
	container: "map",
	style: "mapbox://styles/mapbox/satellite-streets-v11",
	center: [113.9108, -2.2136],
	zoom: 12,
});

map.addControl(new mapboxgl.NavigationControl());

map.on("click", (event) => {
	$(".marker").remove();
	generateMarker(event.lngLat.lng, event.lngLat.lat);
	$("#longitudes").val(event.lngLat.lng);
	$("#latitudes").val(event.lngLat.lat);
});

function generateMarker(lg, lt, offset = 15) {
	const el = document.createElement("div");
	el.className = "marker";
	el.style.backgroundSize = "100%";
	el.style.backgroundImage = `url(<?= base_url() ?>public/app/images/marker.png)`;
	new mapboxgl.Marker(el, {
		anchor: "bottom",
	})
		.setLngLat([lg, lt])
		.addTo(map);
}

$(document).ready(function (e) {
	$(".add-forms").submit(function (e) {
		e.preventDefault();
		const formData = new FormData(this);
		if (!$("#longitudes").val())
			Swal.fire({
				icon: "warning",
				title: "Perhatian",
				text: "Lokasi Belum Dipilih",
				confirmButtonColor: "#3ab50d",
			});
		else
			$.ajax({
				type: "post",
				url: base_url + "tanah/ajaxAdd",
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
						document.location.href = base_url + "tanah";
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

	$(".add-forms")
		.find("input, select, textarea")
		.on("input change", function (e) {
			$(this).removeClass("is-invalid");
		});
});
