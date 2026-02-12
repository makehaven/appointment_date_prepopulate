<?php

namespace Drupal\Tests\appointment_date_prepopulate\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * Verifies date normalization uses site timezone.
 *
 * @group appointment_date_prepopulate
 */
class AppointmentDatePrepopulateNormalizeDateTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'system',
    'user',
    'field',
    'text',
    'node',
    'appointment_date_prepopulate',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->installConfig(['system']);
  }

  /**
   * Ensures ISO datetime values are normalized in site timezone.
   */
  public function testNormalizeDateUsesSiteTimezone(): void {
    \Drupal::configFactory()
      ->getEditable('system.date')
      ->set('timezone.default', 'America/New_York')
      ->save();

    $this->assertSame('2026-02-28', _appointment_date_prepopulate_normalize_date('2026-03-01T00:30:00Z'));
    $this->assertSame('2026-03-01', _appointment_date_prepopulate_normalize_date('2026-03-01'));
  }

}

