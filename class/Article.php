<?php
require_once __DIR__.'/Error.php';

class Article
{
    /**
     * 数据库操作对象
     * $var PDO
     */
    protected $_db;

    public function __construct(PDO $_db)
    {
        $this->_db = $_db;
    }

    public function add_article($userid,$title, $content)
    {
        if (empty($title)) {
            return ['code'=>10001,'msg'=>'文章标题不能为空'];
        }

        if (empty($content)) {
            return ['code'=>10002,'msg'=>'文章内容不能为空'];
        }
        $sql = "insert into `article` (`userid`,`title`, `content`, `addtime`) values (:userid, :title, :content, :addtime)";
        $addtime = date('Y-m-d H:i:s', time());
        $pdo = $this->_db->prepare($sql);
        $pdo->bindParam(':userid',$userid);
        $pdo->bindParam(':title', $title);
        $pdo->bindParam(':content',$content);
        $pdo->bindParam(':addtime', $addtime);
        if($pdo->execute()) {
            return '文章添加成功！';
        } else {
            return '文章添加失败了。。。';
        }


    }
}