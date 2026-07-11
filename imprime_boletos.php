<?php
//Inicio la sesion 
session_start();

include("gp/conexion.php");
include("funciones.php");

require('gp/libs/fpdf/fpdf.php');

//LIBRERIA QR
include ("gp/libs/phpqrcode/qrlib.php"); 
//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
//html PNG location prefix
$PNG_WEB_DIR = 'temp/';

$ResCarrito=mysqli_query($conn, "SELECT * FROM carrito WHERE id='".$_GET["id"]."' ORDER BY id ASC");
$RResCar=mysqli_fetch_array($ResCarrito);

$ResEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE Id='".$RResCar["idevento"]."' LIMIT 1"));
$ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE Id='".$RResCar["iduser"]."' LIMIT 1"));
$ResLugar=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM lugar_eventos WHERE Id='".$ResEvento["LugarEvento"]."' LIMIT 1"));

//genera codigo QR
$filename = $PNG_TEMP_DIR.'A_'.$ResAco["Id"].'.png';
QRcode::png('?re='.$RResCar["Id"], $filename, 'H', '4', 2);

//crear el nuevo archivo pdf
$pdf=new FPDF();

//desabilitar el corte automatico de pagina
$pdf->SetAutoPageBreak(false);

//Agregamos la primer pagina
$pdf->AddPage('P', 'Letter');

//logo 
$pdf->Image('images/logotlatoani.jpg',8,8,40);

