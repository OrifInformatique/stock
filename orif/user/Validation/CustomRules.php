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
     * Callback method for change_password validation rule
     *
     * @param string $pwd = The previous password
     * @param string $user = The username
     * @return boolean = Whether or not the combination is correct
     */
    public function old_password_check($pwd, $user)
    {
        return (new \User\Models\User_model())->check_password_name($user, $pwd);
    }
    public function cb_not_null_user($user_id)
    {
        return $user_id == 0 || !is_null((new \User\Models\User_model())->withDeleted()->find($user_id));
    }
    /**
     * Checks that a username doesn't exist
     *
     * @param string $username = Username to check
     * @param int $user_id = ID of the user if it is an update
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function cb_unique_user($username, $user_id) : bool
    {
        $user = (new \User\Models\User_model())->withDeleted()->where('username', [$username])->first();
        return is_null($user) || $user['id'] == $user_id;
    }
    /**
     * Checks that an user type exists
     *
     * @param integer $user_type_id = Id of the user type to check
     * @return boolean = TRUE if the user type exists, FALSE otherwise
     */
    public function cb_not_null_user_type($user_type_id) : bool
    {
        return !is_null((new User_type_model())->find($user_type_id));
    }
}