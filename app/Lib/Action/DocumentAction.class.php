<?php
import('ORG.Util.Cookie');
class DocumentAction extends Action{
  public function index(){
    $course_id = $_GET['id'];
    $usertype = Cookie::get('usertype');
    if ($usertype === 'Teacher') {
        $this->assign("jumpUrl","__APP__/Document/teacherindex/id/{$course_id}");
        $this->display();
    }elseif ($usertype === 'User') {
        $this->assign("jumpUrl","__APP__/Document/studentindex/id/{$course_id}");
    }else{
        $this->assign("jumpUrl","__APP__/Index/index");
    }
  }
  public function Teacher(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $zhang = new ZhangModel();
    $zhanglist = $zhang->where("course_id='$course_id'")->select();
    $result = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $this->assign('course',$result);
    $this->assign('zhanglist',$zhanglist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->display();
  }

  public function User(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $zhang = new ZhangModel();
    $zhanglist = $zhang->where("course_id='$course_id'")->select();
    $result = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $this->assign('course',$result);
    $this->assign('zhanglist',$zhanglist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->display();
  }
}
?>