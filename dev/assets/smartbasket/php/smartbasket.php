<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once($_SERVER['DOCUMENT_ROOT'] . '/smartbasket/php/config.php');

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
		if (isset($_POST['dostavka']) ) {
			if(empty($_POST['dostavka'])) {
				echo 'notDelivery_type';
				$delivery_type = '';
			} else {
				$delivery_type = strip_tags($_POST['dostavka']);
			}
		}
		
		
		/*------------------insert in orders----------------------------*/
		
		$link = mysql_connect(HOSTNAME,USERNAME,PASSWORD) OR DIE("Не могу создать соединение ");
		mysql_select_db(DBNAME) or die(mysql_error());

		mysql_query('set names utf8');

		$userName = clean($_POST['userName']);			
		$userTel =clean($_POST['userTel']);
		$userEmail = clean($_POST['userEmail']);
		$userAdress = clean($_POST['userAdress']);
		$date_order = date("Y-m-d H:i:s");
		$delivery_type = clean($_POST['dostavka']);
		echo $delivery_type;
		$query_add =  "INSERT INTO orders (`order_date`,`customer`,`phone`,`email`,`address`,`delivery_type`)  VALUES ('".$date_order."','".$userName."','".$userTel."','".$userEmail."','".$userAdress."','".$delivery_type."')";

		mysql_query($query_add) or die(mysql_error());
		
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
							$body.=
								'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
											<div style="padding: 5px;"> Размер: 
											'
								. $v .
								'
											</div></td>';
						} else {
							$body.=
								'<td style="width: 100px;  padding-top:15px; padding-bottom:15px; padding-right:15px; padding-left:15px; text-align:center; border-top:1px; border-left:1px; border-right:0; border-bottom:0; border-color:#e2e2e2; border-style: solid;" >
									<div style="padding: 5px;"> Размер отстутствует </div>
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
					$res_id = mysql_query("SELECT order_id FROM orders ORDER BY order_id DESC LIMIT 1") or die(mysql_error());
					$par_name=mysql_fetch_array($res_id);
					$orderId =$par_name['order_id'];	
					
					$query_add_2 =  "INSERT INTO order_items (`order_id`,`name`,`sku`,`price`,`quantity`)  VALUES ('".$orderId."','".$productName."','".$productSku."','".$productPrice."','".$productQuantity."')";					
					mysql_query($query_add_2) or die(mysql_error());
				/*---------------//INSERT in order_items------------------*/
			}

		};
		$bodybottom = '</table>';
	}

	if(defined('HOST') && HOST != '') {
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = HOST;
		$mail->SMTPAuth = true;
		$mail->Username = LOGIN;
		$mail->Password = PASS;
		//$mail->SMTPSecure = 'ssl';		
		$mail->Port = PORT;
		$mail->AddReplyTo(SENDER);
	} else {
		$mail = new PHPMailer;
	}

		$mail->setFrom(SENDER);
		if(!empty($userEmail)){
        $mail->addAddress($userEmail);
    }
    $mail->addAddress(CATCHER);
    
    $mail->CharSet = CHARSET;
    $mail->isHTML(true);
		$mail->Subject = SUBJECT; // Заголовок письма
		$mail->Body = "$bodyHeader $body $bodybottom";
		if(!$mail->send()) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        } else {
            //echo '<p class="smartlid__respond-success">' . SUCCESSMSGS . '</p>';
           // echo 'successmsgs';
					 echo 'Message sent success';
        }
} else {
	header ("Location: /");
}


	

mysql_close($link);

			
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