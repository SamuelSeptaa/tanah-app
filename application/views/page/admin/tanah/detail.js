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

generateMarker(longitude, latitude);
