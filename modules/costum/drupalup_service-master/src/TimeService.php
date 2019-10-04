<?php

namespace Drupal\drupalup_service;

use Drupal\Core\Session\AccountProxy;

/**
 * CowService is a simple exampe of a Drupal 8 service.
 */
class TimeService {

  private $current_time;
  private $sounds = ["looO", 'mooO'];

  /**
   * Part of the DependencyInjection magic happening here.
   */
  public function __construct($currentTime) {
    $this->current_time = $currentTime;
  }

  /**
   * Returns a a Drupal user as an owner.
   */
  public function outputSomeTime() {
    $time = $this->current_time;


    $database = \Drupal::database();
    $query = $database->query("SELECT * FROM node_revision__field_event_date e WHERE e.field_event_date_value = '{$time}'");


    $result = $query->fetchAll();

    /* Checking if result is getting any data from the database.  */
    if($result == null){
      return  "This event doesn't exists. Please try to find another event.";
    }


    /* Converting some time */
    $event_created =  $result[0]->field_event_date_value;
    $e = explode("T", $event_created);
    
    $offset = date("Y-m-d",strtotime("now"));

    $new_time = date("Y-m-d",strtotime(implode(" ",$e)));

    if($new_time < $offset){
      return "This event already passed!";
    }


    if($new_time == $offset){
      return "This event is happening today.";
    }
    

    return $this->convert_time($new_time);
  }


  private function convert_time($time){
  $current_time = new \DateTime();
    $new_time = new \DateTime($time);
    return $current_time->diff($new_time)->format('%a days left until event starts');
  }


}
