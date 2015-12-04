<?php
session_start();
$data=null;
$method=$_SERVER['REQUEST_METHOD'];
if($method == 'GET') $data=$_GET;
else if($method=='POST') $data=$_POST;
if(!isset($_GET['a'])) {
    echo('action not set');

    exit;

}
$a=explode('.',$_GET['a']);
$result=0;
switch(array_shift($a)){
    case 'location':
        include 'classes/Locations.php';
        $ctr=new Locations();
       $result = $ctr->process($a,$data);	   
        break;
	case 'getexamples':
	$result= new stdClass();
	$ar = array_values(array_diff(scandir('../images/examples'),array('.', '..','_notes')));
	$result->result=explode(',','images/examples/'.implode(',images/examples/',$ar));	
	$result->success='success';		
	break;

}

if($result){	
    if(isset($GLOBALS['ERROR']))$result->error=$GLOBALS['ERROR'];
    else {
		echo json_encode($result);
	}
}else if(isset($GLOBALS['ERROR'])) echo($GLOBALS['ERROR']);
else echo'no result no errors';
