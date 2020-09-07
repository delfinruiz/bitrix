<?php
/**
 * Write data to log file.
 *
 * @param mixed $data
 * @param string $title
 *
 * @return bool
 */
function writeToLog($data, $title = '') {
 $log = "\n------------------------\n";
 $log .= date("Y.m.d G:i:s") . "\n";
 $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
 $log .= print_r($data, 1);
 $log .= "\n------------------------\n";
 file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
 return true;
}

$defaults = array('first_name' => '', 'horario' => '', 'phone' => '', 'email' => '');

if (array_key_exists('saved', $_REQUEST)) {
 $defaults = $_REQUEST;
 writeToLog($_REQUEST, 'WebForm');

 $queryUrl 	= 'https://peoplebpocrm.bitrix24.es/rest/1/vva1bphv3r9p6tr3/crm.lead.add';


// $queryUrl 	= ' https://peoplebpocrm.bitrix24.es/rest/1/bx272wv6mh9mjr0f/profile/';

 $queryData = http_build_query(array(
 	
 'fields' 			=> array(
 //"TITLE" 			=> $_REQUEST['first_name'].' '.$_REQUEST['last_name'],
 "TITLE" 			=> 'Contacto bot Easyline',
 "NAME" 			=> $_REQUEST['first_name'],
 //"LAST_NAME" 		=> $_REQUEST['last_name'],
 "COMMENTS"			=> $_REQUEST['horario'],
 "STATUS_ID" 		=> "NEW",
 "OPENED" 			=> "Y",
 "ASSIGNED_BY_ID" 	=> 26,
 "PHONE" 			=> array(array("VALUE" => $_REQUEST['phone'], "VALUE_TYPE" => "WORK" )),
 "EMAIL" 			=> array(array("VALUE" => $_REQUEST['email'], "VALUE_TYPE" => "WORK" )),),
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

 $result = json_decode($result, 1);
 writeToLog($result, 'Pagina Web Prueba');

 if (array_key_exists('error', $result)) echo "Error saving lead: ".$result['error_description']."<br/>";
}

?>

<!-- inicio formulario de ingresar contacto -->

<form method="post" action="">

    <label>Nombre Completo:</label>
    <input type="text" name="first_name" size="15" value="<?=$defaults['first_name']?>"><br/>
    <label>Telefono:</label>
    <input type="phone" name="phone" value="<?=$defaults['phone']?>"><br/>
    <label>E-mail:</label>
    <input type="email" name="email" value="<?=$defaults['email']?>"><br/>
    <label>Horario:</label>
    <input type="text" name="horario" value="<?=$defaults['horario']?>"><br/>
    <input type="hidden" name="saved" value="yes">
    <input type="submit" value="Enviar">

</form> 

<!-- fin formulario de ingresar contacto -->