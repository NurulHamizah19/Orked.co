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


$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'Bill From:',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(70,5,'',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40, 5, $pdf->Image($image1, $pdf->GetX(-5), $pdf->GetY(15), 38.78), 0, 1, 'L', false ); 

$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$data->shop_name,0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(110,5,'',0,1,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$data->address,0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(110,5,' ',0,1,'');

// $pdf->SetFont('Arial','',10);
// $pdf->Cell(80,5,$data->address2,0,0,'');

// $pdf->SetFont('Arial','',10);
// $pdf->Cell(110,5,'',0,1,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$data->postcode .' '.$data->city,0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(110,5,' ',0,1,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$data->state,0,0,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(110,5,' ',0,1,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$data->phone,0,0,'');

$pdf->SetFont('Arial','',11);
$pdf->Cell(110,5,' ',0,1,'');

$pdf->SetFont('Arial','B',16);
// $pdf->Cell(40, 5, $pdf->Image($image1, $pdf->GetX(-5), $pdf->GetY(15), 38.78), 1, 0, 'L', false ); // original 36.7
$pdf->SetDrawColor(214, 198, 197);
$pdf->Cell(190,10,' ','B', 1, 'C');
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(190,10,'',0,1,'');

if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'Bill To:',0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Invoice',0,0,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,$id,0,1,'R');


if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(80,5,strtoupper($cdata->name),0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}


$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Invoice Date',0,0,'L');

$orderdt = strtotime($row->order_date);
$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,$row->order_date,0,1,'R');


if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(80,5,strtoupper($cdata->address),0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}




$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(30,5,'Amount Due',0,0,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'RM'.$row->due,0,1,'R');


if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(80,5,strtoupper($cdata->postcode .' '. $cdata->city),0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}



$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(30,5,'Payment Status',0,0,'L',true);

if($row->due == 0){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,5,'Fully Paid',0,1,'R',true);
} else {
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,5,'Unpaid',0,1,'R',true);
}


if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(80,5,strtoupper($cdata->state),0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}


$pdf->SetFont('Arial','',10);
$pdf->Cell(110,5,' ',0,1,'');


if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(80,5,$cdata->email,0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}


$pdf->SetFont('Arial','',11);
$pdf->Cell(110,5,' ',0,1,'');

if($cdata->name != "WALK-IN"){
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(80,5,$cdata->phone,0,0,'');
} else {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(80,5,'',0,0,'');
}

$pdf->SetFont('Arial','',11);
$pdf->Cell(110,5,' ',0,1,'');


$pdf->Cell(50,5,'',0,1,'');
$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(100,8,'Item',0,0,'C',true);   //190
$pdf->Cell(20,8,'Quantity',0,0,'C',true);
$pdf->Cell(20,8,'Unit Price',0,0,'C',true);
$pdf->Cell(50,8,'Total',0,1,'C',true);


$select = $pdo->prepare("SELECT * FROM tbl_invoice_details WHERE invoice_id=$id");
$select->execute();


while($item = $select->fetch(PDO::FETCH_OBJ)){
    $pdf->SetDrawColor(214, 198, 197);
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(100,8,$item->product_name,'B', 0, 'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(20,8,$item->qty,'B', 0, 'C');
    $pdf->Cell(20,8,$item->price,'B', 0, 'C');
    $pdf->Cell(50,8,($item->qty)*($item->price),'B', 1, 'C');
}

    $pdf->Cell(190,20,'',0,1,'');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'Payment Method',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Subtotal',0,0,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'RM'.$row->total,0,1,'R');

$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$row->payment_type,0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Tax',0,0,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'RM'.$row->tax,0,1,'R');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(80,5,'Delivery Method',0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(30,5,'Discount',0,0,'L');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'RM'.($row->discount),0,1,'R');
// to fix lol
if($row->shipment_type == 1){ $delivery = "Runner"; } else if($row->shipment_type == 2){ $delivery = "Postage";} else if($row->shipment_type == 0){ $delivery = "Postage"; }
$pdf->SetFont('Arial','',10);
$pdf->Cell(80,5,$delivery,0,0,'');

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'',0,0,'');

$pdf->SetFont('Arial','B',10);
$pdf->SetFillColor(208,208,208);
$pdf->Cell(30,5,'Total',0,0,'L',true);

$pdf->SetFont('Arial','',10);
$pdf->Cell(40,5,'RM'.($row->total + $row->tax - $row->discount),0,1,'R',true);
$pdf->Cell(40,10,'',0,1,'L');
if($row->remark != ""){
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(40,5,'Additional Remark',0,1,'L');
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(40,5,$row->remark,0,1,'L');
}


//output
$pdf->Output();
