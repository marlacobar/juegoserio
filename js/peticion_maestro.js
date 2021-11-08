$(obtener_registros());

function obtener_registros(materias_impartidas)
{
	$.ajax({
		url : 'consulta_maestro.php',
		type : 'POST',
		dataType : 'html',
		data : { materias_impartidas: materias_impartidas},
		})

	.done(function(resultado){
		$("#tabla_maestro").html(resultado);
	})
}

$(document).on('keyup', '#busqueda', function()
{
	var valorBusqueda=$(this).val();
	if (valorBusqueda!="")
	{
		obtener_registros(valorBusqueda);
	}
	else
		{
			obtener_registros();
		}
});