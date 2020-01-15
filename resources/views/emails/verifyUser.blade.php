<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
 
<body>
<h2>Welcome to the site {{$user->name}}</h2>
<br/>
Your registered email-id is {{$user->email}} , Please click on the below link to verify your email account
<br/>
@php
$_params = [
	'locale'=>getLang(),
	'token'=>$user->userActivate->token
];
$_url = route('verifyUser', $_params);
@endphp
<a href="{{ $_url }}">{{ $_url }}</a>
<br/>
<br/>

<p>Thanks,</p>
<br/>

<p>{{ __('Phsar24') }}</p>
</body>
 
</html>