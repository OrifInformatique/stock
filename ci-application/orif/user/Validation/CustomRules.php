<?php
/**
 * Custom rules for form validation
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace User\Validation;


use User\Models\User_model;
use User\Models\User_type_model;

class CustomRules
{

    /**
     * Checks that a username doesn't allready exist
     *
     * @param string $username = Username to check
     * @param int $user_id = ID of the user if it is an update
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function cb_unique_username($username, $user_id) : bool
    {
        $user = (new User_model())->withDeleted()->where('username', [$username])->first();
        return is_null($user) || $user['id']==$user_id;
    }

    /**
     * Checks that a user email doesn't allready exist
     *
     * @param string $useremail = user email to check
     * @param int $user_id = ID of the user if it is an update
     * @return boolean = TRUE if the user email is unique, FALSE otherwise
     */
    public function cb_unique_useremail($useremail, $user_id) : bool
    {
        $user = (new User_model())->withDeleted()->where('email', [$useremail])->first();
        return is_null($user) || $user['id']==$user_id;
    }
    
    /**
     * Checks that a user type exists in the database
     *
     * @param integer $user_type_id = Id of the user type to check
     * @return boolean = TRUE if the user type exists, FALSE otherwise
     */
    public function cb_not_null_user_type($user_type_id) : bool
    {
        return !is_null((new User_type_model())->find($user_type_id));
    }
}