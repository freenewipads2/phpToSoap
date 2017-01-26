<?php
class soapClient {
    function __construct($firstName,$lastName) {
       $this->seed = (string)rand(0, 1000000);
       $this->keyUrl = "";
       $this->postUrl = "";
       $this->nameSpace = "";
       $this->publicKey = $this->getPublicKey();
       $this->privateKey = "";
       //Params for body
       $this->firstName = $firstName;
       $this->lastName = $lastName;

       $this->hash = $this->generateHash();
       $this->body = $this->generateBody();
       $this->header = $this->generateHeader();
       $this->debug = true;
   }
   function generateClient($url){
     $client = new SoapClient($url);
     if(isset($this->header)){
       $client->__setSoapHeaders($this->header);
     }
     return $client;
   }
   function getBody(){
     //Returns json string
     return json_encode($this->body);
   }
   function callFunction($function){
     //Calls the function of your own choosing
     $client = $this->generateClient($this->postUrl);
     $result = $client->__soapCall($function,array($this->body));
     if(!$result){
       if($this->debug) {
         echo "Public key: " . $this->publicKey . "<br>";
         echo "Private key: " . $this->privateKey . "<br>";
         echo "RequestID: " . $this->seed . "<br>";
         echo "HashKey: " . $this->hash . "<br>";
      }
       die("Error");
     } else {
       echo "Success";
       $this->getBody();
     }
   }

   function generateHeader(){
     //Params for header, for example the seed and key
     $headerBody = array('requestID' => $this->seed,'key' => $this->hash);
     return new SoapHeader($this->nameSpace,'AuthHeader',$headerBody,false);
   }
   function generateHash(){
     //Generates the secret key
     $hash = sha1($this->publicKey.$this->privateKey.$this->seed);
     return strtoupper($hash);
   }
   function generateBody(){
     //Generates a body
     return array('firstName'=>$this->firstName, 'lastName'=>$this->lastName);
   }

   function getPublicKey(){
     //Returns public key
     $client = $this->generateClient($this->keyUrl);
     return $client->getPublicKey()->PublicKey;
   }
}
?>
