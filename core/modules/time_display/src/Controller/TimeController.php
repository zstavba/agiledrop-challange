<?php


namespace Drupal\time_display\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\node\NodeInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\HttpFoundation\Request;

class TimeController extends ControllerBase{


 /* Instead of time i've used Event ID to get the info that i've nedeed :) */
 public function content() {
 	$id = substr_replace($_GET['id'] ,"",-1);



 	if($id == null){
 		return new JsonResponse([
 			"Parameter is currently empty please add a parameter to search for an event !!!"
 		],400);
 	}

 	/* Connecton for the query, that i've used for getting the data */
 	$database = \Drupal::database();
 	$query = $database->query("SELECT * FROM node_revision__field_event_date e WHERE e.field_event_date_value = '{$id}'");

	$result = $query->fetchAll();

	/* Checking if result is getting any data from the database.  */
	if($result == null){
		return new JsonResponse([
			"This event doesn't exists. Please try to find another event."
		],400);
	}

	/* Converting some time */
	$event_created =  $result[0]->field_event_date_value;
	$e = explode("T", $event_created);
	
	$offset = date("Y-m-d",strtotime("now"));

	$new_time = date("Y-m-d",strtotime(implode(" ",$e)));

	if($new_time < $offset){
		return new JsonResponse([
			"This event already passed!"
		],400);
	}


	if($new_time == $offset){
		return new JsonResponse([
			"This event is happening today."
		],200);
	}
	

	return new JsonResponse([
		$this->convert_time($new_time).' left until event starts'		
	],200);

  }


  private function convert_time($time){
 	$current_time = new \DateTime();
    $new_time = new \DateTime($time);
    return $current_time->diff($new_time)->format('%a days');
  }


}