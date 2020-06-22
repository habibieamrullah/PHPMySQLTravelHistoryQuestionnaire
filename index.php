<?php
date_default_timezone_set('Asia/Singapore');
include("dbconnection.php");
?>

<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Scan Test</title>
        
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
        
        <style>
            
            html{
                background: rgb(75,11,105);
                background: linear-gradient(0deg, rgba(75,11,105,1) 0%, rgba(34,10,60,1) 100%);
            }
        
			body{
				padding: 0;
				margin: 0;
				font-family: 'Quicksand', sans-serif;
				
				overflow-x: hidden;
				color: white;
				
			}
			
			.wrapper{
			    max-width: 720px;
			    margin: 0 auto;
			    padding: 20px;
			}
			
			.wideinput{
			    box-sizing: border-box;
			    width: 100%;
			    margin-bottom: 5px;
			    margin-top: 5px;
			    padding: 10px;
			    border: 1px solid lime;
			}
			
			.inputgroup{
			    margin-bottom: 20px;
			}
			
			
			h1, h2, h3, h4, h5, p{
			    margin: 0;
			    margin-bottom: 10px;
			}
			
			.registereditem{
			    background-color: white;
			    color: black;
			    padding: 10px;
			    margin-top: 5px;
			    margin-bottom: 5px;
			}
		</style>
    </head>
    <body>
        
        <div class="wrapper">
            
            <?php
            if(isset($_GET["submitted"])){
                
                ?>
                
                <h1>Submitted data</h1>
                <h4>*You may need to refresh this page to update</h4>
                
                    
                    
                <?php
                
                $sql = "SELECT * FROM travelhistory ORDER BY id DESC";
                $result = mysqli_query($connection, $sql);
                
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <div class="registereditem">
                        <b>Date and Time: </b> <?php echo $row["date"] . " | " . $row["time"]  ?><br>
                        <b>Name: </b><?php echo $row["name"] ?><br>
                        <b>Phone: </b><?php echo $row["phone"] ?><br>
                        <b>Been in China: </b><?php echo $row["china"] ?><br>
                        <b>Been out from Singapore?  </b><?php echo $row["outsg"] ?><br>
                        <b>>>> Country name, if yes? </b><?php echo $row["outsgc"] ?><br>
                        <b>Body Temperature: </b><?php echo $row["temperature"] ?><br>
                    </div>
                    <?php
                }
                
                ?>
                    
                
                <div align="center" style="padding: 50px;">
                <p><a href="<?php echo $baseurl ?>" style="color: lime;">View submission form</a></p>
                </div>
                
                <?php
                
            }else{
                
                if(isset($_POST["name"])){
                    
                    ?>
                    <h1>Thank you!</h1>
                    <p>Form is submitted.</p>
                    <?php
                    
                    $name = mysqli_real_escape_string($connection, $_POST["name"]);
                    $phone = mysqli_real_escape_string($connection, $_POST["phone"]);
                    $china = mysqli_real_escape_string($connection, $_POST["china"]);
                    $outsg = mysqli_real_escape_string($connection, $_POST["outsg"]);
                    $outsgc = mysqli_real_escape_string($connection, $_POST["outsgc"]);
                    $temperature = mysqli_real_escape_string($connection, $_POST["temperature"]);
                    
                    if($china == "chinayes")
                        $china = "yes";
                    else
                        $china = "no";
                        
                    if($outsg == "outsgyes")
                        $outsg = "yes";
                    else
                        $outsg = "no";
                    
                    $date = date("Y/m/d");
                    $time = date("h:i:sa");
                    mysqli_query($connection, "INSERT INTO travelhistory (name, phone, temperature, china, outsg, outsgc, date, time) VALUES ('$name', '$phone', '$temperature', '$china', '$outsg', '$outsgc', '$date', '$time')");
                    
                    ?>
                    <div align="center" style="padding: 50px;">
                        <p><a href="?submitted" style="color: lime;">View submitted data</a></p>
                    </div>
                    <?php
                    
                }else{
                    ?>
                
                    <h1>Welcome</h1>
                    <p>Please fill this form:</p>
                    <form method="post">
                        <div class="inputgroup">
                            <label>1. Name:</label>
                            <input class="wideinput" placeholder="Name" name="name">
                        </div>
                        
                        <div class="inputgroup">
                            <label>2. Phone:</label>
                            <input class="wideinput" placeholder="Phone" name="phone" type="number">
                        </div>
                        
                        <div class="inputgroup">
                            <label>3. Have you been to China in last 2 weeks?</label>
                            <br><input type="radio" value="chinayes" name="china"><label for="chinayes">Yes</label>
                            <br><input type="radio" value="chinano" name="china" checked><label for="chinano">No</label>
                        </div>
                        
                        <div class="inputgroup">
                            <label>4. Have you travelled out of Singapore in the last 2 weeks?</label>
                            <br><input type="radio" value="outsgyes" name="outsg" id="outsgyes" onchange="checkoutsg()"><label for="outsgyes">Yes</label>
                            <br><input type="radio" value="outsgno" name="outsg" onchange="checkoutsg()" checked><label for="outsgno">No</label>
                            <br>
                            <div id="ifyesoutsg" style="display: none; background-color: #363636; padding: 10px; margin-top: 10px;">
                                <label>If yes, where?</label>
                                <input class="wideinput" placeholder="Country name" id="outsgcountryname" value="Nil" name="outsgc">
                            </div>
                        </div>
                        
                        <div class="inputgroup">
                            
                            <label>5. Current body temperature:</label>
                            <input class="wideinput" placeholder="Body Temperature" name="temperature" type="number">
                        </div>
                        
                        <input class="wideinput" type="submit" value="Submit" style="background-color: lime; border: none;">
                        
                    </form>
                    
                    
                    <div align="center" style="padding: 50px;">
                        <p><a href="?submitted" style="color: lime;">View submitted data</a></p>
                    </div>
                    
                    <?php
                }

            }
            ?>
        
            
            
        </div>
        
        
        <script>
            function checkoutsg(){
                if($("#outsgyes").prop("checked")){
                    $("#ifyesoutsg").show()
                    $("#outsgcountryname").val("")
                }
                    
                else{
                    $("#ifyesoutsg").hide()
                    $("#outsgcountryname").val("Nil")
                }
                    
            }
            
            $("body").css({ "min-height" : innerHeight + "px" })
        </script>
        
    </body>
</html>
