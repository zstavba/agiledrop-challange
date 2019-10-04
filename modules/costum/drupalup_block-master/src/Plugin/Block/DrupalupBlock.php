<?php

namespace Drupal\drupalup_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\drupalup_service\TimeService;
/**
 * Provides a 'Drupalup Block' Block.
 *
 * @Block(
 *   id = "drupalup_block",
 *   admin_label = @Translation("Drupalup block"),
 *   category = @Translation("Our example Drupal Up block"),
 * )
 */
class DrupalupBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = \Drupal::routeMatch()->getParameter('node');


    if($node->getType() != "event"){
      return [
        '#markup' => "Woops! This block is intended only for event pages.",
      ];      
    }

    $date = $node->field_event_date->value;


    return [
      '#markup' => $this->getEventTime($date),
      '#cache' => [
        'max-age' => 0
      ],
    ];
  }

  /**
   * Private function for getting random quote.
   */
  private function getEventTime($date) {
    $time = new TimeService($date);
    return $time->outputSomeTime();
  }

}
