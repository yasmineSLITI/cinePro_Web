<?php

namespace App\Controller;

use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="app_message")
     */
    public function index(): Response
    {
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
    /**
     * @Route("/sendmsg", name="sending")
     */
    public function send(Request $request)
    {
$mobile ='0021652635303';
$message = 'Votre demande a été bien acceptée';
$encodedMessage = urlencode($message);
$authKey ='';
$sendrId='';
$route = 4;
$postData = array(
    'authkey'=>$authKey,
    'mobiles'=>$mobile,
    'message'=>$encodedMessage,
    'sender'=>$sendrId,
    'route'=>$route

);
$url='';

$ch = curl_init();
curl_setopt_array($ch,array(
    CURLOPT_URL =>$url ,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
));
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST , 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
$output = curl_exec($ch);
if(curl_errno($ch)){
    echo 'error : ' . $ch;
}
curl_close($ch);
return $this->render('message/success.html.twig' , [
    'response'=> $output
]);


/*
$data = array(
    'mobile'=>$mobile,
    'message'=>$message,
   
);
echo '<pre>' ;
print_r($data);
echo '</pre>';
exit();*/
    }
}
