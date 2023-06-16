<?php
/**
 * Custom rules for form validation
 *
 * @author      Orif (ViDi,AeDa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */

namespace Stock\Validations;


use Stock\Models\Item_group_model;
use Stock\Models\Stocking_place_model;
use User\Models\User_model;
use User\Models\User_type_model;

class CustomRules
{
    /**
     * Checks that a name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function is_unique_group_name_by_entity(string $name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $item_group_model = new Item_group_model();

        $item_group = $item_group_model->where('name', [$name])
                        ->where('fk_entity_id', $params[1])
                        ->where('item_group_id !=', $params[0])
                        ->first();

        return is_null($item_group);
    }

    /**
     * Checks that a short_name doesn't already exist in an entity
     *
     * @param string $short name = short name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function is_unique_group_short_name_by_entity(string $short_name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $item_group_model = new Item_group_model();

        $item_group = $item_group_model->where('short_name', $short_name)
                        ->where('fk_entity_id', $params[1])
                        ->where('item_group_id !=', $params[0])
                        ->first();

        return is_null($item_group);
    }

    /**
     * Checks that a name doesn't already exist in an entity
     *
     * @param string $name = name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function is_unique_place_name_by_entity(string $name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $stocking_place_model = new Stocking_place_model();

        $stocking_place = $stocking_place_model->where('name', [$name])
                            ->where('fk_entity_id', $params[1])
                            ->where('stocking_place_id !=', $params[0])
                            ->first();

        return is_null($stocking_place);
    }

    /**
     * Checks that a short_name doesn't already exist in an entity
     *
     * @param string $short_name = short name to check
     * @param string $params = contains every parameters needed separated with a comma
     * @return boolean = TRUE if the username is unique, FALSE otherwise
     */
    public function is_unique_place_short_name_by_entity(string $short_name, string $params) : bool
    {
        // Separate the 2 parameters
        $params = explode(',', $params);

        $stocking_place_model = new Stocking_place_model();

        $stocking_place = $stocking_place_model->where('short', $short_name)
                            ->where('fk_entity_id', $params[1])
                            ->where('stocking_place_id !=', $params[0])
                            ->first();

        return is_null($stocking_place);
    }

    /**
     * Callback method for change_password validation rule
     *
     * @param string $pwd = The previous password
     * @param string $user = The username
     * @return boolean = Whether or not the combination is correct
     */
    public function old_password_check($pwd, $user)
    {
        return (new User_model())->check_password_name($user, $pwd);
    }
    public function cb_not_null_user($user_id)
    {
        return $user_id == 0 || !is_null((new User_model())->withDeleted()->find($user_id));
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
        $user = (new User_model())->withDeleted()->where('username', [$username])->first();
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