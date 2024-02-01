<?php

namespace Welcome\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{
    public function initController(RequestInterface $request,
        ResponseInterface $response, LoggerInterface $logger): void
    {
        parent::initController($request, $response, $logger);
        $this->session=\Config\Services::session();

        helper('form');
    }

	public function index(): string
	{
        return view('Welcome\welcome_message');
	}

    public function display_items($with_deleted = false): string
    {
        $data['list_title'] = "Test de la liste items_list";

        $data['columns'] = ['name' => 'Nom',
                            'inventory_nb' => 'Numéro d\'inventaire',
                            'buying_date' => 'Date d\'achat',
                            'warranty_duration' => 'Durée de garantie'];
        
        // Assume these are active items
        $data['items'] = [
            ['id' => '1', 'name' => 'Item 1', 'inventory_nb' => 'ITM0001', 'buying_date' => '01/01/2020', 'warranty_duration' => '12 months', 'deleted' => ''],
            ['id' => '2', 'name' => 'Item 2', 'inventory_nb' => 'ITM0002', 'buying_date' => '01/02/2020', 'warranty_duration' => '12 months', 'deleted' => ''],
            ['id' => '3', 'name' => 'Item 3', 'inventory_nb' => 'ITM0003', 'buying_date' => '01/03/2020', 'warranty_duration' => '12 months', 'deleted' => '']
        ];
        
        if ($with_deleted) {
            // Assume these are soft_deleted items
            $data['items'] = array_merge($data['items'], [
                ['id' => '10', 'name' => 'Item 10', 'inventory_nb' => 'ITM0010', 'buying_date' => '01/01/2020', 'warranty_duration' => '12 months', 'deleted' => '2000-01-01'],
                ['id' => '11', 'name' => 'Item 11', 'inventory_nb' => 'ITM0011', 'buying_date' => '01/02/2020', 'warranty_duration' => '12 months', 'deleted' => '2000-01-01'],
                ['id' => '12', 'name' => 'Item 12', 'inventory_nb' => 'ITM0012', 'buying_date' => '01/03/2020', 'warranty_duration' => '12 months', 'deleted' => '2000-01-01']
            ]);
        }
        
        $data['primary_key_field']  = 'id';
        $data['btn_create_label']   = 'Ajouter un élément';
        $data['with_deleted']       = $with_deleted;
        $data['deleted_field']      = 'deleted';
        $data['url_detail'] = "items_list/detail/";
        $data['url_update'] = "items_list/update/";
        $data['url_delete'] = "items_list/delete/";
        $data['url_create'] = "items_list/create/";
        $data['url_getView'] = "welcome/home/display_items";
        $data['url_restore'] = "items_list/restore_item/";
        $data['url_duplicate'] = "items_list/duplicate_item/";
        
        return $this->display_view('Common\items_list', $data);
    }
}
