Getting started
----------
First, you have to create a new class where you will define all your rules. Let's start with this:

    require_once "SimpleRoles.php";

    class Ability extends SimpleRoles {
    
        function __construct($user) {
            parent::__construct();

            // You should define here your rules
        }

    }
    
We place our rules inside the `__construct` function.

    function __construct($user) {
        parent::__construct();

        // We put the current user roles in $user_roles.
        // Please note that you can use whatever method you
        // prefer for checking role membership.
        $user_roles = array();
        if($user != null)
            $user_roles = $user->getRoles();

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