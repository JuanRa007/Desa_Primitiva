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
		loader = document.getElementById('loader');

	var txtfecha = dia + '/' + mes + '/' + ano;
	var txtimporte = 100;

	var mensa_fecha =
		"<div class='row'><div class='col-sm-6'><div class='mt-5'><div class='alert alert-success text-center' role='alert'>Sorteo: <span class='badge'>" +
		txtfecha +
		'</span></div></div></div>';
	var mensa_importe =
		"<div class='col-sm-6'><div class='mt-5'><div class='alert alert-success text-center' role='alert'>Premio: <span class='badge'>" +
		txtimporte +
		'</span></div></div></div></div>';

	// Activamos el acceso ajax
	var peticion = new XMLHttpRequest();

	// El programa que nos devolverá los datos
	var llamada = './php/leer-datos.php?dia=' + dia + '&mes=' + mes + '&ano=' + ano;
	peticion.open('GET', './php/leer-datos.php?dia=' + dia + '&mes=' + mes + '&ano=' + ano);

	// Ponemos un cursor dando vueltas (de espera)
	loader.classList.add('active');

	// Qué hacer una vez obtenidos los datos.
	peticion.onload = function() {
		var datos = JSON.parse(peticion.responseText);

		if (datos.error) {
			console.log('Error al obtener los datos.');
		} else {
			console.log(datos);
			for (let i = 0; i < datos.length; i++) {
				console.log(datos[i]);
				var elemento = document.createElement('tr');
				elemento.innerHTML += '<td>1.-' + datos[i] + '</td>';
				/*
				elemento.innerHTML += '<td>' + datos[i].nombre + '</td>';
				elemento.innerHTML += '<td>' + datos[i].edad + '</td>';
				elemento.innerHTML += '<td>' + datos[i].pais + '</td>';
				elemento.innerHTML += '<td>' + datos[i].correo + '</td>';
 				*/
				tabla.appendChild(elemento);
			}
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
