<?php

namespace Welcome\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session=\Config\Services::session();
    }

	public function index()
	{
		$data['title'] = "Welcome";

		/**
         * Display a test of the generic "items_list" view (defined in common module)
         */
		$data['list_title'] = "Test de la vue items_list";

        $data['columns'] = ['name' => 'Nom',
                            'inventory_nb' => 'No d\'inventaire',
                            'buying_date' => 'date d\'achat',
                            'warranty_duration' => 'durée de garantie'];
        $data['items'] = [
            ['id' => '1', 'name' => 'Item 1', 'inventory_nb' => 'ITM0001', 'buying_date' => '01.01.2020', 'warranty_duration' => '12 months'],
            ['id' => '2', 'name' => 'Item 2', 'inventory_nb' => 'ITM0002', 'buying_date' => '01.02.2020', 'warranty_duration' => '12 months'],
            ['id' => '3', 'name' => 'Item 3', 'inventory_nb' => 'ITM0003', 'buying_date' => '01.03.2020', 'warranty_duration' => '12 months'],
            ['id' => '4', 'name' => 'Item 4', 'inventory_nb' => 'ITM0004', 'buying_date' => '01.04.2020', 'warranty_duration' => '12 months'],
            ['id' => '5', 'name' => 'Item 5', 'inventory_nb' => 'ITM0005', 'buying_date' => '01.05.2020', 'warranty_duration' => '12 months'],
            ['id' => '6', 'name' => 'Item 6', 'inventory_nb' => 'ITM0006', 'buying_date' => '01.06.2020', 'warranty_duration' => '12 months'],
            ['id' => '7', 'name' => 'Item 7', 'inventory_nb' => 'ITM0007', 'buying_date' => '01.07.2020', 'warranty_duration' => '12 months'],
        ];

        $data['primary_key_field']  = 'id';
        $data['btn_create_label']   = 'Ajouter un objet';
        $data['url_detail'] = "items_list/detail/";
        $data['url_update'] = "items_list/update/";
        $data['url_delete'] = "items_list/delete/";
        $data['url_create'] = "items_list/create/";

		$this->display_view(['Common\Views\items_list','Welcome\welcome_message'], $data);
	}
}
