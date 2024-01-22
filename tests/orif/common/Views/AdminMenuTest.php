<?php

namespace Common\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;


class AdminMenuTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = 'User';
    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function tearDown(): void
    {
        parent::tearDown();

    }

    # todo fix here
    public function test_panel_config_with_administrator_session() 
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_access'] = Config('\User\Config\UserConfig')
           ->access_lvl_admin;
        $_SESSION['_ci_previous_url'] = 'url';

        $_SESSION['user_id'] = 0;

        $result = $this->withSession()->get('stock/admin/list_user');
        // Assertions
        $response = $result->response();
        $body = $response->getBody();

        # d($response);
        # d($body);


        $result->assertSee(lang('user_lang.title_user_list'), 'h3');
        unset($_SESSION['user_id']);
    }
}
