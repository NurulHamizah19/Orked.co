<?php 

//call fpdf lib

require('fpdf/fpdf.php');
include_once'connectdb.php';
session_start();
include_once 'config.php';
if($_SESSION['useremail']==""){
    header('location:index.php');
}

$id = $_GET['id'];
$select = $pdo->prepare("SELECT *, DATE_FORMAT(order_date, '%d/%m/%Y') AS order_date FROM tbl_order WHERE invoice_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);

//paper parameter, a4 ; margin 10mm

//create pdf obj
$pdf = new FPDF('P','mm','A4');
//orientation
//unit
//format
$image1 = "logo.png";
//new page

$pdf->AddPage();

//$pdf->SetFont('Arial','',11);
//$pdf->Cell(40,5,' ',0,0,'');
//
//$pdf->SetFont('Arial','',11);
//$pdf->Cell(150,5,' ',0,1,'');

$pdf->SetFont('Arial','B',16);
$pdf->Cell(40, 5, $pdf->Image($image1, $pdf->GetX(-5), $pdf->GetY(15), 38.78), 0, 0, 'L', false ); // original 36.7


//$pdf->SetFont('Arial','',10);
//$pdf->Cell(166.5,5,'Date: '.$row->order_date,0,1,'C');
//$pdf->SetFont('Arial','B',13);
//$pdf->Cell(308,10,'Resit',0,1,'C');
//$pdf->SetFont('Arial','',10);
//$pdf->Cell(151,5,'No: #'.$row->invoice_id,0,1,'C');
$pdf->SetFont('Arial','B',11);
$pdf->Cell(150,5,'OFF THE DOCK',0,1,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5,' ',0,0,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(150,5,'NO. 3, OFF JALAN PAM AIR 2,',0,1,'');
// $pdf->Cell(60,5,'Address Line 2',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5,' ',0,0,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(150,5,'FELDA SOEHARTO, 60000 SELANGOR, MALAYSIA',0,1,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5,' ',0,0,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(150,5,'Tel : +60166710892',0,1,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,5,' ',0,0,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(150,5,'',0,1,''); // EMAIL
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,15,' ',0,1,'');

$pdf->Line(5,40,205,40);
//$pdf->Ln(5);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(140,10,'',0,0,'L');
$pdf->Cell(50,10,'Quotation',0,1,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(140,10,'',0,0,'L');
$pdf->Cell(20,5,'ID: ',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(30,5,$id,0,1,'R');
$pdf->SetFont('Arial','',11);
$pdf->Cell(140,5,'',0,0,'L');
$pdf->Cell(20,5,'Date: ',0,0,'L');
$pdf->SetFont('Arial','',11);
$pdf->Cell(30,5,$row->order_date,0,1,'R'); // TODO : ACTUAL DATE

$pdf->SetFont('Arial','B',11);
$pdf->Cell(50,6,'Ship From',0,0,'');
$pdf->Cell(140,6,'',0,1,'L'); // CUST VAR

$pdf->SetFont('Arial','',11);
$pdf->Cell(50,6,$row->supplier,0,0,'');
$pdf->Cell(140,6,'',0,1,'L'); // CUST VAR

$pdf->SetFont('Arial','',11);
$pdf->Cell(50,6,$row->addr1,0,0,'');
$pdf->Cell(140,6,'',0,1,'L'); // CUST VAR

$pdf->SetFont('Arial','',11);
$pdf->Cell(50,6,$row->addr2,0,0,'');
$pdf->Cell(140,6,'',0,1,'L'); // CUST VAR

$pdf->Cell(50,5,'',0,1,'');
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(8,8,'No',1,0,'C',true);   //190
$pdf->Cell(92,8,'Item',1,0,'C',true);   //190
$pdf->Cell(20,8,'Qty',1,0,'C',true);
$pdf->Cell(20,8,'Unit Price',1,0,'C',true);
$pdf->Cell(50,8,'Total (RM)',1,1,'C',true);


$select = $pdo->prepare("SELECT * FROM tbl_order_details WHERE invoice_id=$id");
$select->execute();
$index = 0;
while($item = $select->fetch(PDO::FETCH_OBJ)){
    $index++;
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(8,8,$index,1,0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(92,8,$item->product_name,1,0,'L');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(20,8,$item->qty,1,0,'C');
    $pdf->Cell(20,8,number_format($item->price,2),1,0,'C');
    $pdf->Cell(50,8,number_format(($item->qty)*($item->price),2),1,1,'C');
}


$pdf->SetFont('Arial','',10);
$pdf->Cell(8,6,'',0,0,'L');   //190
$pdf->Cell(92,6,'',0,0,'L');
$pdf->Cell(40,6,'Subtotal',1,0,'C');
$pdf->Cell(50,6,number_format($row->subtotal,2),1,1,'C');

$pdf->Cell(8,6,'',0,0,'L');   //190
$pdf->Cell(92,6,'',0,0,'L');
$pdf->Cell(40,6,'Discount',1,0,'C');
$pdf->Cell(50,6,number_format($row->discount,2),1,1,'C');

$pdf->Cell(8,6,'',0,0,'L');   //190
$pdf->Cell(92,6,'',0,0,'L');
$pdf->Cell(40,6,'Total',1,0,'C');
$pdf->Cell(50,6,number_format($row->total - $row->discount,2),1,1,'C');
$pdf->SetFont('Arial','',11);
$pdf->Cell(190,15,' ',0,1,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(50,6,'Remarks : '.$row->remark,0,0,'');
$pdf->Cell(140,6,'',0,1,'L'); // CUST VAR

$pdf->SetFont('Arial','',11);
$pdf->Cell(190,10,'',0,1,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(50,6,'Date : ',0,0,'');
$pdf->Cell(90,6,'',0,0,'L'); // CUST VAR
$pdf->Cell(50,6,'________________________',0,1,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(140,6,'',0,0,'');
$pdf->Cell(50,6,'                Signature',0,1,'L'); // CUST VAR


$pdf->SetFont('Arial','',11);
$pdf->Cell(190,15,' ',0,1,'');

//output
$pdf->Output();


?>