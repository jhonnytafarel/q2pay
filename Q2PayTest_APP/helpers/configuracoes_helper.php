<?php

function check_session(){

    $_this =& get_instance();

    if(!$_this->native_session->get('user_id')){

        redirect('login');
    }
}

function check_session_admin(){

    $_this =& get_instance();

    if(!$_this->native_session->get('user_id_admin')){

        redirect('ctadmin/login');
    }
}


?>