<?php
class ContentModel extends Model{
  protected $_validate = array(
    array('title','require','标题必须填写'),
    array('content','require','内容必须填写'),
    );

  protected $auto = array(
    array('addtime','time',1,'function'),
    );
}
?>