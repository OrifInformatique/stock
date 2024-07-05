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

    # Marc Louis PORTA 2024-01-23
    # This function must be rewritten when the stock unit tests are created.
    # user/admin/list_user goes to stock/admin/list_user because of the filter.
    # list_user of module stock creates side effects in other tests.
    # To check: list_user of module stock makes the view function saves
    # previous data and change some session data.
    public function test_panel_config_with_administrator_session() 
    {
        
        $_SESSION['logged_in'] = true;
        $_SESSION['user_access'] = Config('\User\Config\UserConfig')
           ->access_lvl_admin;
        $_SESSION['_ci_previous_url'] = 'url';

        $result = $this->withSession()->get('user/admin/list_user');
        # // Assertions
        # $response = $result->response();
        # $body = $response->getBody();
        # $result->assertSee(lang('user_lang.title_user_list'), 'h1');
        

        $warning = 'This function must be rewritten when the stock unit '
            . 'tests are created.';
        d($warning);
        return;
    }
}
