<?php
require('../../fpdf/fpdf.php');
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);
session_start();
$conexion=conexion();

class PDF extends FPDF
{
	// Cabecera de página
	function Header()
	{
			$responsable=$_SESSION['usuario'];
			$fecha_inicio=$_POST['fecha_desde'];
			$fecha_fin=$_POST['fecha_hasta'];
			$nombre=$_SESSION['nombre'];
			$apellido=$_SESSION['apellido'];
			//$actividad=$_GET['id_actividad'];
			
			//Lineas rojas del header
			$this->SetDrawColor(194,52,55);
			$this->SetLineWidth(0.5);
			$this->Line(10,6,205,6);
			
			// Logo
			$this->Image('../../img/logopdvsa.png',15,10,45);
			// Arial bold 12
			$this->SetFont('Arial','B',12);
			// Movernos a la derecha
			$this->Cell(40);
			// Título
			
			$titulo_uno=iconv('UTF-8','windows-1252','Resúmen de Actividades Control de Activos AIT Junín');
			$this->Cell(150,5,$titulo_uno,0,5,'R');
			$this->SetFont('Arial','',10);
			$this->Cell(150,5,'Desde: '.saber_dia($fecha_inicio).' '.formatear_fecha($fecha_inicio).', Hasta: '.saber_dia($fecha_fin).' '.formatear_fecha($fecha_fin),0,5,'R');
			$this->Cell(150,5,'Responsable: '.$nombre.' '.$apellido.' - '.$responsable,0,5,'R');
			
			$this->Line(10,28,205,28);
		
			// Salto de línea
			$this->Ln(12);
	}

	// Pie de página
	function Footer()
	{
		// Posición: a 1,5 cm del final
		$this->SetY(-12);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Número de página
		
		$this->Cell(0,10,iconv('UTF-8', 'windows-1252','Página ').$this->PageNo().'/{nb}',0,0,'C');
	}
	
	
	var $widths;
	var $aligns;
	
	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}
	
	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}
	
	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			/*$this->Rect($x,$y,$w,$h); BORRAR!*/
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			$this->AddPage($this->CurOrientation);
	}
	
	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}

}

//$str = iconv('UTF-8', 'windows-1252','Actividad ');
// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','Letter');
$pdf->SetAutoPageBreak(true,40);
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->SetTopMargin(15);

$responsable=$_SESSION['usuario'];
$fecha_desde=$_POST['fecha_desde'];
$fecha_hasta=$_POST['fecha_hasta'];
$check_actividades=$_POST['check_actividades'];
$check_pendientes=$_POST['check_pendientes'];
$check_asignaciones=$_POST['check_asignaciones'];

