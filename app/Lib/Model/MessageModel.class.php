<?php
class MessageModel extends Model{
  protected $validate = array(
    array('message_title','require','通知标题不能为空！'),
    array('message_content','require','通知内容不能为空！'),
    array('course_id','require','通知关联课程id不能为空！'),
    );
}
?>