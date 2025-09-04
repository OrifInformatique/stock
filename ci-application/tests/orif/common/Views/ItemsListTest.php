<?php
namespace Common\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use App\Controllers\BaseController;

class Test extends BaseController
{}

class ItemsListTest extends CIUnitTestCase
{

    use ControllerTestTrait;
    public function test_title_is_shown(): void
    {
        $data = self::get_default_data();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee($data['list_title'], 'h3');
    }

    public function test_default_name_id(): void
    {
        $this->test_default_name_id_when_null();
        $this->test_default_name_id_when_unset();
    }

    private function test_default_name_id_when_null(): void
    {
        $data = self::get_default_data();
        $data['primary_key_field'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $keys = array_keys($data['columns']);
        $result->assertSee($data['items'][0][$keys[0]]);
    }

    private function test_default_name_id_when_unset(): void
    {
        $data = self::get_default_data();
        unset($data['primary_key_field']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $keys = array_keys($data['columns']);
        $result->assertSee($data['items'][0][$keys[0]]);
    }

    public function test_title_is_hidden(): void
    {
        $this->test_title_is_hidden_when_null();
        $this->test_title_is_hidden_when_unset();
    }

    private function test_title_is_hidden_when_null(): void
    {
        $data = self::get_default_data();
        $list_title = $data['list_title'];
        $data['list_title'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee($list_title, 'h3');
    }

    private function test_title_is_hidden_when_unset(): void
    {
        $data = self::get_default_data();
        $list_title = $data['list_title'];
        unset($data['list_title']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee($list_title, 'h3');
    }

    public function test_create_button_shown(): void
    {
        $data = self::get_default_data();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee($data['btn_create_label'], 'a');
        $result->assertSeeLink($data['btn_create_label']);
    }

    public function test_create_default_label_button_shown(): void
    {
        $this->test_create_default_label_button_shown_null();
        $this->test_create_default_label_button_shown_unset();
    }

    private function test_create_default_label_button_shown_null(): void
    {
        $data = self::get_default_data();
        $data['btn_create_label'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee(lang('common_lang.btn_add'), 'a');
        $result->assertSeeLink(lang('common_lang.btn_add'));
    }

    private function test_create_default_label_button_shown_unset(): void
    {
        $data = self::get_default_data();
        unset($data['btn_create_label']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee(lang('common_lang.btn_add'), 'a');
        $result->assertSeeLink(lang('common_lang.btn_add'));
    }
    
    public function test_create_button_hidden(): void
    {
        $this->test_create_button_hidden_null();
        $this->test_create_button_hidden_unset();
    }

    private function test_create_button_hidden_null(): void
    {
        $data = self::get_default_data();
        $data['url_create'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee($data['btn_create_label'], 'a');

    }

    private function test_create_button_hidden_unset(): void
    {
        $data = self::get_default_data();
        unset($data['url_create']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee($data['btn_create_label'], 'a');
    }

    public function test_checkbox_shown(): void
    {
        $data = self::get_default_data();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee(lang('common_lang.btn_show_disabled'), 'label');
    }

    public function test_checkbox_hidden(): void
    {
        $this->test_checkbox_hidden_null();
        $this->test_checkbox_hidden_unset();
    }

    private function test_checkbox_hidden_null(): void
    {
        $data = self::get_default_data();
        $data['with_deleted'] = null;
        $data['url_getView'] = null;
        $data['deleted_field'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang('common_lang.btn_show_disabled'), 'label');
    }

    private function test_checkbox_hidden_unset(): void
    {
        $data = self::get_default_data();
        unset($data['with_deleted']);
        unset($data['url_getView']);
        unset($data['deleted_field']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang('common_lang.btn_show_disabled'), 'label');
    }

    public function test_details_icon_shown(): void
    {
        $this->test_icon_shown('common_lang.btn_details');
    }

    public function test_details_icon_hidden(): void
    {
        $this->test_icon_hidden('common_lang.btn_details', 'url_detail');
    }

    public function test_update_icon_shown(): void
    {
        $this->test_icon_shown('common_lang.btn_edit');
    }

    public function test_update_icon_hidden(): void
    {
        $this->test_icon_hidden('common_lang.btn_edit', 'url_update');
    }

    public function test_duplicate_icon_shown(): void
    {
        $this->test_icon_shown('common_lang.btn_copy');
    }

    public function test_duplicate_icon_hidden(): void
    {
        $this->test_icon_hidden('common_lang.btn_copy', 'url_duplicate');
    }

    public function test_delete_icon_shown(): void
    {
        $this->test_icon_shown('common_lang.btn_delete');
    }

    public function test_delete_icon_hidden(): void
    {
        $this->test_icon_hidden('common_lang.btn_delete', 'url_delete');
    }

    public function test_restore_icon_shown(): void
    {
        $this->test_icon_shown('common_lang.btn_restore');
    }

    public function test_restore_icon_hidden(): void
    {
        $this->test_icon_hidden('common_lang.btn_restore', 'url_restore');
        $this->test_restore_icon_hidden_when_date_null();
        $this->test_restore_icon_hidden_when_date_unset();
    }

    private function test_restore_icon_hidden_when_date_null(): void
    {
        $data = $this->get_default_data();
        $data['items'][1]['deleted'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang('common_lang.btn_restore'));
    }

    private function test_restore_icon_hidden_when_date_unset(): void
    {
        $data = $this->get_default_data();
        unset($data['items'][1]['deleted']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang('common_lang.btn_restore'));
    }

    public function test_red_delete_icon_shown(): void
    {
        $this->test_icon_shown('common_lang.btn_hard_delete');
    }

    public function test_red_delete_icon_hidden(): void
    {
        $this->test_icon_hidden('common_lang.btn_hard_delete', 'url_delete');
        $this->test_red_delete_icon_hidden_when_date_null();
        $this->test_red_delete_icon_hidden_when_date_unset();
    }

    private function test_red_delete_icon_hidden_when_date_null(): void
    {
        $data = $this->get_default_data();
        $data['items'][1]['deleted'] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang('common_lang.btn_hard_delete'));
    }

    private function test_red_delete_icon_hidden_when_date_unset(): void
    {
        $data = $this->get_default_data();
        unset($data['items'][1]['deleted']);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang('common_lang.btn_hard_delete'));
    }

    private function test_icon_shown(string $titleKey): void
    {
        $data = $this->get_default_data();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee(lang($titleKey));
    }

    private function test_icon_hidden(string $titleKey, string $urlKey): void
    {
        $this->test_icon_hidden_when_null($titleKey, $urlKey);
        $this->test_icon_hidden_unset($titleKey, $urlKey);
    }

    private function test_icon_hidden_when_null(string $titleKey, string $urlKey): void
    {
        $data = $this->get_default_data();
        $data[$urlKey] = null;
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang($titleKey));
    }

    private function test_icon_hidden_unset(string $titleKey,
        string $urlKey): void
    {
        $data = $this->get_default_data();
        unset($data[$urlKey]);
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertDontSee(lang($titleKey));
    }

    public function test_arrangement_columns_name(): void
    {
        $data = $this->get_default_data();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $pattern = array_reduce($data['columns'], fn($carry, $name) =>
            "$carry$name.*", '');
        $this->assertEquals(1, preg_match("/$pattern/s", $response));
    }

    public function test_arrangement_values_by_columns(): void
    {
        $data = $this->get_default_data();
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $columnsValues = array_map(fn($key) => $data['items'][0][$key],
            array_keys($data['columns']));
        $pattern = array_reduce($columnsValues, fn($carry, $value) =>
            $carry.preg_quote($value, '/').'.*', '');
        $this->assertEquals(1, preg_match("/$pattern/s", $response));
    }

    public function test_when_column_not_in_item_data():void
    {
        $data = $this->get_default_data();
        $data['columns']['fake'] = 'fakevalue';
        $result = $this->controller(Test::class)
                       ->execute('display_view', '\Common\items_list', $data);
        $response = $result->response()->getBody();
        $result->assertSee($data['columns']['fake']);
    }

    private function get_default_data(): array
    {
        $data['list_title'] = "Test items_list view";
        $data['columns'] = [
            'name' => 'Name', 'inventory_nb' => 'Inventory nb',
            'buying_date' => 'Buying date',
            'warranty_duration' => 'Warranty duration'
        ];
        $data['items'] = [
            [
                'id' => '1', 'name' => 'Item 1', 'inventory_nb' => 'ITM0001',
                'warranty_duration' => '12 months', 'deleted' => '',
                'buying_date' => '01/01/2020'
            ],
            [
                'id' => '12', 'name' => 'Item 12', 'inventory_nb' => 'ITM0012',
                'buying_date' => '01/03/2020',
                'warranty_duration' => '12 months', 'deleted' => '2000-01-01',
            ]
        ];
        $data['primary_key_field']  = 'id';
        $data['btn_create_label']   = 'Add an item';
        $data['with_deleted']       = true;
        $data['deleted_field']      = 'deleted';
        $data = array_merge($data, self::get_default_url_data());
        return $data;
    }

    private static function get_default_url_data(): array
    {
        $data['url_detail'] = "items_list/detail/";
        $data['url_update'] = "items_list/update/";
        $data['url_delete'] = "items_list/delete/";
        $data['url_create'] = "items_list/create/";
        $data['url_getView'] = "items_list/display_item/";
        $data['url_restore'] = "items_list/restore_item/";
        $data['url_duplicate'] = "items_list/duplicate_item/";
        return $data;
    }
}
