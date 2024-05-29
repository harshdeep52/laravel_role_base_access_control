<?php 

if(!function_exists('userROles')){
       function userROles(){
        $roles = array(
                'admin' => "Admin",
                'user'  => "User",
        );
        return $roles;
       } 
}
