<?php
import('ORG.Util.Cookie');
class TeacherAction extends Action{
  public function add(){
    $teacher_name = $_POST['teacher_name'];
    $teacher = D("teacher");
    $teacher->create();
    $result = $teacher->add();
    if($result){
      if (Cookie::get('usertype') === 'Manager') {
        $this->assign("jumpUrl","__APP__/Manager/index");
        $this->success("添加成功！");
      }else{
        $this->assign("jumpUrl","__APP__/Teacher/login");
        $this->success("注册成功！");
      }
    }else{
      if (Cookie::get('usertype') === 'Manager') {
        $this->assign("jumpUrl","__APP__/Manager/addteacher");
        $this->success("添加失败！");
      }else{
        $this->assign("jumpUrl","__APP__/Teacher/register");
        $this->error("注册失败！");
      }
      
    }
  }
    

  public function register(){
    $this->display();
  }

  public function login(){
    $this->display();
  }

  public function index(){
    $teacher_id = Cookie::get('userid');
    $teacher_name = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    if ($usertype === 'Teacher') {
      $course = new CourseModel();
      $courselist = $course->where("course_teacher_id='$teacher_id'")->select();

      $this->assign('courselist',$courselist);
      $this->assign('usertype',$usertype);
      $this->assign('username',$teacher_name);
      $this->assign('userid',$teacher_id);

      $this->display();
    }elseif ($usertype === 'Student') {
      $this->assign("jumpUrl","__APP__/User/index");
      $this->error("即将跳转至学生主页！");
    }else{
      $this->assign("jumpUrl","__APP__/User/login");
      $this->error("请先登录！");
    }
  }

  public function checklogin(){
    $teacher_name = $_POST['teacher_name'];
    $teacher_passwd = $_POST['teacher_passwd'];
    $teacher = D("teacher");
    $teacherinfo = $teacher->where("teacher_name='$teacher_name'")->find();
    if(!empty($teacherinfo)){
      if($teacherinfo['teacher_passwd'] == $teacher_passwd){
        Cookie::set('userid',$teacherinfo['teacher_id'],time()+3600*24);
        Cookie::set('username',$teacher_name,time()+3600*24);
        Cookie::set('lastlogintime',time(),time()+3600*24);
        $this->assign("jumpUrl","__APP__/Index/index");
        $this->success("登录成功！");
      }else{
        $this->assign("jumpUrl","__APP__/Teacher/login");
        $this->error("密码错误！");
      }
    }else{
      $this->assign("jumpUrl","__APP__/Teacher/login");
      $this->error("用户名不存在！");
    }
  }

  public function loginout(){
    Cookie::delete('username');
    Cookie::delete('usertype');
    Cookie::delete('lastlogintime');
    $this->assign("jumpUrl","__APP__/Index/index");
    $this->success("您已退出成功！");
  }

  public function courseindex(){
    $course_id = $_GET['id'];
    $message = new MessageModel();
    $course = new CourseModel();
    
    $messagelist = $message->where("course_id='$course_id'")->select();
    $result = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $this->assign('course',$result);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->assign('messagelist',$messagelist);
    $this->display();
  }
}
?>