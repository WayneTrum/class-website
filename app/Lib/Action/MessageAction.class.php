<?php
class MessageAction extends Action{
  public function index(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $courselist = $course->where("course_id='$course_id'")->find();
    $this->assign("courselist",$courselist);
    $this->display();
  }

  public function add(){
    $course = new CourseModel();
    $course_id = $_POST['course_id'];
    $message = D('message');
    if ($course->where("course_id='$course_id'")->find()) {
      $message->create();
      $result = $message->add();
      if ($result) {
        $this->assign("jumpUrl","__APP__/Teacher/courseindex/id/{$course_id}");
        $this->success("add success!");
      }else{
        $this->assign("jumpUrl","__APP__/Message/index");
        $this->error("failed");
      }
    }
  }
}
?>