<?php
  /*
    Copyright (c) 2012 Daniele Di Sarli

    Permission is hereby granted, free of charge, to any person
    obtaining a copy of this software and associated documentation
    files (the "Software"), to deal in the Software without
    restriction, including without limitation the rights to use,
    copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the
    Software is furnished to do so, subject to the following
    conditions:

    The above copyright notice and this permission notice shall be
    included in all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
    EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
    OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
    NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
    HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
    WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
    FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
    OTHER DEALINGS IN THE SOFTWARE.
  */

  # Inspired by CanCan for Rails

  abstract class SimpleRoles {

    private $permissions;

    public function __construct() {
      $this->permissions = array();
    }

    public function can($action) {
      if($action == 'all') {
        $this->permissions = array('all' => true);
      } else {
        $this->permissions[$action] = true;
      }
    }

    public function cannot($action) {
      if($action == 'all') {
        $this->permissions = array('all' => false);
      } else {
        $this->permissions[$action] = false;
      }
    }

    public function is_authorized($action) {
      if(isset($this->permissions[$action])) {
        if($this->permissions[$action]) {
          return true;
        } else {
          return false;
        }
      } else {
        if(isset($this->permissions['all']) && $this->permissions['all']) {
          return true;
        } else {
          return false;
        }
      }
    }

    public function authorize($action) {
      if(!$this->is_authorized($action)) {
        $this->unauthorized($action);
      }
    }

    protected function unauthorized($action) {
      throw new Exception();
    }

  }

?>