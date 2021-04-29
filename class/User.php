<?php
require_once __DIR__.'/Error.php';
class User
{
    /**
     *  数据库连接对象
     * @var
     */
    private $_db;

    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }

    /**
     *  用户注册
     * @param $username
     * @param $password
     * @return array
     * @throws Exception
     */
    public function regist($username, $password)
    {
        if (empty($username)) {
            throw new Exception('用户名不能为空', Errors::USER_CONNOT_NULL);
        }
        if (empty($password)) {
            throw new Exception('用户密码不能为空', Errors::PASSWORD_CONNOT_NULL);
        }

        if ($this->_isUsernameExists($username)) {
            throw new Exception('用户已经存在',Errors::USERNAME_EXISTS);
        }

        $sql = "insert into `user` (`username`,`password`,`create_time`) values (:username, :password, :create_time)";
        $addtime = date('Y-m-d H:i:s',time());
        $password = $this->_md5($password);

        $pdo = $this->_db->prepare($sql);
        $pdo->bindParam(':username',$username);
        $pdo->bindParam(':password',$password);
        $pdo->bindParam(':create_time',$addtime);
        if (!$pdo->execute()) {
            throw new Exception('注册失败',Errors::USER_REGIST);
        }
        return [
                'username' => $username,
                'userid'   => $this->_db->lastInsertId(),
                'addtime'  => $addtime
        ];
    }

    /**
     * 用户登录
     * @param $username string 用户名
     * @param $password string 密码
     * @return mixed
     * @throw Exception
     */
    public function login($username, $password)
    {
        if (empty($username)){
            return '用户名不能为空';
        }
        if (empty($password)) {
            return '用户密码不能为空';
        }
        $sql = "select * from `user` where `username`=:username and `password`=:password";
        $password = $this->_md5($password);
        $pdo = $this->_db->prepare($sql);
        $pdo->bindParam(':username',$username);
        $pdo->bindParam(':password', $password);
        if (!$pdo->execute()) {
            throw new Exception('登录失败',Errors::LOGIN_FAILURE);
        }

        $res = $pdo->fetch(PDO::FETCH_ASSOC);
        if (!$res) {
            throw new Exception('用户名或密码错误',Errors::USERNAME_OR_PASSWORD_FAILURE);
        }
        return $res;
    }

    /**
     *  判断用户名是否已经存在
     * @param $username
     * $return bool
     */
    private function _isUsernameExists($username)
    {
        $sql = "select * from `user` where `username`=:username";
        $pre = $this->_db->prepare($sql);
        $pre->bindParam(':username', $username);
        $pre->execute();
        $res = $pre->fetch(PDO::FETCH_ASSOC);
        return $res;
    }

    private function _md5($password)
    {
        return md5($password.API);
    }


}