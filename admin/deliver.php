<?php
include_once 'connectdb.php';
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');
if($_SESSION['useremail']==""){ //check if empty
    header('location:index.php'); //redirect to index
}

if($_SESSION['role'] == "User"){
    include_once 'headeruser.php';
    } else {
        include_once 'header.php';
    }
$id = $_POST["id"];

$config = $pdo->prepare("SELECT * FROM config WHERE id=1");
$config->execute();
$set = $config->fetch(PDO::FETCH_OBJ);
$ep_api = $set->ep_api;
$lala_api = $set->lala_api;
$lala_sec = $set->lala_sec;
$ep_env = $set->ep_env;
$lala_env = $set->lala_env;
$shop_name = $set->shop_name;
$saddress = $set->address;
$scity = $set->city;
$spostcode = $set->postcode;
$sstate = $set->state;
$sphone = $set->phone;
$lala_loc = $set->lala_loc;
$send_lat = $set->lat;
$send_lng = $set->lng;

// Put your key and secret here
$key = $lala_api; // put your lalamove API key here
$secret = $lala_sec; // put your lalamove API secret here
$user_lat = $_POST["lat"];
$user_long = $_POST["long"];
$user_add1 = $_POST["add1"];
$remark = $_POST["remark"];
$user_city = $_POST["city"];
$user_post = $_POST["postcode"];
$user_state = $_POST["state"];
$user_name = $_POST["name"];
$user_phone = $_POST["phone"];
$dmethod = $_POST["dmethod"];
$fee = $_POST["fee"];
$curdate = date('m/d/Y h:i:s a', time());

//sender info

$send_add = $_POST["sadd"];
$send_name = $_POST["sname"];
$send_phone = $_POST["sphone"];

$time = time() * 1000;
if($lala_env == 0){
    $baseURL = "https://rest.sandbox.lalamove.com";
  } else {
    $baseURL = "https://rest.lalamove.com";
  } // URl to Lalamove Sandbox API
$method = 'POST';
$path = '/v2/orders';

$region = $lala_loc;

// Please, find information about body structure and passed values here https://developers.lalamove.com/#get-quotation
$body = '{
    "serviceType": "'.$dmethod.'",
    "specialRequests": [],
    "requesterContact": {
        "name": "'.$send_name.'",
        "phone": "'.$send_phone.'"
    },
    "stops": [
        {
            "location": {
                "lat": "'.$send_lat.'",
                "lng": "'.$send_lng.'"
            },
            "addresses": {
                "en_MY": {
                    "displayString": "'.$send_add.'",
                    "market": "'.$region.'"
                }
            }
        },
        {
            "location": {
                "lat": "'.$user_lat.'",
                "lng": "'.$user_long.'"
            },
            "addresses": {
                "en_MY": {
                    "displayString": "'.$user_add1.' '.$user_city.' '.$user_post.' '.$user_state.'",
                    "market": "'.$region.'"
                }
            }
        }
   ],
   "deliveries": [
        {
            "toStop": 1,
            "toContact": {
                "name": "'.$user_name.'",
                "phone": "'.$user_phone.'"
            },
           "remarks": "'.$remark.'"
        }
   ],
    "quotedTotalFee": {
        "amount": "'.$fee.'",
        "currency": "MYR"
    }
}';

$rawSignature = "{$time}\r\n{$method}\r\n{$path}\r\n\r\n{$body}";
$signature = hash_hmac("sha256", $rawSignature, $secret);
$startTime = microtime(true);
$token = $key.':'.$time.':'.$signature;

$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $baseURL.$path,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 3,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HEADER => false, // Enable this option if you want to see what headers Lalamove API returning in response
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => array(
        "Content-type: application/json; charset=utf-8",
        "Authorization: hmac ".$token, // A unique Signature Hash has to be generated for EVERY API call at the time of making such call.
        "Accept: application/json",
        "X-LLM-Market: {$region}" // Please note to which city are you trying to make API call
    ),
));

$response = curl_exec($curl);
$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

// echo "Total elapsed http request/response time in milliseconds: ".floor((microtime(true) - $startTime)*1000)."\r\n";
// echo "Authorization: hmac ".$token."\r\n";
// echo 'Status Code: '. $http_code."\r\n";
echo 'Returned data: '.$response."\r\n";

$data = json_decode($response);

$lalamove_id = $data->orderRef;
// send data 
$insert = $pdo->prepare("INSERT INTO lalamove(oid,lalamove_id,fee) values(:oid,:lalamove_id,:fee)");
$insert->bindParam(':oid',$id);
$insert->bindParam(':lalamove_id',$lalamove_id);
$insert->bindParam(':fee',$fee);
$insert->execute();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Review Order (#<?php echo $id?>)
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title"><a href="shiporder.php?id=<?php echo $id?>" class="btn btn-primary" role="button">Return</a></h3>
            </div>
            <form action="dashboard.php" method="post">
            <div class="box-body">
                    <div class="col-md-6">
                    <ul class="list-group">
                    <center><p class="list-group-item list-group-item-success"><b>Shipment Details</b></p></center>
                    <?php
                    // foreach ($order_list as $key => $object) {
                    echo '
                        <li class="list-group-item" >ID <span class="badge" style="font-size:14px">'.$id.'</span></li>';
                    echo'
                        <li class="list-group-item">Name<span class="label label-primary pull-right" style="font-size:14px">'.$user_name.'</span></li>
                        <li class="list-group-item">Address<span class="label label-success pull-right" style="font-size:14px">'.$user_add1.'</span></li>
                        <li class="list-group-item">City <span class="label label-success pull-right" style="font-size:14px">'.$user_city.'</span></li>
                        <li class="list-group-item">State <span class="label label-success pull-right" style="font-size:14px">'.$user_state.'</span></li>
                        <li class="list-group-item">Phone <span class="label label-danger pull-right" style="font-size:14px">'.$user_phone.'</span></li>
                        <li class="list-group-item">Delivery Method <span class="label label-warning pull-right" style="font-size:14px">Lalamove - '.$dmethod.'</span></li>
                        <li class="list-group-item">Order Date <span class="label label-primary pull-right" style="font-size:14px">'.$curdate.'</span></li>
                    ';
                      
                    // }
                    ?>
                    </ul>
                    <!-- <pre> -->
              <?php
                //   print_r($order_list);
              ?>
              <!-- </pre> -->
                    </div>
                
                
        <div class="col-md-6">
            
                
            <div class="box-body no-padding">
                <div class="callout callout-success">
                    <h4>Delivery Order Success</h4>
                    <?php echo 'Fee Paid : RM '.$data->totalFee; ?><br><?php echo 'Lalamove Tracking ID : '.$data->orderRef; ?>
                    
                </div>
                    <ul class="list-group">
                        <br>
                        <center>
                        
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="totalfee" value="<?php echo $data->totalFee; ?>">
                            <input type="submit" value="Return to Dashboard" class="btn btn-danger">
                            </form> <br><br>
                        </center>
                    </ul> 
                
            </div>
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
include_once 'footer.php'
?>
