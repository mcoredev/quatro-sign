<?php


class QuatroSign {

    public $orderNumber;
    public $subject;
    public $callback;
    public $amount;

    public $clientName;
    public $clientSurname;
    public $clientPhone;
    public $clientEmail;
    public $clientAddress;
    public $clientCity;
    public $clientZip;
    public $clientCountryCode;


    public function generateLink($url = '', $signKey = '')
    {
        if(empty($url)) {
           die("Quatro redirect URL is not set.");
        }
        elseif(empty($signKey)) {
           die("Missing signKey Quatro.");
        }

        $payload = [
           'application' => [
                'orderNumber'=> $this->orderNumber,
                'applicant'=> [
                    'firstName'=> $this->clientName,
                    'lastName'=> $this->clientSurname,
                    'email'=>  $this->clientEmail,
                    'mobile'=>$this->clientPhone,
                    'permanentAddress'=> [
                        'addressLine'=>  $this->clientAddress,
                        'city'=>  $this->clientCity,
                        'zipCode'=>  $this->clientZip,
                        'country'=>  $this->clientCountryCode
                    ],
                ],
                'subject'=> $this->subject,
                'totalAmount'=> floatval($this->amount),
                'goodsAction'=> null,
                'callback'=> $this->callback,
            ],
            'iat'=> time()
        ];

        $token = $this->sign($payload, $signKey);
        return $url."?token=".$token;
    }

    public function sign($payload = [], $secretKey = '')
    {        
        $header['alg'] = "HS256";
        $header['typ'] = "JWT";

        if(empty($secretKey)) {
            throw new Exception("Secret Key is NULL.");            
        }

        if(empty($payload)) {
            throw new Exception("Payload is empty.");
        }

        $base64UrlHeader = $this->base64encode(json_encode($header));
        $base64UrlPayload = $this->base64encode(json_encode($payload));

        $signature = hash_hmac('SHA256', $base64UrlHeader . "." . $base64UrlPayload,  $this->base64Decode($secretKey), true );
        $base64UrlSignature = $this->base64encode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }
    
    public function base64encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    public function base64Decode($input)
    {        
        return base64_decode(strtr($input, '-_', '+/'));
    }
}