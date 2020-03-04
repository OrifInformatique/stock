<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Administraton
 *
 * @author      Orif (ViDi)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 * @version     2.0
 */
class Admin extends MY_Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        /* Define controller access level */
        $this->access_level = $this->config->item('access_lvl_admin');

        parent::__construct();

        // Load required items
        $this->load->library('form_validation')->model(['user_model', 'user_type_model']);

        // Assign form_validation CI instance to this
        $this->form_validation->CI =& $this;
    }

    /**
     * Displays the list of users
     *
     * @param boolean $with_deleted = Display archived users or not
     * @return void
     */
    public function list_user($with_deleted = FALSE)
    {
        if ($with_deleted) {
            $users = $this->user_model->with_deleted()->get_all();
        } else {
            $users = $this->user_model->get_all();
        }

        $output = array(
            'users' => $users,
            'user_types' => $this->user_type_model->dropdown('name'),
            'with_deleted' => $with_deleted
        );
        $this->display_view('user/admin/list_user', $output);
    }

    /**
     * Adds or modify a user
     *
     * @param integer $user_id = The id of the user to modify, leave blank to create a new one
     * @return void
     */
    public function save_user($user_id = 0)
    {
		$oldName = NULL;
		$oldUsertype = NULL;
		if (count($_POST) > 0) {
			$user_id = $this->input->post('id');
			$oldName = $this->input->post('user_name');
            if($_SESSION['user_id'] != $user_id) {
				$oldUsertype = $this->input->post('user_usertype');
			}

			$this->form_validation->set_rules(
				'id', 'id',
				'callback_cb_not_null_user',
				['cb_not_null_user' => $this->lang->line('msg_err_user_not_exist')]
			);
			$this->form_validation->set_rules('user_name', 'lang:user_name',
				[
					'required', 'trim',
					'min_length['.$this->config->item('username_min_length').']',
					'max_length['.$this->config->item('username_max_length').']',
					"callback_cb_unique_user[{$user_id}]"
				],
				['cb_unique_user' => $this->lang->line('msg_err_user_not_unique')]
			);
			$this->form_validation->set_rules('user_usertype', 'lang:user_usertype',
				['required', 'callback_cb_not_null_user_type'],
				['cb_not_null_user_type' => $this->lang->line('msg_err_user_type_not_exist')]
			);
	
			if ($user_id == 0) {
				$this->form_validation->set_rules('user_password', lang('field_password'), [
					'required', 'trim',
					'min_length['.$this->config->item('password_min_length').']',
					'max_length['.$this->config->item('password_max_length').']'
				]);
				$this->form_validation->set_rules('user_password_again', $this->lang->line('field_password_confirm'), [
					'required', 'trim', 'matches[user_password]',
					'min_length['.$this->config->item('password_min_length').']',
					'max_length['.$this->config->item('password_max_length').']'
				]);
			}

			if ($this->form_validation->run()) {
				$user = array(
					'fk_user_type' => $this->input->post('user_usertype'),
					'username' => $this->input->post('user_name')
				);
				if ($user_id > 0) {
					$this->user_model->update($user_id, $user);
				} else {
					$password = $this->input->post('user_password');
					$user['password'] = password_hash($password, $this->config->item('password_hash_algorithm'));
					$this->user_model->insert($user);
				}
				redirect('user/admin/list_user');
			}
		}

        $output = array(
            'title' => $this->lang->line('title_user_'.((bool)$user_id ? 'update' : 'new')),
            'user' => $this->user_model->with_deleted()->get($user_id),
            'user_types' => $this->user_type_model->dropdown('name'),
            'user_name' => $oldName,
            'user_usertype' => $oldUsertype
		);

        $this->display_view('user/admin/save_user', $output);
    }

    /**
     * Deletes or deactivate a user depending on $action
     *
     * @param integer $user_id = ID of the user to affect
     * @param integer $action = Action to apply on the user:
     *  - 0 for displaying the confirmation
     *  - 1 for deactivating (soft delete)
     *  - 2 for deleting (hard delete)
     * @return void
     */
    public function delete_user($user_id, $action = 0)
    {
        $user = $this->user_model->with_deleted()->get($user_id);
        if (is_null($user)) {
            redirect('user/admin/list_user');
        }

        switch($action) {
            case 0: // Display confirmation
                $output = array(
                    'user' => $user,
                    'title' => lang('title_user_delete')
                );
                $this->display_view('user/admin/delete_user', $output);
                break;
            case 1: // Deactivate (soft delete) user
                if ($_SESSION['user_id'] != $user->id) {
                    $this->user_model->delete($user_id, FALSE);
                }
                redirect('user/admin/list_user');
            case 2: // Delete user
                if ($_SESSION['user_id'] != $user->id) {
                    $this->user_model->delete($user_id, TRUE);
                }
                redirect('user/admin/list_user');
            default: // Do nothing
                redirect('user/admin/list_user');
        }
    }
    
    /**
     * Reactivate a disabled user.
     *
     * @param integer $user_id = ID of the user to affect
     * @return void
     */
    public function reactivate_user($user_id)
    {
        $user = $this->user_model->with_deleted()->get($user_id);
        if (is_null($user)) {
            redirect('user/admin/list_user');
        } else {
            $this->user_model->undelete($user_id);
            redirect('user/admin/save_user/'.$user_id);
        }
    }

    /**
     * Displays a form to change a user's password
     *
     * @param integer $user_id = ID of the user to update
     * @return void
     */
    public function password_change_user($user_id)
    {
		if (count($_POST) > 0) {
			$this->form_validation->set_rules(
				'id', 'id',
				'callback_cb_not_null_user',
				$this->lang->line('msg_err_user_not_exist')
			);
			$this->form_validation->set_rules('user_password_new', lang('field_new_password'), [
				'required', 'trim',
				'min_length['.$this->config->item('password_min_length').']',
				'max_length['.$this->config->item('password_max_length').']'
			]);
			$this->form_validation->set_rules('user_password_again', $this->lang->line('field_password_confirm'), [
				'required', 'trim', 'matches[user_password_new]',
				'min_length['.$this->config->item('password_min_length').']',
				'max_length['.$this->config->item('password_max_length').']'
			]);

			if ($this->form_validation->run()) {
				$password = $this->input->post('user_password_new');
				$password = password_hash($password, $this->config->item('password_hash_algorithm'));
				$this->user_model->update($user_id, ['password' => $password]);
				redirect('user/admin/list_user');
			}
		}

        $user = $this->user_model->with_deleted()->get($user_id);
        if (is_null($user)) redirect('user/admin/list_user');

        $output = array(
            'user' => $user,
            'title' => $this->lang->line('title_user_password_reset')
        );

        $this->display_view('user/admin/password_change_user', $output);
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
        $user = $this->user_model->with_deleted()->get_by('username', $username);
        return is_null($user) || $user->id == $user_id;
    }
    /**
     * Checks that an user exists
     *
     * @param integer $user_id = Id of the user to check
     * @return boolean = TRUE if the id is 0 or if the user exists, FALSE otherwise
     */
    public function cb_not_null_user($user_id) : bool
    {
        return $user_id == 0 || !is_null($this->user_model->with_deleted()->get($user_id));
    }
    /**
     * Checks that an user type exists
     *
     * @param integer $user_type_id = Id of the user type to check
     * @return boolean = TRUE if the user type exists, FALSE otherwise
     */
    public function cb_not_null_user_type($user_type_id) : bool
    {
        return !is_null($this->user_type_model->get($user_type_id));
    }
}
