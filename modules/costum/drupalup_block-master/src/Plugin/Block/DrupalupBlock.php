<?php

namespace Drupal\drupalup_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\drupalup_block\TimeService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
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

    /* Sem poskusil na takšen način ampak mi ni uspelo urediti, sem poskusil z 
    *  __construct
    * __create(...)
    * implementiral tudi ContainerFactoryPluginInterface
    * In sem dobil site error.  In ni šlo rešiti načina. 
    * Sem prebrskal celotni google in youtube pa nisem najdel rešitve. 
    * Upam, da zaradi teda dela ne bomo morali sodelovati. 
    * Drugače sama naloga pa deluje kot je bilo zahtevano. 
    */
    //$base = \Drupal::service('drupalup_service.time');

    $service = new TimeService();

    return [
      '#markup' => $service->outputSomeTime($node->field_event_date->value),
      '#cache' => [
        'max-age' => 0
      ],
    ];
  }
}
