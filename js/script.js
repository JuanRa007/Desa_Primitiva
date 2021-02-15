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
	var str_apuestas = '';
	var str_tabla = '';

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
			str_tabla = '';
			str_apuestas = '';

			datos.forEach((element) => {
				//console.log(element);

				if (verpremio) {
					// Presentamos la fecha y el premio obtenido.
					premio.innerHTML = mensa_fecha + mensa_importe + element.premio + '</span></div></div></div></div>';
					str_tabla =
						'<thead><tr><th>T</th><th>Sorteo</th><th>Fecha</th><th>Números</th><th>Reint.</th></tr></thead><tbody>';
					verpremio = false;
				}

				// var elemento = document.createElement('tr');
				// Preparamos la tabla con las apuestas.
				str_apuestas += '<tr>';

				// Icono de la apuesta
				str_apuestas +=
					'<td class="align-middle"><span class=' +
					element.icono +
					'><span class="path1"></span><span class="path2"></span>' +
					'<span class="path3"></span><span class="path4"></span><span class="path5"></span>' +
					'<span	class="path6"></span><span class="path7"></span></span></td>';

				// Título de la apuesta
				str_apuestas += '<td class="align-middle">' + element.titulo + '<br/>' + element.subtitulo + '</td>';

				// La fecha de la apuesta
				str_apuestas += '<td class="align-middle">';
				var fechas = element.fechas;
				var salto = false;
				fechas.forEach((fecha_apu) => {
					if (salto) {
						str_apuestas += '<br/>';
					}
					str_apuestas += fecha_apu;
					salto = true;
				});
				str_apuestas += '</td>';

				// Los números de la apuesta
				str_apuestas += '<td class="align-middle">';
				var numeros = element.numeros;
				var salto = false;
				numeros.forEach((number_apu) => {
					if (salto) {
						str_apuestas += '<br/>';
					}
					str_apuestas += number_apu;
					salto = true;
				});
				str_apuestas += '</td>';

				// Los reintegros de la apuesta o enlaces a las imágenes de los décimos.
				str_apuestas += '<td class="align-middle">';
				var reintegros = element.reintegros;
				var salto = false;
				reintegros.forEach((reintegro_apu) => {
					if (salto) {
						str_apuestas += '<br/>';
					}
					str_apuestas += reintegro_apu;
					salto = true;
				});
				str_apuestas += '</td>';

				// Finalizamos la tabla con las apuestas.
				str_apuestas += '</tr>';

				// Añadimos la fila a la tabla.
				// tabla.appendChild(elemento);
				// console.log(elemento);
			}); // datos.forEach

			// Finalizamos la tabla.
			str_tabla += str_apuestas + '</tbody>';
			tabla.innerHTML = str_tabla;
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
