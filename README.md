# quatro-sign
Simple class to implement Quatro Sign

## Example 
```
$quatro = new QuatroSign();
$quatro->orderNumber = '123456';
$quatro->amount = 99.99;
$quatro->subject = 'Televízory - Samsung - UHD47U123456';
$quatro->callback = 'https://your-eshop.com/callback-url';

$quatro->clientName = 'contactName';
$quatro->clientSurname = '';
$quatro->clientPhone = '';
$quatro->clientEmail = '';
$quatro->clientAddress = '';
$quatro->clientCity = '';
$quatro->clientZip = '';
$quatro->clientCountryCode = 'SVK';

$redirect = $quatro->generateLink('https://quatroapi.vub.sk/stores/YOUR_CODE/create-application', 'YOUR_SECRET_KEY');
```
