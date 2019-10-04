<?php

namespace Drupal\drupalup_block;

use Drupal\Core\Session\AccountProxy;

/**
 * CowService is a simple exampe of a Drupal 8 service.
 */
class TimeService {

  private $current_time;


  /**
   * Part of the DependencyInjection magic happening here.
   */
  public function __construct() {
    
  }

  /**
   * Returns a a Drupal user as an owner.
   */
  public function outputSomeTime($time) {

    /* Converting some time */
    $event_created =  $time;
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