//nombre del evento
$pdf->SetFillColor(000,000,000);
$pdf->SetFont('Arial','B',15);
$pdf->SetTextColor(251,10,122);
$pdf->SetY(13);
$pdf->SetX(50);
$pdf->Cell(122,4,utf8_decode($ResEvento["NombreEvento"]),0,0,'L',0);
//fecha
$pdf->SetFont('Arial','',15);
$pdf->SetTextColor(251,10,122);
$pdf->SetY(19);
$pdf->SetX(50);
$pdf->Cell(122,4,fecha_evento($ResEvento["FechaEvento"]),0,0,'L',0);
//
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(25);
$pdf->SetX(50);
$pdf->Cell(122,4,'Gracias por hacer tu compra en ticketstlatoani.xyz, agradecemos tu confianza.',0,0,'L',0);
//foto del evento
$pdf->Image('gp/eventos/images/eventos/'.$ResEvento["Imagen"],8,40,100);
//usuario
$pdf->Image('images/user_icon.png',120,40,6);
//
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(42);
$pdf->SetX(128);
$pdf->Cell(122,4,'Nombre: ',0,0,'L',0);
//
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(48);
$pdf->SetX(128);
$pdf->Cell(122,4,utf8_decode($ResUsuario["Nombre"].' '.$ResUsuario["Apellido"]),0,0,'L',0);
//lugar
$pdf->Image('images/map_icon.png',120,56,6);
//
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(58);
$pdf->SetX(128);
$pdf->Cell(122,4,'Lugar: ',0,0,'L',0);
//
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(64);
$pdf->SetX(128);
$pdf->Cell(122,4,utf8_decode($ResLugar["Nombre"]),0,0,'L',0);
//
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(96,96,96);
$pdf->SetY(68);
$pdf->SetX(128);
$pdf->MultiCell(80,4,utf8_decode($ResLugar["Direccion"]),0,'L',0);
//
$y_axis=$pdf->GetY()+4;
//Fecha
$pdf->Image('images/calendar_icon.png',120,$y_axis,6);
//
$y_axis=$y_axis+2;
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(128);
$pdf->Cell(122,4,'Fecha: ',0,0,'L',0);
//
$y_axis=$y_axis+6;
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(128);
$pdf->MultiCell(80,4,fecha($ResEvento["FechaEvento"]),0,'L',0);
//
$y_axis=$pdf->GetY()+6;
//horario
$pdf->Image('images/clock_icon.png',120,$y_axis,6);
//
$y_axis=$y_axis+2;
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(128);
$pdf->Cell(122,4,'Horario: ',0,0,'L',0);
//
$y_axis=$y_axis+6;
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY($y_axis);
$pdf->SetX(128);
$pdf->MultiCell(80,4,hora_evento($ResEvento["FechaEvento"]),0,'L',0);
//
//Descripcion del Boleto
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(120);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('Descripción del boleto'),0,0,'L',0);
//
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(126);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- Este boleto es válido en la fecha y hora del evento.'),0,0,'L',0);
//
$pdf->SetY(132);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- Este boleto es una constancia de compra y ES CANJEABLE'),0,0,'L',0);
//
$pdf->SetY(138);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('  por el boleto de acceso  en la taquilla del Teatro.'),0,0,'L',0);
//
$pdf->SetY(144);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('  30 minutos antes.'),0,0,'L',0);
//
$pdf->SetY(158);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- Cupo MUY LIMITADO.'),0,0,'L',0);
//
$pdf->SetY(164);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- Venta en línea o en taquilla.'),0,0,'L',0);
//
$pdf->SetY(170);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- PROHIBIDO ACCESO con alimentos y/o bebidas.'),0,0,'L',0);
//
$pdf->SetY(176);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- No hay servicio de Guardarropa.'),0,0,'L',0);
//
$pdf->SetY(182);
$pdf->SetX(115);
$pdf->Cell(122,4,utf8_decode('- LLegar con 20 min antes.'),0,0,'L',0);
//
//total de la compra
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(200);
$pdf->SetX(128);
$pdf->Cell(40,4,utf8_decode('Total de la compra: '),0,0,'L',0);
//
$pdf->SetFont('Arial','',12);
$pdf->SetY(200);
$pdf->SetX(168);
$pdf->Cell(40,4,'$ '.number_format(($RResCar["total"]),2),0,0,'R',0);
//
//persona
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(210);
$pdf->SetX(70);
$pdf->Cell(50,4,utf8_decode('Numero de personas: '),0,0,'L',0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,4,$RResCar["numboletos"],0,0,'L',0);
//
//id de compra
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(218);
$pdf->SetX(70);
$pdf->Cell(30,4,utf8_decode('ID de compra: '),0,0,'L',0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,4,$RResCar["idtransaccion"],0,0,'L',0);
//
//folio del boleto
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(000,000,000);
$pdf->SetY(226);
$pdf->SetX(70);
$pdf->Cell(35,4,utf8_decode('Folio del boleto: '),0,0,'L',0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(50,4,'E'.$ResEvento["Id"].'C'.$RResCar["id"],0,0,'L',0);
//
$pdf->Image('images/enviroment_icon.jpg',70,235,10);
//
$pdf->SetTextColor(000,000,000);
$pdf->SetY(235);
$pdf->SetX(80);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(100,4,utf8_decode('Recuerda llevar el boleto digital y en caso de llevar varios boletos en la compra, tendrá que presentarlos todos en las entradas oficiales del evento.'),0,'J',0);

//
//aviso de privacidad
$pdf->SetFont('Arial','',6);
$pdf->SetTextColor(96,96,96);
$pdf->SetY(260);
$pdf->SetX(8);
$pdf->MultiCell(200,4,utf8_decode('Tickets Tlatoani es una plataforma de venta y distribución de boletos de diversos tipos de eventos. Para realizar el trámite de reembolso de un boleto, el cliente se deberá poner en contacto con Mas Tlatoani al mail mastlatoani@hotmail.com o WP 5522979647.  Una vez hecha la compra, no se realizará cambios, re embolsos, reposiciones ni cancelaciones. Para tener acceso al evento, es indispensable presentar el boleto digital IMPRESO y una identificación oficial. Consulta nuestro aviso de privacidad. https://www.mastlatoani.com.mx/aviso-de-privacidad Tickets Tlatoani es una plataforma operada por Mas Tlatoani. No se reembolsará en caso de Cancelación por parte del cliente o por indicación de cierre por parte de las autoridades.'),0,'J',0);


//codigo QR
$pdf->Image($PNG_WEB_DIR.basename($filename),8,200,60);


//Envio Archivo
$pdf->Output();