<?php

	 $first_name = "prueba nombre2";
	 $phone = "33333";
	 $email = "prueba2@gmail.com";
	 $horario = "despues de la prueba2";

	 $queryUrl 	= 'https://peoplebpocrm.bitrix24.es/rest/1/vva1bphv3r9p6tr3/crm.lead.add';

	 $queryData = http_build_query(array(
	 	
	 'fields' 			=> array(
	 "TITLE" 			=> 'Contacto Easyline',
	 "NAME" 			=> $first_name,
	 "COMMENTS"			=> $horario,
	 "STATUS_ID" 		=> "NEW",
	 "OPENED" 			=> "Y",
	 "ASSIGNED_BY_ID" 	=> 26,
	 "PHONE" 			=> array(array("VALUE" => $phone, "VALUE_TYPE" => "WORK" )),
	 "EMAIL" 			=> array(array("VALUE" => $email, "VALUE_TYPE" => "WORK" )),),
	 'params' 			=> array("REGISTER_SONET_EVENT" => "Y")));

	 $curl = curl_init();
	 curl_setopt_array($curl, array(
	 CURLOPT_SSL_VERIFYPEER => 0,
	 CURLOPT_POST => 1,
	 CURLOPT_HEADER => 0,
	 CURLOPT_RETURNTRANSFER => 1,
	 CURLOPT_URL => $queryUrl,
	 CURLOPT_POSTFIELDS => $queryData,
	 ));

	 $result = curl_exec($curl);
	 curl_close($curl);

?>