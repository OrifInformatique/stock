<?php
namespace App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\TestResponse;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

function bool_to_string(bool $b): string
{
    return $b ? 'true': 'false';
}

class Test extends BaseController
{
    public function test_all_user_access_level(): string
    {
        $this->access_level = "*";
        return bool_to_string($this->check_permission());
    }
    public function test_logged_user_access_level(): string
    {
        $this->access_level = "@";
        return bool_to_string($this->check_permission());
    }
    public function test_admin_access_level(): string
    {
        $this->access_level = Config('\User\Config\UserConfig')
             ->access_lvl_admin;
        return bool_to_string($this->check_permission());
    }
}
class TestAdmin extends BaseController
{
    public function initController(RequestInterface $request,
        ResponseInterface $response, LoggerInterface $logger): void
    {
        $this->access_level=config('\User\Config\UserConfig')
             ->access_lvl_admin;
        parent::initController($request, $response, $logger);
    }
}

class BaseControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    public function test_all_user_access_level_without_account(): void
    {
        $this->test_access_level('test_all_user_access_level')(true);
    }

    public function test_all_user_access_level_with_registered(): void
    {
        $this->test_access_level('test_all_user_access_level',
            $this->get_registered_data())(true);
    }

    public function test_all_user_access_level_with_admin(): void
    {
        $this->test_access_level('test_all_user_access_level',
            $this->get_admin_data())(true);
    }

    public function test_logged_user_access_level_without_account(): void
    {
        $this->test_access_level('test_logged_user_access_level')(false);
    }

    public function test_logged_user_access_level_with_registered(): void
    {
        $this->test_access_level('test_logged_user_access_level',
            $this->get_registered_data())(true);
    }

    public function test_logged_user_access_level_with_admin(): void
    {
        $this->test_access_level('test_logged_user_access_level',
            $this->get_admin_data())(true);
    }

    public function test_admin_access_level_without_account(): void
    {
        $this->test_access_level('test_admin_access_level')(false);
    }

    public function test_admin_access_level_with_registered(): void
    {
        $this->test_access_level('test_admin_access_level',
            $this->get_registered_data())(false);
    }

    public function test_admin_access_level_with_admin(): void
    {
        $this->test_access_level('test_admin_access_level',
            $this->get_admin_data())(true);
    }

    public function test_display_view_with_view_by_string(): void
    {
        $data = array();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\login_bar', $data);
        $body = $result->response()->getBody();
        $toFind = lang('common_lang.btn_login');
        $pattern = '/'.$toFind.'.*'.$toFind.'/s';
        $this->assertEquals(1, preg_match($pattern, $body));
        $result->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $result->assertSee('Script to update favicon in some browsers');
        
    }

    public function test_display_view_with_view_by_array(): void
    {
        $data = array();
        $view = array('\Common\login_bar', '\Common\login_bar');
        $result = $this->controller(Test::class)
                       ->execute('display_view', $view, $data);
        $body = $result->response()->getBody();
        $toFind = lang('common_lang.btn_login');
        $pattern = '/' . $toFind . '.*' . $toFind . '.*' . $toFind . '/s';
        $this->assertEquals(1, preg_match($pattern, $body));
        $result->assertHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    public function test_display_view_connection_button(): void
    {
        $_SESSION['logged_in'] = true;
        $_SESSION['user_access'] = Config('\User\Config\UserConfig')
           ->access_lvl_admin;
        $_SESSION['_ci_previous_url'] = 'url';
        $data = array();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\login_bar', $data);
        $body = $result->response()->getBody();
        $result->assertSee(lang('common_lang.btn_logout'));
        $result->assertDontSee(lang('common_lang.btn_login'));
    }

    public function test_display_view_disconnection_button(): void
    {
        $data = array();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\login_bar', $data);
        $body = $result->response()->getBody();
        $result->assertSee(lang('common_lang.btn_login'));
        $result->assertDontSee(lang('common_lang.btn_logout'));
    }

    public function test_display_view_when_unauthorized(): void
    {
        $data = array();
        try {
            $result = $this->controller(TestAdmin::class)
                           ->execute('display_view', '\Common\login_bar');
        } catch (\Exception $e) {
            $this->assertEquals(
                lang('user_lang.msg_err_access_denied_message'),
                $e->getMessage()
            );
        }
    }

    public function test_display_view_when_authorized(): void
    {
        $data = array();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\login_bar');
        $body = $result->response()->getBody();
        $result->assertDontSee(
            lang('user_lang.msg_err_access_denied_message'));
    }

    private function test_access_level(string $method_name,
        ?array $sessionData=null): callable
    {
        # $test_level = fn() => $this->execute_methode(
        #     $method_name, $sessionData);
        # $result = $test_level();
        $result = $this->execute_methode($method_name, $sessionData);
        return fn ($expect) => $this->assertEquals(bool_to_string($expect),
            $result->response()->getBody());
    }

    private function execute_methode(string $method, ?array $sessionData):
        TestResponse
    {
        if (isset($sessionData)) {
            $_SESSION = array_merge($_SESSION, $sessionData);
        }
        return $this->controller(Test::class)->execute($method);
    }

    private function get_registered_data(): array
    {
        $data['logged_in'] = true;
        $data['user_access'] = Config('\User\Config\UserConfig')
           ->access_lvl_registered;
        return $data;
    }

    private function get_admin_data(): array
    {
        $data['logged_in'] = true;
        $data['user_access'] = Config('\User\Config\UserConfig')
           ->access_lvl_admin;
        return $data;
    }



    
}
