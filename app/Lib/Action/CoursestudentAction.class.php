<?php
import('ORG.Util.Cookie');
class CoursestudentAction extends Action{
  public function add(){
    $course_id = $_GET['id'];
    $user_id = Cookie::get('userid');
    $coursestudent = M('coursestudent');

    $data['user_id'] = $user_id;
    $data['course_id'] = $course_id;
    $data['score'] = 0;
    $result = $coursestudent->add($data);
    if ($result) {
      $this->assign("jumpUrl","__APP__/User/courseindex/id/{$course_id}");
      $this->success("加入课程成功！即将跳转至该课程的页面！");
    }else{
      $this->assign("jumpUrl","__APP__/Courseinfo/index/id/$course_id");
      $this->error("加入课程失败！");
    }
  }
}
?>