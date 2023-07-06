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
$remark = $_POST["remark"];
$user_add1 = $_POST["add1"];
$user_city = $_POST["city"];
$user_post = $_POST["postcode"];
$user_state = $_POST["state"];
$user_name = $_POST["name"];
$user_phone = $_POST["phone"];
$dmethod = $_POST["dmethod"];
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
}
 // URl to Lalamove Sandbox API
$method = 'POST';
$path = '/v2/quotations';

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
        "amount": "11.80",
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
// echo 'Returned data: '.$response."\r\n";

$data = json_decode($response);
var_dump($data);
var_dump($body);
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
                <h3 class="box-title"><a href="shiporder.php?id=<?php echo $id; ?>" class="btn btn-primary" role="button">Return</a></h3>
            </div>
            
            <form action="deliver.php" method="post">
            <div class="box-body">
                    <div class="col-md-6">
                    <div class="callout callout-success">
                      <h4>Receiver Info</h4>
                    </div>
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="name" value="<?php echo $user_name; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Address</label>
                      <input type="text" class="form-control" name="add1" value="<?php echo $user_add1; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >City</label>
                      <input type="text" class="form-control" name="city" value="<?php echo $user_city; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Postcode</label>
                      <input type="text" class="form-control" name="postcode" value="<?php echo $user_post; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >State</label>
                      <input type="text" class="form-control" name="state" value="<?php echo $user_state; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Phone Number</label>
                      <input type="text" class="form-control" name="phone" value="<?php echo $user_phone; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Method of Delivery</label>
                      <input type="text" class="form-control" name="dmethod" value="<?php echo $dmethod; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Item Remark/Description</label>
                      <input type="text" class="form-control" name="remark" value="<?php echo $remark; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Latitude</label>
                      <input type="text" class="form-control" name="lat" id="lat" value="<?php echo $user_lat ; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Longitude</label>
                      <input type="text" class="form-control" name="long" id="long" value="<?php echo $user_long; ?>" readonly required>
                    </div>
                    <div id="mapCanvas"></div>
                    <div id="infoPanel">
    <b>Marker status:</b>
    <div id="markerStatus"><i>Click and drag the marker.</i></div>
    <b>Current position:</b>
    <div id="info"></div>
  </div>
                    <!-- <pre>
              <?php
                  // print_r($order_list);
              ?>
              </pre>-->
                    </div> 
                
                
                    <div class="col-md-6">
                    <div class="callout callout-info">
                      <h4>Sender Info</h4>
                    </div>
                    <div class="form-group">
                      <label >Name</label>
                      <input type="text" class="form-control" name="sname" value="<?php echo $send_name; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Address</label>
                      <input type="text" class="form-control" name="sadd" value="<?php echo $send_add; ?>" readonly required>
                    </div>
                    <div class="form-group">
                      <label >Phone Number</label>
                      <input type="text" class="form-control" name="sphone" value="<?php echo $send_phone; ?>" readonly required>
                    </div>
                    <label >Seller Location : Default Setting</label>
                    <div class="callout callout-danger">
                    <h4>Delivery Fee</h4>
                    
                    <?php echo 'RM '.$data->totalFee; ?>
                </div>
        <ul class="list-group">
                        <br>
                        <center>
                        
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="fee" value="<?php echo $data->totalFee; ?>">
                            <input type="submit" value="Ship Item" class="btn btn-danger">
                            </form> <br><br>
                        </center>
                    </ul> 
            </div>
            
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <style>
  #mapCanvas {
    width: 500px;
    height: 400px;
    float: left;
  }
  #infoPanel {
    float: left;
    margin-left: 10px;
  }
  #infoPanel div {
    margin-bottom: 5px;
  }
  </style>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAq2rK2ypqHd2gyWUgFAy7CfuIMzHQPibs&callback=initMap"></script>
  <script type="text/javascript">
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function initialize() {
  var latitude = $("#lat").val();
  var longtitude = $("#long").val();
  var latLng = new google.maps.LatLng(latitude, longtitude);
  var map = new google.maps.Map(document.getElementById('mapCanvas'), {
    zoom: 16,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });

  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);

  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });

  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });

  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<?php
include_once 'footer.php'
?>
