<?php

namespace Drupal\breaking_db\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the breaking_db module.
 */
class BreakingControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "breaking_db BreakingController's controller functionality",
      'description' => 'Test Unit for module breaking_db and controller BreakingController.',
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
   * Tests breaking_db functionality.
   */
  public function testBreakingController() {
    // Check that the basic functions of module breaking_db.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
