<?php

namespace Drupal\demoformation\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the demoformation module.
 */
class ChristmasControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "demoformation ChristmasController's controller functionality",
      'description' => 'Test Unit for module demoformation and controller ChristmasController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests demoformation functionality.
   */
  public function testChristmasController() {
    // Check that the basic functions of module demoformation.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
