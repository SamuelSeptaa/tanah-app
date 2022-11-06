$(window).on("load", function () {
	$(".lds-circle").fadeOut("slow");
});

function showLoading() {
	$(".lds-circle").show();
}
function hideLoading() {
	$(".lds-circle").hide();
}

function debounce(func, wait, immediate) {
	var timeout;
	return function () {
		var context = this,
			args = arguments;
		var later = function () {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
}
