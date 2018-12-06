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
			$this->Line(10,6,630,6);
			
			// Logo
			$this->Image('../../img/logopdvsa.png',15,10,45);
			// Arial bold 12
			$this->SetFont('Arial','B',12);
			// Movernos a la derecha
			$this->Cell(40);
			// Título
			
			$titulo_uno=iconv('UTF-8','windows-1252','Asignaciones Control de Activos AIT Junín');
			$this->Cell(575,5,$titulo_uno,0,5,'R');
			$this->SetFont('Arial','',10);
			$this->Cell(575,5,'Desde: '.saber_dia($fecha_inicio).' '.formatear_fecha($fecha_inicio).', Hasta: '.saber_dia($fecha_fin).' '.formatear_fecha($fecha_fin),0,5,'R');
			$this->Cell(575,5,'Responsable: '.$nombre.' '.$apellido.' - '.$responsable,0,5,'R');
			
			$this->Line(10,28,630,28);
		
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
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a/*,1*/);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}
	
	function Row_dos($data)
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
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a,1);
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

$pdf = new PDF('L','mm',array(279,640));
$pdf->SetAutoPageBreak(true,20);
$pdf->AliasNbPages();
$pdf->AddPage();

$responsable=$_SESSION['usuario'];
$fecha_desde=$_POST['fecha_desde'];
$fecha_hasta=$_POST['fecha_hasta'];

$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(194,52,55);
$pdf->SetFont('','B',11);

$pdf->SetWidths(array(180,240,200));
$pdf->SetAligns(array('C','C','C'));
$pdf->Row_dos(array("Equipos","Usuarios","Gestion"));

$pdf->SetWidths(array(10,40,25,35,20,50,25,35,35,35,60,50,25,35,25,115));
$pdf->SetAligns(array(''));
$pdf->Row_dos(array("#","Categoria","Marca","Modelo","Etiqueta","Serial","Cedula","Nombre","Apellido","Indicador","Gerencia","Ubicacion","Fecha","Estado SIGA","Caso SIGA","Observacion"));

/*CONTENIDO TABLA****************************************************************/

$pdf->setFillColor(255,255,255); 
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('','',10);

$pdf->SetWidths(array(10,40,25,35,20,50,25,35,35,35,60,50,25,35,25,115));
$pdf->SetAligns(array(''));

$select_asig="SELECT * FROM asignaciones_equipos WHERE responsable='".$responsable."' AND fecha>='".$fecha_desde."' AND fecha<='".$fecha_hasta."' ORDER BY fecha,id ASC";
$query_act=query($select_asig,$conexion);
$cuenta=num_rows($query_act);

$i=1;
while($r=fetch_array($query_act))
{
	if($r['etiqueta']=="" || $r['etiqueta']==NULL){$r['etiqueta']="---";}
	if($r['serial']=="" || $r['serial']==NULL){$r['serial']="---";}
	if($r['estadosiga']=="" || $r['estadosiga']==NULL){$r['estadosiga']="---";}
	if($r['casosiga']=="" || $r['casosiga']==NULL){$r['casosiga']="---";}
	if($r['observacion']=="" || $r['observacion']==NULL){$r['observacion']="---";}
	
	$select_usu="SELECT * FROM asignaciones_usuarios WHERE cedula='".$r['cedula']."'";
	$query_usu=query($select_usu,$conexion);
	$an=fetch_array($query_usu);
	
	/*if ($i%2==0)
	{
		$pdf->SetFillColor(230,230,230);
	}
	else
	{
		$pdf->setFillColor(255,255,255); 
	}*/
	
	$pdf->Row(array
	(
		$i,
		iconv('UTF-8', 'windows-1252',$r['categoria']),
		iconv('UTF-8', 'windows-1252',$r['marca']),
		iconv('UTF-8', 'windows-1252',$r['modelo']),
		$r['etiqueta'],
		iconv('UTF-8', 'windows-1252',$r['serial']),
		$an['cedula'],
		iconv('UTF-8', 'windows-1252',$an['nombre']),
		iconv('UTF-8', 'windows-1252',$an['apellido']),
		$an['indicador'],
		iconv('UTF-8', 'windows-1252',$an['gerencia']),
		$an['ubicacion'],
		formatear_fecha($r['fecha']),
		$r['estadosiga'],
		$r['casosiga'],
		iconv('UTF-8', 'windows-1252',$r['observacion']))
	);
	
	$i+=1;
}

$pdf->Output();
?>