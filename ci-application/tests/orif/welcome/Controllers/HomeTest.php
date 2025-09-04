<?php
/**
 * Unit tests HomeTest
 *
 * @author      Orif (CaLa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

 namespace Welcome\Controllers;

 use CodeIgniter\Test\CIUnitTestCase;
 use CodeIgniter\Test\ControllerTestTrait;
 
 class HomeTest extends CIUnitTestCase
{
    use ControllerTestTrait;

    /**
     * Asserts that the index page is loaded correctly
     */
    public function testIndex() 
    {
        // Execute index method of Home class
        $result = $this->controller(Home::class)
        ->execute('index');

        // Assertions
        $response = $result->response();
        $this->assertInstanceOf(\CodeIgniter\HTTP\Response::class, $response);
        $this->assertNotEmpty($response->getBody());
        $result->assertOK();
        $result->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $result->assertSee('Welcome to CodeIgniter', 'h1');
        $result->assertSee('The small framework with powerful features', 'h2');
    }

    /**
     * Asserts that the display_items page is loaded correctly
     */
    public function testdisplay_items() 
    {
        // Execute display_items method of Home class
        $result = $this->controller(Home::class)
        ->execute('display_items');

        // Assertions
        $response = $result->response();
        $this->assertInstanceOf(\CodeIgniter\HTTP\Response::class, $response);
        $this->assertNotEmpty($response->getBody());
        $result->assertOK();
        $result->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $result->assertSee('Test de la liste items_list', 'div');
        $result->assertSeeElement('#itemsList');
        $result->assertSee('Nom', 'th');
        $result->assertSee('Numéro d\'inventaire', 'th');
        $result->assertSee('Date d\'achat', 'th');
        $result->assertSee('Durée de garantie', 'th');
        $result->assertSee('ITM0001', 'td');
        $result->assertSee('01/01/2020', 'td');
        $result->assertSee('12 months', 'td');
        $result->assertDontSee('ITM0010', 'td');
    }

    /**
     * Asserts that the display_items page is loaded correctly with disabled items
     */
    public function testdisplay_itemsWithDisabled() 
    {
        // Execute display_items method of Home class
        $result = $this->controller(Home::class)
        ->execute('display_items', true);

        // Assertions
        $response = $result->response();
        $this->assertInstanceOf(\CodeIgniter\HTTP\Response::class, $response);
        $this->assertNotEmpty($response->getBody());
        $result->assertOK();
        $result->assertHeader('Content-Type', 'text/html; charset=UTF-8');
        $result->assertSee('Test de la liste items_list', 'div');
        $result->assertSeeElement('#itemsList');
        $result->assertSee('Nom', 'th');
        $result->assertSee('Numéro d\'inventaire', 'th');
        $result->assertSee('Date d\'achat', 'th');
        $result->assertSee('Durée de garantie', 'th');
        $result->assertSee('ITM0001', 'td');
        $result->assertSee('01/01/2020', 'td');
        $result->assertSee('12 months', 'td');
        $result->assertSee('ITM0010', 'td');
    }
}
