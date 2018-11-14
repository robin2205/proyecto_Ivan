// Validamos que venga la variable capturaRango en el localStorage
if(localStorage.getItem("capturaRango3")!=null){
	$("#daterange-btn3 span").html(localStorage.getItem("capturaRango3"));}
else{
	$("#daterange-btn3 span").html('<i class="fa fa-calendar"></i> Rango de Fecha ');}

// Rango de fechas (Date Range)
$("#daterange-btn3").daterangepicker({
	ranges:{
		'Hoy':[moment(),moment()],
		'Ayer':[moment().subtract(1,'days'),moment().subtract(1,'days')],
		'Últimos 7 días':[moment().subtract(6,'days'),moment()],
		'Últimos 30 días':[moment().subtract(29,'days'),moment()],
		'Este mes':[moment().startOf('month'),moment().endOf('month')],
		'Último mes':[moment().subtract(1,'month').startOf('month'),moment().subtract(1,'month').endOf('month')]
	},
	startDate:moment(),
	endDate:moment()
},
function(start,end){
	$("#daterange-btn3 span").html(start.format('MMMM DD, YYYY')+' - '+end.format('MMMM DD, YYYY'));
	// Capturamos la fecha inicial y final con el formato de la BD
	var fechaInicial=start.format('YYYY-MM-DD');
	var fechaFinal=end.format('YYYY-MM-DD');
	// Capturamos el rango que se genera
	var capturaRango3=$("#daterange-btn3 span").html();
	// Guardamos el rango en una variable del localStorage
	localStorage.setItem("capturaRango3",capturaRango3);
	// Recargamos la página
	window.location="index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
});

// Acción al cancelar el rango de Fechas
$(".daterangepicker.opensright .range_inputs .cancelBtn").on("click",function(){
	// Limpiamos la variable capturaRango3 y el localStorage
	localStorage.removeItem("capturaRango3");
	localStorage.clear();
	// Redireccionamos a la página de ventas
	window.location="reportes";
});

// Capturar hoy
$(".daterangepicker.opensright .ranges li").on("click",function(){
	var hoy=$(this).attr("data-range-key");
	if(hoy=="Hoy"){
		// Capturamos el día de hoy
		var fecha=new Date();
		var dia=fecha.getDate();
		dia=optimizar(dia);
		var mes=fecha.getMonth()+1;
		mes=optimizar(mes);
		var year=fecha.getFullYear();
		var fechaInicial=year+"-"+mes+"-"+dia;
		var fechaFinal=year+"-"+mes+"-"+dia;
		$("#daterange-btn3 span").html("Hoy");
		// Guardamos el rango en una variable del localStorage
		localStorage.setItem("capturaRango3","Hoy");
		// Recargamos la tabla con la información para ser mostrada en la tabla
		window.location="index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
	}
});
function optimizar(dato){
	if(dato<10){
		dato='0'+dato;}
	return dato;
}