if($check_actividades==1)
{
	$select_act_usu="SELECT * FROM actividades WHERE responsable='".$responsable."' AND fecha_actividad>='".$fecha_desde."' AND fecha_actividad<='".$fecha_hasta."' ORDER BY responsable_correlativo ASC";
	$query_act=query($select_act_usu,$conexion);
	$num_rows=num_rows($query_act);
	
	/****ACTIVIDADES*****/
	$pdf->SetFont('Arial','BU',14);
	$titulo_uno=iconv('UTF-8', 'windows-1252','Actividades:');
	$pdf->Cell(0,5,$titulo_uno,0,1,'L');
	$pdf->Ln(5);
	
	if($num_rows>0)
	{
		$b=1;
		while($result=fetch_array($query_act))
		{
			$str1 = iconv('UTF-8', 'windows-1252',$result['resumen']);
			$str2 = iconv('UTF-8', 'windows-1252',$result['detalle']);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(0,7,$b.'.- '.$str1.'.',0,1);
			$pdf->Cell(6);
			$pdf->SetFont('Times','',12);
			$pdf->MultiCell(0,7,$str2,'','J');
			$pdf->Ln(3);
			$b=$b+1; /*****CONTADOR WHILE****/
			
			$select_soporte="SELECT nombre_archivo FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$result['responsable_correlativo']."'";
			$query_soporte=query($select_soporte,$conexion);
			$num_sop=num_rows($query_soporte);
			
			if($num_sop>0)
			{
				unset($arreglo);
				while($result_sop=fetch_array($query_soporte))
				{
					$arreglo[]=$result_sop['nombre_archivo'];
				}
				
				$array=array_chunk($arreglo, 3);
				$i=0;
				
				while($i<count($array))
				{
					switch (count($array[$i]))
						{
							case 3:
								$pdf->SetWidths(array(60,60,60));
								$pdf->Cell(8);
								$pdf->Row(array($pdf->
								Image("../actividades/soportes/".$responsable."/".$array[$i][0], $pdf->GetX(), $pdf->GetY(), 59,59,"","http://".$_SERVER['HTTP_HOST']."/cdajunin/sistema/actividades/soportes/".$responsable."/".$array[$i][0]),$pdf->Image("../actividades/soportes/".$responsable."/".$array[$i][1], $pdf->GetX()+60, $pdf->GetY(), 59,59,"","http://".$_SERVER['HTTP_HOST']."/cdajunin/sistema/actividades/soportes/".$responsable."/".$array[$i][1]),$pdf->Image("../actividades/soportes/".$responsable."/".$array[$i][2], $pdf->GetX()+120, $pdf->GetY(), 59,59,"","http://".$_SERVER['HTTP_HOST']."/cdajunin/sistema/actividades/soportes/".$responsable."/".$array[$i][2])));
								$pdf->Ln(60);
								break;
							case 2:
								$pdf->SetWidths(array(60,60));
								$pdf->Cell(8);
								$pdf->Row(array($pdf->Image("../actividades/soportes/".$responsable."/".$array[$i][0], $pdf->GetX(), $pdf->GetY(), 59,59,"","http://".$_SERVER['HTTP_HOST']."/cdajunin/sistema/actividades/soportes/".$responsable."/".$array[$i][0]),$pdf->Image("../actividades/soportes/".$responsable."/".$array[$i][1], $pdf->GetX()+60, $pdf->GetY(), 59,59,"","http://".$_SERVER['HTTP_HOST']."/cdajunin/sistema/actividades/soportes/".$responsable."/".$array[$i][1])));
								$pdf->Ln(60);
								break;
							case 1:
								$pdf->SetWidths(array(60));
								$pdf->Cell(8);
								$pdf->Row(array($pdf->Image("../actividades/soportes/".$responsable."/".$array[$i][0], $pdf->GetX(), $pdf->GetY(), 59,59,"","http://".$_SERVER['HTTP_HOST']."/cdajunin/sistema/actividades/soportes/".$responsable."/".$array[$i][0])));
								$pdf->Ln(60);
								break;
						}
					$i+=1;
				}
				
				/*for($i=0;$i<count($array);$i++)
				{
					if(count($array[$i])==1)
					{
						$pdf->SetWidths(array(60));
						$pdf->Cell(8);
						$pdf->Row(array($pdf->Image("soportes/".$responsable."/".$array[$i][0], $pdf->GetX(), $pdf->GetY(), 59,59)));
						$pdf->Ln(60);
					}
					
					elseif(count($array[$i])==2)
					{
						$pdf->SetWidths(array(60,60));
						$pdf->Cell(8);
						$pdf->Row(array($pdf->Image("soportes/".$responsable."/".$array[$i][0], $pdf->GetX(), $pdf->GetY(), 59,59),$pdf->Image("soportes/".$responsable."/".$array[$i][1], $pdf->GetX()+60, $pdf->GetY(), 59,59)));
						$pdf->Ln(60);
					}
					else
					{
						$pdf->SetWidths(array(60,60,60));
						$pdf->Cell(8);
						$pdf->Row(array($pdf->Image("soportes/".$responsable."/".$array[$i][0], $pdf->GetX(), $pdf->GetY(), 59,59),$pdf->Image("soportes/".$responsable."/".$array[$i][1], $pdf->GetX()+60, $pdf->GetY(), 59,59),$pdf->Image("soportes/".$responsable."/".$array[$i][2], $pdf->GetX()+120, $pdf->GetY(), 59,59)));
						$pdf->Ln(60);
					}
				}*/
			
			}
		}
	}
	else
	{
		$pdf->Cell(6);
		$pdf->SetFont('Times','I',12);
		$pdf->Cell(0,7,'***Sin Actividades Registradas***',0,1);
		$pdf->Ln(3);
	}
}

/****PENDIENTES*****/
if($check_pendientes==1)
{
	$pdf->Ln(5);
	$pdf->SetFont('Arial','BU',14);
	$titulo_uno=iconv('UTF-8', 'windows-1252','Pendientes:');
	$pdf->Cell(0,5,$titulo_uno,0,1,'L');
	$pdf->Ln(5);
	
	$select_pend="SELECT * FROM pendientes WHERE estado!='CERRADO' ORDER BY id ASC";
	$query_pend=query($select_pend,$conexion);
	$num_pend=num_rows($query_pend);
	
	if($num_pend>0)
	{
		$b=1;
		while($result_pend=fetch_array($query_pend))
		{
			$str1 = iconv('UTF-8', 'windows-1252',$result_pend['resumen']);
			$str2 = iconv('UTF-8', 'windows-1252',$result_pend['detalle']);
			$pdf->SetFont('Times','B',12);
			$pdf->Cell(0,7,$b.'.- '.$str1.'.',0,1);
			$pdf->Cell(6);
			$pdf->SetFont('Times','',12);
			$pdf->MultiCell(0,7,$str2,'','J');
			$pdf->Ln(3);
			$b=$b+1; /*****CONTADOR WHILE****/
			
			$select_notas="SELECT * FROM pendientes_notas WHERE id_pendiente='".$result_pend['id']."' ORDER BY id ASC";
			$query_notas=query($select_notas,$conexion);
			$num_notas=num_rows($query_notas);
			
			if($num_notas>0)
			{
				$cont=1;
				$pdf->Cell(6);
				$pdf->SetFont('Times','BIU',8);
				$pdf->Cell(0,7,'NOTAS:',0,1);
				$pdf->SetFont('Times','',8);
				$pdf->Ln(2);
				while($result_notas=fetch_array($query_notas))
				{
					$pdf->Cell(10);
					$str2 = iconv('UTF-8', 'windows-1252',$result_notas['detalle']);
					$pdf->MultiCell(0,7,'> '.formatear_fecha($result_notas['fecha']).' - '.$result_notas['usuario'].': '.$str2,'','J');
					$pdf->Ln(1);
					$cont+=1;
				}
				$pdf->Ln(3);
			}
		}
	}
	else
	{
		$pdf->Cell(6);
		$pdf->SetFont('Times','I',12);
		$pdf->Cell(0,7,'***Sin Pendientes Registrados***',0,1);
		$pdf->Ln(3);
	}
}

$pdf->Output();
?>