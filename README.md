Getting started
----------
First, you have to create a new class where you will define all your rules. Let's start with this:

```php
<?php
require_once "SimpleRoles.php";

class Ability extends SimpleRoles {
    
    function __construct($user) {
        parent::__construct();

        // Here is where you'll define your rules
    }

}
```

We place our rules inside the `__construct` function.

```php
<?php
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
        $this->can('update_article');
        $this->can('delete_article');
    }

    if(in_array('moderator', $user_roles)) {
        $this->can('read_article');
        $this->can('update_article');
    }

    if(in_array('guest', $user_roles)) {
        $this->cannot('all');
        $this->can('read_article');
    }
}
```

The code is self-explanatory. `all` is a special keyword which will match every rule.
Now, we just have to add code to our main application.
For example:

```php
<?php
...
$a = new Ability($session_current_user);
...
if(isset($_POST['update'])) {
    $a->authorize('update_article');
    // ... We're authorized. Update the article.
} else if(isset($_POST['delete'])) {
    $a->authorize('delete_article');
    // ... We're authorized. Delete the article.
} else {
    $a->authorize('read_article');
    // ... We're authorized. Display the article.
}
```

`$session_current_user` is an instance of some User model, representing the current logged in user. In the Ability class, we called `$user->getRoles()` to get an array of enabled roles for the current user.

Now, if the user is not authorized to complete the action, an exception will be raised. You can override this behavior by adding a special function called *unauthorized* to your Ability class, for example:

```php
<?php
protected function unauthorized($action) {
  echo "You are not authorized to view this page\n";
  // ... Redirect to home page
  exit;
}
```

If you just want to check if an user is authorized or not to do an action, without doing extra jobs, just call `$a->is_authorized('your action')`.
