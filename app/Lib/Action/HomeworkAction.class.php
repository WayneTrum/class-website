<?php
import('ORG.Util.Cookie');
import('ORG.Net.UploadFile');
class HomeworkAction extends Action{
  public function index(){
    $course_id = $_GET['id'];
    $usertype = Cookie::get('usertype');
    $username = Cookie::get('username');
    if (!empty($username)) {
      $this->assign("jumpUrl","__APP__/Homework/{$usertype}/id/{$course_id}");
      $this->success("turn to $usertype page");
    }else{
      $this->assign("jumpUrl","__APP__/User/login");
      $this->success("turn to login page");
    }
  }
  public function Teacher(){
    $course_id = $_GET['id'];
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');
    $course = new CourseModel();
    $courselist = $course->where("course_id='$course_id'")->find();
    $homework = new HomeworkModel();
    $homeworklist = $homework->where("course_id='$course_id'")->select();
    $this->assign('username',$username);
    $this->assign('usertype',$usertype);
    $this->assign('userid',$userid);
    $this->assign('course',$courselist);
    $this->assign('homeworklist',$homeworklist);
    $this->display();
  }

  public function User(){
    $course_id = $_GET['id'];
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');
    $course = new CourseModel();
    $courselist = $course->where("course_id='$course_id'")->find();
    $homework = new HomeworkModel();
    $homeworklist = $homework->where("course_id='$course_id'")->select();
    $this->assign('username',$username);
    $this->assign('usertype',$usertype);
    $this->assign('userid',$userid);
    $this->assign('course',$courselist);
    $this->assign('homeworklist',$homeworklist);
    $this->display();
  }

  public function add(){
    $course_id = $_POST['course_id'];
    $homework_title = $_POST['homework_title'];
    $upload = new UploadFile($_POST['file']);
    $upload->allowExts = array('jpg', 'png');
    $upload->savePath = './../Public/Uploads/homework/teacherimages/';
    if (!$upload->upload()) {
      $this->error($upload->getErrorMsg());
    }else{
      $info = $upload->getUploadFileInfo();
      $homework = M('homework');
      $homework->create();
      $homework->homework_title = $homework_title;
      $homework->homework_img = $info[0]['savename'];
      $homework->course_id = $course_id;
      $result = $homework->add();
      if ($result) {
        $this->assign("jumpUrl","__APP__/Homework/Teacher/id/{$course_id}");
        $this->success("添加成功");
      }else{
        $this->assign("jumpUrl","__APP__/Homework/Teacher/id/{$course_id}");
        $this->error("添加不成功！");
      }
      
    }
  }

  public function studentadd(){
    $course_id = $_POST['course_id'];
    $homework_id = $_POST['homework_id'];
    $userid = Cookie::get('userid');
    $upload = new UploadFile($_POST['file']);
    $upload->allowExts = array('jpg', 'png');
    $upload->savePath = './../Public/Uploads/homework/studentimages/';
    if (!$upload->upload()) {
      $this->error($upload->getErrorMsg());
    }else{
      $info = $upload->getUploadFileInfo();
      $student_work = M('student_work');
      $student_work->homework_id = $homework_id;
      $student_work->user_id = $userid;
      $student_work->answer_img = $info[0]['savename'];
      $result = $student_work->add();
      if ($result) {
        $this->assign("jumpUrl","__APP__/Homework/User/id/{$course_id}");
        $this->success("添加成功");
      }else{
        $this->assign("jumpUrl","__APP__/Homework/User/id/{$course_id}");
        $this->error("添加不成功！");
      }
    }
  }
}
?>