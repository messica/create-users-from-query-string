<?php

/*
 * Initialization
 */
function cuqs_init() {
    global $cuqs_options;

    if(!empty($_REQUEST['cuqs'])) {
        if(empty($cuqs_options['enabled']))
            die('You do not have permission to perform that action.');
        cuqs($_REQUEST);
    }
}

/*
 * Add users based on $_REQUEST vars
 */
function cuqs($request) {

    global $cuqs_options;

    extract($request);

    if(empty($u))
        die('You cannot create a user without a username. Please try again.');

    if(!empty($r)) {
        //use custom role but make sure it exists first
        $role = get_role($r);
        if(empty($role))
            die('The role ' . $r . ' does not exist. Please try again.');
    }
    else {
        //use default role
        $role = get_role($cuqs_options['default_role']);
    }

    //if no password was provided, use username as password
    if(empty($p))
        $p = $u;

    //are we adding multiple users? TODO: fix multiple user support
    if(!empty($n)) {

//        if(!empty($e))
//            die('You cannot create multiple users with the same email address. Please try again.');
//        for($i = 0; $i==$n; $i++) {
//
//            $result = wp_create_user($u . strval($i+1), $p);
//            //errors will return a WP_Error object
//            if(is_object($result)) {
//                //get error messages
//                $errors = array();
//                foreach($result->errors as $error=>$message)
//                    $errors[] = $message;
//                echo 'Failed creating user ' . $u . strval($i+1) . ': ' . implode(',', $errors) . '<br>';
//            }
//            else {
//                    $user = get_user_by('id', $result);
//                    $user->set_role($role->name);
//                    echo 'Successfully created user ' . $user->user_login . ' with password ' . $p . ' and role ' . $role->name . '<br>';
//            }
//        }
    }
    else {
        //only adding one user
        if(!empty($e))
            $result = wp_create_user($u, $p, $e);
        else
            $result = wp_create_user($u,$p);
        //errors will return a WP_Error object
        if(is_object($result)) {
            //get error messages
            $errors = array();
            foreach($result->errors as $error=>$messages)
                $errors[] = $messages[0];
            echo 'Failed creating user ' . $u . ': ' . implode(',', $errors) . '<br>';
        }
        else {
            $user = get_user_by('id', $result);
            $user->set_role($role->name);
            echo 'Successfully created ' . $user->user_login . ' with password ' . $p . ' and role ' . $role->name . '<br>';
        }
    }
    die('Finished.');
}

function cuqs_add_users() {

}

function cuqs_add_role() {

}