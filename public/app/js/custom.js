// to get current year
function getYear() {
	var currentDate = new Date();
	var currentYear = currentDate.getFullYear();
	document.querySelector("#displayYear").innerHTML = currentYear;
}
getYear();

// nav menu
function openNav() {
	document.getElementById("myNav").classList.toggle("menu_width");
	document.querySelector(".custom_menu-btn").classList.toggle("menu_btn-style");
}

function showLoading() {
	$(".lds-circle").show();
}
function hideLoading() {
	$(".lds-circle").hide();
}

const rupiah = (number) => {
	return new Intl.NumberFormat("id-ID", {
		minimumFractionDigits: 0,
		style: "currency",
		currency: "IDR",
	}).format(number);
};

$(document).ready(function (e) {
	let tipe_status = null;
	function LoadData() {
		return new Promise((resolve, reject) => {
			$.ajax({
				type: "post",
				url: `${base_url}index/koordinat`,
				data: {
					tipe_status: tipe_status,
				},
				processData: true,
				beforeSend: function () {
					showLoading();
				},
				success: function (response) {
					const geojson = response.data.geojson;
					resolve(geojson);
				},
				error: function (jqXHR, textStatus, errorThrown) {
					resolve("Get Data Is Failed!");
				},
			});
		});
	}

	function clusterTheMap(geojson) {
		return new Promise((resolve, reject) => {
			mapboxgl.accessToken =
				"pk.eyJ1Ijoic2FtdWVsc2VwdGEiLCJhIjoiY2t6czJvYTkwMzliODJ1cGFhaThpMGs4NCJ9.OsDTB6dWDaNla3EJTNpThQ";
			const map = new mapboxgl.Map({
				container: "map",
				style: "mapbox://styles/mapbox/satellite-streets-v11",
				center: [113.9108, -2.2136],
				zoom: 12,
			});
			map.addControl(
				new mapboxgl.GeolocateControl({
					positionOptions: {
						enableHighAccuracy: true,
					},
					trackUserLocation: true,
					showUserHeading: true,
				})
			);
			map.addControl(new mapboxgl.NavigationControl());
			map.on("load", () => {
				map.loadImage(
					`${base_url}public/app/images/marker.png`,
					(error, image) => {
						if (error) throw error;
						map.addImage("custom-marker", image);
					}
				);

				// if (map.getLayer("clusters")) {
				// 	map.removeLayer("clusters");
				// }

				// if (map.getLayer("cluster-count")) {
				// 	map.removeLayer("cluster-count");
				// }

				// if (map.getLayer("unclustered-point")) {
				// 	map.removeLayer("unclustered-point");
				// }

				// if (map.getSource("clustering_coords")) {
				// 	map.removeSource("clustering_coords");
				// }

				map.addSource("clustering_coords", {
					type: "geojson",
					data: geojson,
					cluster: true,
					clusterMaxZoom: 14, // Max zoom to cluster points on
					clusterRadius: 50, // Radius of each cluster when clustering points (defaults to 50)
				});
				map.addLayer({
					id: "clusters",
					type: "circle",
					source: "clustering_coords",
					filter: ["has", "point_count"],
					paint: {
						"circle-color": [
							"step",
							["get", "point_count"],
							"#51bbd6",
							100,
							"#f1f075",
							750,
							"#f28cb1",
						],
						"circle-radius": [
							"step",
							["get", "point_count"],
							20,
							100,
							30,
							750,
							40,
						],
					},
				});

				map.addLayer({
					id: "cluster-count",
					type: "symbol",
					source: "clustering_coords",
					filter: ["has", "point_count"],
					layout: {
						"text-field": "{point_count_abbreviated}",
						"text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
						"text-size": 12,
					},
				});

				map.addLayer({
					id: "unclustered-point",
					type: "symbol",
					source: "clustering_coords",
					filter: ["!", ["has", "point_count"]],
					layout: {
						"icon-anchor": "bottom",
						"icon-image": "custom-marker",
					},
				});

				// zoom/inspect cluster on click
				map.on("click", "clusters", (e) => {
					const features = map.queryRenderedFeatures(e.point, {
						layers: ["clusters"],
					});
					const clusterId = features[0].properties.cluster_id;
					map
						.getSource("clustering_coords")
						.getClusterExpansionZoom(clusterId, (err, zoom) => {
							if (err) return;

							map.easeTo({
								center: features[0].geometry.coordinates,
								zoom: zoom,
							});
						});
				});

				// description HTML from its properties.
				map.on("click", "unclustered-point", (e) => {
					const coordinates = e.features[0].geometry.coordinates.slice();
					const nama = e.features[0].properties.nama;
					const panjang = e.features[0].properties.panjang;
					const lebar = e.features[0].properties.lebar;
					const anggaran = e.features[0].properties.anggaran;
					const status_type = e.features[0].properties.status_type;
					while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
						coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
					}
					new mapboxgl.Popup()
						.setLngLat(coordinates)
						.setHTML(
							`<table>
						<tr>
							<td>Panjang</td>
							<td>:${panjang}m</td>
						</tr>
						<tr>
							<td>Panjang</td>
							<td>:${lebar}m</td>
						</tr>
						<tr>
							<td>Pemilik</td>
							<td>:${nama}</td>
						</tr>
						<tr>
							<td>Anggaran</td>
							<td>:${rupiah(anggaran)}</td>
						</tr>
						<tr>
							<td>Status</td>
							<td>:${status_type}</td>
						</tr>
				  		</table>`
						)
						.addTo(map);
				});

				map.on("mouseenter", "clusters", () => {
					map.getCanvas().style.cursor = "pointer";
				});
				map.on("mouseleave", "clusters", () => {
					map.getCanvas().style.cursor = "";
				});
			});

			resolve("Clusterin is done");
		});
	}

	function loadMapWithData() {
		LoadData()
			.then((geojson) => {
				return clusterTheMap(geojson);
			})
			.then((value) => {
				hideLoading();
			});
	}
	loadMapWithData();

	$(".btn-filter").click(function (e) {
		e.preventDefault();
		tipe_status = $(this).data("status");
		$(".btn-filter").removeClass("active");
		$(`button[data-status="${tipe_status}"]`).addClass("active");

		loadMapWithData();
	});
});
