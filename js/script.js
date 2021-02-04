// Obtenemos el año actual.
$('#year').text(new Date().getFullYear());

// Configurar Slider
$('.carousel').carousel({
	interval: 6000,
	pause: 'hover'
});

// Configurar LightBox
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
	event.preventDefault();
	$(this).ekkoLightbox();
});

// Llamada AJAX para obtener las apuestas del día seleccionado.
function obtenerApuestasdia(dia, mes, ano) {
	console.log(dia);
	console.log(mes);
	console.log(ano);
}
