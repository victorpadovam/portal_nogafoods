<?php
//var_dump($_GET); exit;
    if($_GET['order_id']){
         $bd = new mysqli("localhost","nogafoodsbr_portal_nogafoods","Noga6417@","nogafoodsbr_portal_nogafoods");
    
        if($bd->query("update orders set payment_status = 'paid', order_status = 'confirmed' where id = ".$_GET['order_id']."")){
            if(!isset($_GET['pix'])){
                 header("location: https://app.nogafoods.com.br/order-successful?id=".$_GET['order_id']."&status=success");
            }else{
                $ch = curl_init('https://app.nogafoods.com.br/order-successful?id='.$_GET['order_id'].'&status=success');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);            }
           
        }
        
    }
   