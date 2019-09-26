<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once($_SERVER['DOCUMENT_ROOT'] . '/smartbasket/php/config_test.php');
$host = 'https://' . $_SERVER["HTTP_HOST"];
//echo $host;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST['userName']) ) {
			if(empty($_POST['userName'])) {
				echo 'notName';
				$name='';
			} else {
				$name = "<b>Имя: </b>" . strip_tags($_POST['userName']) . "<br>";
			}
		}
		if (isset($_POST['userTel']) ) {
			if(empty($_POST['userTel'])) {
				echo 'notTel';
				$tel = '';
			} else {
				$tel = "<b>Телефон: </b>" . strip_tags($_POST['userTel']) . "<br>";
			}
		}

		if (isset($_POST['userEmail']) ) {
			if(empty($_POST['userEmail'])) {
				echo 'notEmail';
				$email = '';
			} else {
				$email = "<b>Email: </b>" . strip_tags($_POST['userEmail']) . "<br>";
			}
		}
		if (isset($_POST['userAdress']) ) {
			if(empty($_POST['userAdress'])) {
				echo 'notAdress';
				$adress = '';
			} else {
				$adress = "<b>Адрес: </b>" . strip_tags($_POST['userAdress']) . "<br>";
			}
		}
		
		/*------------------insert in orders----------------------------*/
		
		$link = $link = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DBNAME);
		if(!$link){
			printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
			exit;
		}
		

		mysqli_query($link,'set names utf8');

		$userName = clean($_POST['userName']);			
		$userTel =clean($_POST['userTel']);
		$userEmail = clean($_POST['userEmail']);
		$userAdress = clean($_POST['userAdress']);
		$date_order = date("Y-m-d H:i:s");

		$query_add =  "INSERT INTO orders_test (`order_date`,`customer`,`phone`,`email`,`address`)  VALUES ('".$date_order."','".$userName."','".$userTel."','".$userEmail."','".$userAdress."')";

		mysqli_query($link, $query_add) or die(mysqli_error($link));
		/*
		if (!mysqli_query($link,$query_add))
		{
			echo("Error description: " . mysqli_error($link));
		}
		*/
		
		/*-----------------//insert in orders---------------------------*/
		
		$productArr=Array();
		$counter = 0;
		$body = "";		
		$bodyHeader = '<h2>' . SUBJECT2 . '</h2><table border="0" cellpadding="0" cellspacing="0" style="border-bottom:1px; border-right:1px; border-color:#e2e2e2; border-style: solid; width:800px" width="800" align="center">
			<tr >
				<th colspan="3" style="width: 400px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;">' . $name . $adress . '</th>
				<th colspan="4" style="width: 400px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;">' . $tel . $email .'</th>				
			</tr>';
		
		foreach ($_POST as $key =>  $value) {			
			$body.= '<tr>';
			if (is_array($value) || $value instanceof Traversable) {
				foreach ($value as $k => $v) {

					
					if($k == 'productName'){
						$productName = $v;
						$body.=
							'<td style="width: 300px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;">
											'
							. $v .
							'
											</div></td>';
					}
					if($k == 'productImg'){
						$productImg = '<img src="https://kramola-books.ru/' . $v . '" width="100" height="100" alt="Ваш заказ">';
						$body.=
							'
											<td style="width: 100px; padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;">
											'
												. $productImg .
											'
											</div></td>';
					}
					if($k == 'productSize'){
						if(!empty($v)){
							echo 'productSize: ' . $v;
							$body.=
								'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;"> Размер: 
											'
								. $v .
								'
											</div></td>';
						} else {
							$orderId = getOrderId($link);
							$body.=
								'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
									<div style="padding: 5px;"> Номер заказа: ' . $orderId . ' </div>
								</td>';
						}
					}
					if($k == 'productId'){
						$productSku = $v;
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> ID: 
												'
							. $v .
							'
												</div></td>';
					}
					if($k == 'productPrice'){
						$productPrice = $v;
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Цена: 
												'
							. $v .
							'
												</div></td>';
					}
					if($k == 'productQuantity'){
						$productQuantity = $v;
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Кол-во: 
												'
							. $v .
							'
												</div></td>';
					}

					if($k == 'productPriceCommon'){
						$body.=
							'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
												<div style="padding: 5px;"> Общая цена:
												'
							. $v .
							'
												</div></td>';
					}

				}

				$body.= '</tr>';
				/*---------------INSERT in order_items------------------*/
					/*
					$res_id = mysqli_query($link,'SELECT order_id FROM orders_test ORDER BY order_id DESC LIMIT 1');
					if(!mysqli_query($link,'SELECT order_id FROM orders_test ORDER BY order_id DESC LIMIT 1')){
					mysqli_error($link);
					}
					$par_name = mysqli_fetch_array($res_id, MYSQLI_ASSOC);
					$orderId = $par_name['order_id'];	
					mysqli_free_result($res_id);
					*/
					$orderId = getOrderId($link);
					$query_add_2 =  "INSERT INTO order_items_test (`order_id`,`name`,`sku`,`price`,`quantity`)  VALUES ('".$orderId."','".$productName."','".$productSku."','".$productPrice."','".$productQuantity."')";
					if (!mysqli_query($link,$query_add_2))
					{
						echo("Error description: " . mysqli_error($link));
					}
					
				/*---------------//INSERT in order_items------------------*/
			}

		};
		$bodybottom = '</table>';
	}
	/*--------------------------------------PHPMAILER-----------------------------------------------*/
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function


// Load Composer's autoloader
//require 'vendor/autoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
		$mail->CharSet = CHARSET;
    $mail->SMTPDebug = DEBUG;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = HOST;  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = LOGIN;                     // SMTP username
    $mail->Password   = PASS;                               // SMTP password
    $mail->SMTPSecure = SECURE;                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = PORT;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom(SENDER, 'kramola-books');
   
	if(!empty($userEmail)){
		$mail->addAddress($userEmail);               // Name is optional
		//$mail->addCC($userEmail);               // Name is optional
	}	else{
		 $mail->addAddress(CATCHER, 'администратор');     // Add a recipient
	}
    
    //$mail->addReplyTo('webprogrammer77@yandex.ru', 'Information');
    $mail->addReplyTo(CATCHER);
    //$mail->addCC('webprogrammer77@mail.ru');
    //$mail->addBCC('webprogrammer77@gmail.com');

    // Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = SUBJECT2;
    $mail->Body    = "$bodyHeader $body $bodybottom";
    $mail->AltBody = "$userName спасибо за заказ";

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
		
/*----------------------------------------------------//-----------------------------------------------------------------------*/		
		
		
} else {
	header ("Location: /");
}


function getOrderId($link){
	$query = 'SELECT order_id FROM orders_test ORDER BY order_id DESC LIMIT 1';
	$res_id = mysqli_query($link, $query);
	if(!mysqli_query($link, $query)){
		mysqli_error($link);
	}
	$par_name = mysqli_fetch_array($res_id, MYSQLI_ASSOC);
	$orderId = $par_name['order_id'];	
	mysqli_free_result($res_id);
	return $orderId;
}

	

mysqli_close($link);

			
				//$customer_email = $email;
	
/*--------------------------------------------------------------------------*/
function clean($value = "") {
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);
    
		return $value;		
}

function check_length($value = "", $min, $max) {
    $result = (mb_strlen($value) < $min || mb_strlen($value) > $max);
    return !$result;
}



?>
