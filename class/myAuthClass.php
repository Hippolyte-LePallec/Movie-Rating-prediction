<?php
class myAuthClass
{
    public static function is_auth($current_session)
    {
        if (isset($current_session['user']) && !empty($current_session['user']))
            return true;
        return false;
    }

    public static function authenticate($username, $password)
    {
        $db = require(dirname(__FILE__) . '/../lib/mypdo.php');
        $fields = array(
            'rowid',
            'username',
            'firstname',
            'lastname',
        );
        $sql = 'SELECT '.implode(', ', $fields).' ';
        $sql .= 'FROM mp_users ';
        $sql .= 'WHERE username = :username AND password = :password';
        $statement = $db->prepare($sql);
        $statement->bindValue(':username', $username, PDO::PARAM_STR); 
        $statement->bindValue(':password', $password, PDO::PARAM_STR); // Non crypter 
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
