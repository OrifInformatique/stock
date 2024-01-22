<?php
/**
 * Unit / Integration tests User_modelTest 
 *
 * @author      Orif (CaLa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace User\Models;

use CodeIgniter\Test\CIUnitTestCase;

class User_modelTest extends CIUnitTestCase
{
    const ADMINISTRATOR_USER_TYPE = 1;
    const REGISTERED_USER_TYPE = 2;
    const GUEST_USER_TYPE = 3;

    /**
     * Tests that the check_password_name correctly checks the user password using the username
     */
    public function testcheck_password_name()
    {
        // Instantiate a new user model
        $userModel = new \User\Models\User_model();

        // Inserts user into database
        $userType = self::GUEST_USER_TYPE;
        $username = 'UserUnitTest';
        $userEmail = 'userunittest@unittest.com';
        $userPassword = 'UserUnitTestPassword';
        $userWrongPassword = 'UserUnitTestWrongPassword';
        $userId = self::insertUser($userType, $username, $userEmail, $userPassword);

        // Checks user password using username (Assertion)
        $checkPasswordName = $userModel->check_password_name($username, $userPassword);
        $this->assertTrue($checkPasswordName);

        // Checks wrong user password using username (Assertion)
        $checkPasswordName = $userModel->check_password_name($username, $userWrongPassword);
        $this->assertFalse($checkPasswordName);

        // Deletes inserted user after assertions
        $userModel->delete($userId, TRUE);
    }

    /**
     * Tests that the check_password_name correctly checks the user password using the username when the user does not exist in the database
     */
    public function testcheck_password_nameWithNonExistingUser()
    {
        // Instantiate a new user model
        $userModel = new \User\Models\User_model();

        // Initialize non existing username and password
        $username = 'UserUnitTest';
        $userPassword = 'UserUnitTestPassword';

        // Checks user password using username (Assertion)
        $checkPasswordName = $userModel->check_password_name($username, $userPassword);
        $this->assertFalse($checkPasswordName);
    }

    /**
     * Tests that the check_password_email correctly checks the user password using the user email
     */
    public function testcheck_password_email()
    {
        // Instantiate a new user model
        $userModel = new \User\Models\User_model();

        // Inserts user into database
        $userType = self::GUEST_USER_TYPE;
        $username = 'UserUnitTest';
        $userEmail = 'userunittest@unittest.com';
        $userPassword = 'UserUnitTestPassword';
        $userWrongPassword = 'UserUnitTestWrongPassword';
        $userId = self::insertUser($userType, $username, $userEmail, $userPassword);

        // Checks user password using user email address (Assertion)
        $checkPasswordEmail = $userModel->check_password_email($userEmail, $userPassword);
        $this->assertTrue($checkPasswordEmail);

        // Checks wrong user password using user email address (Assertion)
        $checkPasswordEmail = $userModel->check_password_email($userEmail, $userWrongPassword);
        $this->assertFalse($checkPasswordEmail);

        // Deletes inserted user after assertions
        $userModel->delete($userId, TRUE);
    }

    /**
     * Tests that the check_password_email correctly checks the user password using the username when the user does not exist in the database
     */
    public function testcheck_password_emailWithInvalidEmail()
    {
        // Instantiate a new user model
        $userModel = new \User\Models\User_model();

        // Initialize invalid user email address and password
        $userEmail = 'userunittest';
        $userPassword = 'UserUnitTestPassword';

        // Checks user password using username (Assertion)
        $checkPasswordEmail = $userModel->check_password_email($userEmail, $userPassword);
        $this->assertFalse($checkPasswordEmail);
    }

    /**
     * Tests that the check_password_email correctly checks the user password using the username when the user does not exist in the database
     */
    public function testcheck_password_emailWithNonExistingUserEmailAddress()
    {
        // Instantiate a new user model
        $userModel = new \User\Models\User_model();

        // Initialize non existing user email address and password
        $userEmail = 'userunittest@test.com';
        $userPassword = 'UserUnitTestPassword';

        // Checks user password using username (Assertion)
        $checkPasswordEmail = $userModel->check_password_email($userEmail, $userPassword);
        $this->assertFalse($checkPasswordEmail);
    }

    /**
     * Tests that the get_access_level correctly returns the user access level
     */
    public function testget_access_level() 
    {
        // Instantiate a new user model
        $userModel = new \User\Models\User_model();

        // Inserts user into database      
        $userData = array(
            'id' => 0,
            'fk_user_type' => self::GUEST_USER_TYPE,
            'username' => 'UserUnitTest',
            'email' => 'userunittest@unittest.com',
            'password' => 'UserUnitTestPassword',
            'password_confirm' => 'UserUnitTestPassword',
        );

        $userId = $userModel->insert($userData);
        
        // Gets user access level
        $userAccessLevel = $userModel->get_access_level($userModel->getWhere(['id'=>$userId])->getRow());

        // Asserts that the new user has the guest access level
        $this->assertEquals($userAccessLevel, config("\User\Config\UserConfig")->access_lvl_guest);

        // Asserts that the new user does not have the administrator access level
        $this->assertNotEquals($userAccessLevel, config("\User\Config\UserConfig")->access_lvl_admin);

        // Deletes inserted user after assertions
        $userModel->delete($userId, TRUE);
    }

    /**
     * Insert a new user into database
     */
    private static function insertUser($userType, $username, $userEmail, $userPassword) {
        $user = array(
            'id' => 0,
            'fk_user_type' => $userType,
            'username' => $username,
            'email' => $userEmail,
            'password' => $userPassword,
            'password_confirm' => $userPassword,
        );

        $userModel = new \User\Models\User_model();

        return $userModel->insert($user);
    }
}