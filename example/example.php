<?php

  require_once "../src/SimpleRoles.php";

  /* Place this class in a separate file */

  class Ability extends SimpleRoles {
    function __construct($user) {
      parent::__construct();

      // You should define here your rules

      $user_roles = array();
      if($user != null)
        $user_roles = $user['roles'];

      if(in_array('admin', $user_roles)) {
        $this->can('read_article');
        $this->can('write_article');
        $this->can('delete_article');
      }

      if(in_array('moderator', $user_roles)) {
        $this->can('read_article');
        $this->can('write_article');
      }

      if(in_array('guest', $user_roles)) {
        $this->cannot('all');
      }
    }

    protected function unauthorized($action) {
      echo "You are not authorized to view this page\n";
      exit;
    }
  }

  /* Your code. Place this inside your controllers. */

  // Use your User model instead of this array
  $current_user = array('username' => 'Chuck',
                'email' => 'chuckb@buymore.com',
                'roles' => array('admin', 'moderator')
               );
  #$a = new Ability($current_user, $object, 'eval');
  $a = new Ability($current_user);
  $a->authorize('delete_article');

?>