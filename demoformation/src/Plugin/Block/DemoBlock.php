<?php

namespace Drupal\demoformation\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * @Block(
 *   id = "demo_block_5140",
 *   admin_label = @Translation("Block de démo Formations")
 * )
 */

class DemoBlock extends BlockBase{
  public function build(){
    return array(
      '#markup' => $this->t('Demo d\'un bloc crée en code'),
    );
  }
}
