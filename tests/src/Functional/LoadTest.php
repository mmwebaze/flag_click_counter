<?php

namespace Drupal\Tests\flag_click_counter\Functional;

use Drupal\Core\Url;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group flag_click_counter
 */
class LoadTest extends BrowserTestBase
{

    /**
     * Modules to enable.
     *
     * @var array
     */
    public static $modules = ['flag_click_counter'];

    /**
     * A user with permission to administer site configuration.
     *
     * @var \Drupal\user\UserInterface
     */
    protected $user;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->user = $this->drupalCreateUser(['administer site configuration']);
        $this->drupalLogin($this->user);
    }

    /**
     * Tests that the home page loads with a 200 response.
     */
    public function testLoad()
    {
        $this->drupalGet(Url::fromRoute('<front>'));
        $this->assertResponse(200);
    }

}
