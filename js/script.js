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
	// Actuamos sobre la zona con id "resultadia"
	var tabla = document.getElementById('resultadia'),
		loader = document.getElementById('loader'),
		premio = document.getElementById('premio');

	var txtfecha = dia + '/' + mes + '/' + ano;
	var verpremio = true;
	var txtimporte = 0;

	var mensa_fecha =
		"<div class='row'><div class='col-sm-6'><div class='mt-5'><div class='alert alert-success text-center' role='alert'>Sorteo: <span class='badge'>" +
		txtfecha +
		'</span></div></div></div>';
	var mensa_importe =
		"<div class='col-sm-6'><div class='mt-5'><div class='alert alert-success text-center' role='alert'>Premio: <span class='badge'>";

	// Activamos el acceso ajax
	var peticion = new XMLHttpRequest();

	// El programa que nos devolverá los datos
	peticion.open('GET', './php/leer-datos.php?dia=' + dia + '&mes=' + mes + '&ano=' + ano);

	// Ponemos un cursor dando vueltas (de espera)
	loader.classList.add('active');

	// Qué hacer una vez obtenidos los datos.
	peticion.onload = function() {
		var datos = JSON.parse(peticion.responseText);

		if (datos.error) {
			console.log('Error al obtener los datos.');
		} else {
			// Valores iniciales de la tabla.
			datos.forEach((element) => {
				//console.log(element);

				if (verpremio) {
					// Presentamos la fecha y el premio obtenido.
					premio.innerHTML = mensa_fecha + mensa_importe + element.premio + '</span></div></div></div></div>';
					tabla.innerHTML =
						"<table class='table table-sm table-bordered table-striped table-hover text-center'><thead><tr><th>T</th><th>Sorteo</th>" +
						'<th>Fecha</th><th>Números</th><th>Reint.</th></tr></thead><tbody>';
					verpremio = false;
				}

				var elemento = document.createElement('tr');
				elemento.innerHTML += '<td>' + element.tipoapu + '</td>';
				elemento.innerHTML += '<td>' + element.titulo + '</td>';
				elemento.innerHTML += '<td>' + element.subtitulo + '</td>';
				elemento.innerHTML += '<td>' + element.color + '</td>';
				elemento.innerHTML += '<td>' + element.fechas + '</td>';
				elemento.innerHTML += '<td>' + element.imagen + '</td>';
				elemento.innerHTML += '<td>' + element.icono + '</td>';
				elemento.innerHTML += '<td>' + element.numeros + '</td>';
				elemento.innerHTML += '<td>' + element.reintegros + '</td>';
				elemento.innerHTML += '<td>' + element.premio + '</td>';
				tabla.appendChild(elemento);
			});
		}
	};

	// Cuando se ha realizado el proceso correctamente.
	peticion.onreadystatechange = function() {
		if (peticion.readyState == 4 && peticion.status == 200) {
			loader.classList.remove('active');
		}
	};

	// Enviamos la petición.
	peticion.send();
}
