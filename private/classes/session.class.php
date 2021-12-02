<?php

class Session {
    private $member_id;
    public $username;
    public $user_level;
    private $last_login;
    public const MAX_LOGIN_AGE = 60 * 60 * 24; // one day

    public function __construct() {
        session_start();
        $this->check_stored_login();
    }
    
    public function login($member) {
        if($member) {
            // protect against session fixation attacks
            session_regenerate_id();

            $this->member_id = $member->id;
            $_SESSION['member_id'] = $member->id;
            
            $this->username = $member->username;
            $_SESSION['username'] = $member->username;

            $this->user_level = $member->user_level;
            $_SESSION['user_level'] = $member->user_level;
            
            $this->last_login = $_SESSION['last_login'] = time();
        }
        return true;
    }

    public function is_logged_in() {
       // return isset($this->member_id);
       return isset($this->member_id) && $this->last_login_is_recent();
    }

    public function logout() {
        // unset both the session and the property
        unset($_SESSION['member_id']);
        unset($_SESSION['username']);
        unset($_SESSION['last_login']);
        unset($this->member_id);
        unset($this->username);
        unset($this->last_login);
        return true;
    }

    private function check_stored_login() {
        if(isset($_SESSION['member_id'])) {
            $this->member_id =  $_SESSION['member_id'];
            $this->username =  $_SESSION['username'];
            $this->last_login=  $_SESSION['last_login'];
        }
    }

    private function last_login_is_recent() {
        if(!isset($this->last_login)) {
            return false;
        } elseif($this->last_login * self::MAX_LOGIN_AGE < time()) {
           return false; 
        } else {
            return true;
        }
    }

    public function message($msg="") {
        if(!empty($msg) ) {
            // this is a "set" message
            $_SESSION['message'] = $msg;
            return true;
        } else {
            // this is a "get" message
            return $_SESSION['message'];
        }
    }

    /**
 * [verify_user_level description]
 *
 * @param   [type]  $user_level  [$user_level description]
 */
    static public function verify_user_level() {
        //isset($this->user_level);
        if($_SESSION['user_level'] == 'a') {
        
        } elseif($_SESSION['user_level'] == 'm') {
            redirect_to(url_for('/birds/index.php'));
        } else {
            $errors[] = "Login was unsuccessful, please try again.";
        }
    }
    
}

