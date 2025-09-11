<?php
/**
 * Model User_model this represents the user table
 *
 * @author      Orif (ViDi,HeMa)
 * @link        https://github.com/OrifInformatique
 * @copyright   Copyright (c), Orif (https://www.orif.ch)
 */
namespace User\Models;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;

class User_model extends \CodeIgniter\Model{
    protected $table='user';
    protected $primaryKey='id';
    protected $allowedFields=['archive','date_creation','email','username','password','fk_user_type','azure_mail'];
    protected $useSoftDeletes=true;
    protected $deletedField="archive";
    private $user_type_model=null;
    protected $validationRules;
    protected $validationMessages;

    // hashPassword callback function, to be called before inserting or updating user
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        $this->user_type_model=new User_type_model();
        $this->validationRules=[
            'id' => [
                'rules' => 'permit_empty|numeric'
            ],
            'username' =>
                ['label' => lang('user_lang.field_username'),
                 'rules' => 'cb_unique_username[{id}]|required|trim|'.
                            'min_length['.config('\User\Config\UserConfig')->username_min_length.']|'.
                            'max_length['.config('\User\Config\UserConfig')->username_max_length.']'],
            'fk_user_type' =>
                ['label' => lang('user_lang.field_usertype'),
                 'rules' => 'required|cb_not_null_user_type'],
            'password' =>
                ['label' => lang('user_lang.field_password'),
                 'rules' => 'required|trim|'.
                            'min_length['.config("\User\Config\UserConfig")->password_min_length.']|'.
                            'max_length['.config("\User\Config\UserConfig")->password_max_length.']|'.
                            'matches[password_confirm]'],
            'email' =>
                ['label' => lang('user_lang.field_email'),
                 'rules' => 'cb_unique_useremail[{id}]|required|valid_email|'.
                            'max_length['.config("\User\Config\UserConfig")->email_max_length.']']
        ];

        $this->validationMessages=[
            'username' =>
                ['cb_unique_username' => lang('user_lang.msg_err_username_not_unique')],
            'email'=>
                ['cb_unique_useremail' => lang('user_lang.msg_err_useremail_not_unique')],
            'fk_user_type' =>
                ['cb_not_null_user_type' => lang('user_lang.msg_err_user_type_not_exist')],
            'password' =>
                ['matches' => lang('user_lang.msg_err_password_not_matches')],
        ];

        parent::__construct($db, $validation);
    }

    /**
     * Callback method to hash the password before inserting or updating it
     *
     * @param array $data : Datas array used by the callback method
     */
    public function hashPassword(array $data) {
        if (! isset($data['data']['password'])) return $data;

        $data['data']['password'] = password_hash($data['data']['password'], config('\User\Config\UserConfig')->password_hash_algorithm);
        return $data;
    }

    /**
     * Check username and password for login
     *
     * @param string $username
     * @param string $password
     * @return boolean true on success false otherwise
     */
    public function check_password_name($username, $password){
        $user=$this->where("username",$username)->first();
        //If a user is found we can verify his password because if his archive is not empty, he is not in the array
        if (!is_null($user)){
            return password_verify($password,$user['password']);
        }
        else{
            return false;

        }
    }

    /**
     * @param string $email
     * @param string $password
     * @return bool true on success false otherwise
     */
    public function check_password_email($email,$password){
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return false;
        }
        $user = $this->where('email',$email)->first();
        if (!is_null($user)){
            return password_verify($password,$user['password']);
        }
        else{
            return false;
        }
    }

    /**
     * return the access level of an user
     * @param $user
     * @return mixed
     */
    public function get_access_level($user){
        if ($this->user_type_model==null){
            $this->user_type_model=new User_type_model();

        }
        if (is_array($user) ){
            $user["access_level"] = $this->user_type_model->getWhere(['id'=>$user["fk_user_type"]])->getRow()->access_level;
            return $user["access_level"];
        } else {
            $user->access_level = $this->user_type_model->getWhere(['id'=>$user->fk_user_type])->getRow()->access_level;
            return $user->access_level;
        }
    }
}
