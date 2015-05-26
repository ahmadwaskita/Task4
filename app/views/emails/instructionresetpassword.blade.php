<div>
	<h1>Hai{{$username}}</h1>
	<h3>Someone has request for reset password, if not requesting, abandon this message</h3>
	<p>
		To reset your password please follow this link: {{link_to('change-password/'.$forgot_token,'Change Password')}}
	</p>
</div>