<?php
	include('config.php');

	$login_button='';

	if(isset($_GET["code"]))
	{
		$token=$google_client->fetchAcessTokenWithAuthCode($_GET["code"]);
		if(!isset($token['erro']))
		{
			$google_client->setAcessToken($token['acess_token']);
			$_SESSION['acess_token'] = $token['acess_token'];
			$google_service=new Google_Oauth2Service($google_client);
			$data=$google_service->userinfo->get();

			if(!empty($data['given_name']))
			{
				
			}
		}
	}
?>