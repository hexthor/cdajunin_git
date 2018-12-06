/*
$("#btnvalidar").click(function(){
	 
		if ($("#input_usuario").val() == "") {  
			$("#input_usuario").focus();
			$("#input_usuario").parent().parent().attr("class","form-group has-error");
			//$('[data-toggle="popover"]').popover({html:true});
			alert("Ingrese el Usuario");
			return false;  
		}
		
/*		if ($("#campo_clave").val() == "id" || $("#campo_clave").val() == "cedula") {
			if (isNaN($("#busqueda").val())) 
				{
					$("#busqueda").focus();
					alert("Debe ingresar un valor numerico.");
					return false;
				}
		}
	
});*/

function mayusculas(control)
{
control.value=control.value.toUpperCase();
}  

function fecha1(){
        fecha = new Date()
        mes = fecha.getMonth()
        diaMes = fecha.getDate()
        diaSemana = fecha.getDay()
        anio = fecha.getFullYear()
        dias = new Array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','S&aacute;bado')
        meses = new Array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre')
        document.write('<span id="fecha">')
        document.write (dias[diaSemana] + ", " + diaMes + " de " + meses[mes] + " de " + anio)
        document.write ('</span>')
}

function envio_form(){
	
	if(document.getElementById('check_actividades').checked || document.getElementById('check_pendientes').checked)
	{
		document.formulario_reporte.target = "_blank";
		document.formulario_reporte.action = "reporte_pdf.php"
		document.formulario_reporte.submit();
	}
	
	if(document.getElementById('check_asignaciones').checked)
	{
		document.formulario_reporte.target = "_blank";
		document.formulario_reporte.action = "reporte_pdf_asig.php"
		document.formulario_reporte.submit();
	}
}

