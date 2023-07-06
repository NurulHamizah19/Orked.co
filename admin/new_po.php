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
$select = $pdo->prepare("SELECT *, DATE_FORMAT(order_date, '%d/%m/%Y') AS order_date FROM tbl_invoice WHERE invoice_id=$id");
$select->execute();
$row = $select->fetch(PDO::FETCH_OBJ);


$detail = $pdo->prepare("SELECT * FROM config WHERE id=1");
$detail->execute();
$data = $detail->fetch(PDO::FETCH_OBJ);

$cid = $row->customer_name;

$cust = $pdo->prepare("SELECT * FROM tbl_client WHERE id=$cid");
$cust->execute();
$cdata = $cust->fetch(PDO::FETCH_OBJ);



//paper parameter, a4 ; margin 10mm

//create pdf obj
$pdf = new FPDF('P','mm','A4');
//orientation
//unit
//format
$image1 = "images/".$data->image;
//new page

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);

$pdf->Cell(40, 5, $pdf->Image($image1, $pdf->GetX(-5), $pdf->GetY(15), 38.78), 0, 0, 'L', false ); 
$pdf->Cell(110,10,$data->shop_name,0,0,'C');
$pdf->SetTextColor(255,255,255);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,10,'PURCHASE ORDER',1,1,'C',true);
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','BI',10);
$pdf->Cell(190,5,'"Street Legend Reborn"',0,1,'C');

$pdf->SetFont('Arial','',8.5);
$pdf->Cell(40,5,'',0,0,'C');
$pdf->Cell(110,5,'(Registration No. '.$data->ssm.')',0,0,'C');
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(20,5,'PO No.',0,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(20,5,'',1,1,'L');

$pdf->Cell(40,5,'',0,0,'C');
$pdf->Cell(110,5,$data->address,0,0,'C');
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(20,5,'Date Issued',0,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(20,5,'',1,1,'L');

$pdf->Cell(40,5,'',0,0,'C');
$pdf->Cell(110,5,$data->postcode.' '. $data->city.', '.$data->state.', Malaysia',0,0,'C');
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(20,5,'Quote No.',0,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(20,5,'',1,1,'L');


$pdf->Cell(190,5,'',0,1,'L');

$pdf->Cell(35,5,'',0,0,'L');
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(77.5,5,'SELLER/SUPPLIER/VENDOR DETAILS',1,0,'C',true);
$pdf->Cell(77.5,5,'SHIPPING & DELIVERY INFORMATION',1,1,'C',true);
$pdf->SetTextColor(0,0,0);

$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(35,5,'Name',1,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(77.5,5,'Sample Name',1,0,'L');
$pdf->Cell(77.5,5,'Lorem ipsum',1,1,'L');

$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(35,5,'Company Name',1,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(77.5,5,'Sample Name',1,0,'L');
$pdf->Cell(77.5,5,'Lorem ipsum',1,1,'L');

$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(35,20,'Company Address',1,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->MultiCell(77.5,5,'Line 1'."\n".'City'."\n".'Postcode'."\n".'State',1);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY($x + 112.5, $y - 20);
$pdf->MultiCell(77.5,5,'Line 1'."\n".'City'."\n".'Postcode'."\n".'State',1);

$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(35,5,'Tel No.',1,0,'R');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(77.5,5,'01111111111',1,0,'L');
$pdf->Cell(77.5,5,'01222222222',1,1,'L');

$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(190,5,'',0,1,'L');
$pdf->SetTextColor(255,255,255);
$pdf->Cell(25,5,'ITEM NO.',1,0,'C',true);
$pdf->Cell(87.5,5,'ITEM DESCRIPTION',1,0,'C',true);
$pdf->Cell(25,5,'QTY',1,0,'C',true);
$pdf->Cell(25,5,'U/PRICE',1,0,'C',true);
$pdf->Cell(27.5,5,'TOTAL',1,1,'C',true);
$pdf->SetTextColor(0,0,0);

$select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$id");
$select->execute();

$i = 1;
while($item = $select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetFont('Arial','',8.5);
    $pdf->Cell(25,5,$i++,1,0,'C');
    $pdf->Cell(87.5,5,$item->product_name,1,0,'L');
    $pdf->Cell(25,5,$item->qty,1,0,'C');
    $pdf->Cell(25,5,$item->price,1,0,'R');
    $pdf->Cell(27.5,5,($item->price * $item->qty),1,1,'R');
}

$pdf->Cell(190,5,'',0,1,'L');
$pdf->SetTextColor(255,255,255);
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(120,5,'SPECIAL NOTES & INSTRUCTIONS',1,0,'L',true);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(10,5,'',0,0,'L');
$pdf->Cell(60,5,'',0,1,'L');

$pdf->MultiCell(120,5,'sdsadsdsds',1,'L');
$pdf->SetFont('Arial','B',8.5);
$pdf->SetXY($x + 130, $y + 35);
$pdf->Cell(30,5,'SUB-TOTAL',0,0,'L');
$pdf->Cell(30,5,'RM100',1,1,'L');
$pdf->SetXY($x + 130, $y + 40);
$pdf->Cell(30,5,'DISCOUNT',0,0,'L');
$pdf->Cell(30,5,'RM100',1,1,'L');
$pdf->SetXY($x + 130, $y + 45);
$pdf->Cell(30,5,'TAX RATE',0,0,'L');
$pdf->Cell(30,5,'RM100',1,1,'L');
$pdf->SetXY($x + 130, $y + 50);
$pdf->Cell(30,5,'TAX AMOUNT',0,0,'L');
$pdf->Cell(30,5,'RM100',1,1,'L');
$pdf->SetXY($x + 130, $y + 60);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(30,10,'GRAND TOTAL',1,0,'L',true);
$pdf->Cell(30,10,'RM100',1,1,'L',true);
$pdf->SetFillColor(0,0,0);

$pdf->Cell(190,5,'',0,1,'L');
$pdf->SetFont('Arial','I',8.5);
$pdf->MultiCell(70,5,"\n\n\n\n".'Issuer Authorized Signature',1,'L');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(70,5,'Name',1,0,'C');
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(20,5,'Date:',0,0,'C');
$pdf->SetFont('Arial','',8.5);
$pdf->Cell(20,5,'10/10/2000',0,0,'C');
$pdf->Cell(80,5,'',0,1,'C');
$pdf->Cell(190,5,'',0,1,'C');

$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(190,5,'Should you have any enquiries, please forward it to the contact person stated below.',0,1,'C');
$pdf->SetTextColor(255,255,255);
$pdf->Cell(20,5,'NAME',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,5,'',1,0,'C');
$pdf->SetTextColor(255,255,255);
$pdf->Cell(20,5,'TEL NO.',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(30,5,'',1,0,'C');
$pdf->SetTextColor(255,255,255);
$pdf->Cell(20,5,'EMAIL',1,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(50,5,'',1,0,'C');
// $pdf->SetFont('Arial','',10);
// $pdf->Cell(80,5,$data->address2,0,0,'');

// $pdf->SetFont('Arial','',10);
// $pdf->Cell(110,5,'',0,1,'');


$pdf->SetFont('Arial','',11);
$pdf->Cell(110,5,' ',0,1,'');

$pdf->SetFont('Arial','B',16);
// $pdf->Cell(40, 5, $pdf->Image($image1, $pdf->GetX(-5), $pdf->GetY(15), 38.78), 1, 0, 'L', false ); // original 36.7
$pdf->SetDrawColor(214, 198, 197);
$pdf->Cell(190,10,' ','B', 1, 'C');
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(190,10,'',0,1,'');


//output
$pdf->Output();


?>
