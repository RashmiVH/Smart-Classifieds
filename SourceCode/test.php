<?php
//**********************CURL


		$curl = curl_init();
		$timeout = 30;
		$ret = "";
		//curl_setopt($curl, CURLOPT_PROXY, $proxy);
		curl_setopt ($curl, CURLOPT_URL, $instance);
		//curl_setopt ($curl, CURLOPT_POST, 1);
		//curl_setopt ($curl, CURLOPT_POSTFIELDS, "username=" . $uid . "&password=" . $pwd);
		//curl_setopt ($curl, CURLOPT_COOKIESESSION, 1);
		//curl_setopt ($curl, CURLOPT_COOKIEFILE, "cookie_way2sms");
		curl_setopt ($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($curl, CURLOPT_MAXREDIRS, 20);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5");
		curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
		//curl_setopt ($curl, CURLOPT_REFERER, "http://wwwd.way2sms.com//");
		$text = curl_exec($curl);


?>
