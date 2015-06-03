<?php
import('ORG.Util.Cookie');
class UserAction extends Action{
  public function add(){
    $username = $_POST['username'];
    $user = D("user");
    $Cookieusername = Cookie::get('username');
    $Cookieusertype = Cookie::get('usertype');

    $user->create();
    $result = $user->add();
    if($result){
      if (!empty($Cookieusername) and $Cookieusertype === 'Manager') {
        $this->assign("jumpUrl","__APP__/{$Cookieusertype}/index");
        $this->success("添加学生成功！");
      }else{
        $this->assign("jumpUrl","__APP__/User/login");
        $this->success("注册成功！");
      }
    }else{
      if (!empty($Cookieusername) and $Cookieusertype === 'Manager') {
        $this->assign("jumpUrl","__APP__/{$Cookieusertype}/addstudent");
        $this->success("注册学生不成功！");
      }else{
        $this->assign("jumpUrl","__APP__/User/register");
        $this->success("注册不成功！");
      }
    }
  } 

  public function register(){
    $usertype = Cookie::get('usertype');
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');

    $this->assign('usertype',$usertype);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function login(){
    $usertype = Cookie::get('usertype');
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');

    $this->assign('usertype',$usertype);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function index(){
    $course = new CourseModel();
    $coursestudent = new CoursestudentModel();
    $usertype = Cookie::get('usertype');
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $list = array();

    $coursestudentlist = $coursestudent->where("user_id='$userid'")->select();
    foreach ($coursestudentlist as $key) {
      $course_id = $key['course_id'];
      $result = $course->where("course_id='$course_id'")->find();
      if ($result) {
        $list[] = $result;
      }
    }

    $this->assign('courselist',$list);
    $this->assign('usertype',$usertype);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function checklogin(){
    $usertype = $_POST['usertype'];
    $username = $_POST['username'];
    $passwd = $_POST['passwd'];
    if ($usertype === 'User') {
      $user = D("user");
      $userinfo = $user->where("username='$username'")->find();

      if(!empty($userinfo)){
        if($userinfo['passwd'] == $passwd){
          Cookie::set('userid',$userinfo['user_id'],time()+3600*24);
          Cookie::set('username',$username,time()+3600*24);
          Cookie::set('usertype','User',time()+3600*24);
          Cookie::set('lastlogintime',time(),time()+3600*24);
          $this->assign("jumpUrl","__APP__/User/index");
          $this->success("登录成功！");
        }else{
          $this->assign("jumpUrl","__APP__/User/login");
          $this->error("密码错误！");
        }
      }else{
        $this->assign("jumpUrl","__APP__/User/login");
        $this->error("用户名不存在！");
      }
    }elseif($usertype === 'Teacher'){
      $teacher = D("teacher");
      $userinfo = $teacher->where("teacher_name='$username'")->find();
      if(!empty($userinfo)){
        if($userinfo['teacher_passwd'] == $passwd){
          Cookie::set('userid',$userinfo['teacher_id'],time()+3600*24);
          Cookie::set('username',$username,time()+3600*24);
          Cookie::set('usertype','Teacher',time()+3600*24);
          Cookie::set('lastlogintime',time(),time()+3600*24);
          $this->assign("jumpUrl","__APP__/Teacher/index");
          $this->success("登录成功！");
        }else{
          $this->assign("jumpUrl","__APP__/User/login");
          $this->error("密码错误！");
        }
      }else{
        $this->assign("jumpUrl","__APP__/User/login");
        $this->error("用户名不存在！");
      }
    }else{
      $this->assign("jumpUrl","__APP__/Index/index");
      $this->error("unknown error!");
    }
  }

  public function loginout(){
    Cookie::delete('username');
    Cookie::delete('usertype');
    Cookie::delete('userid');
    Cookie::delete('lastlogintime');
    $this->assign("jumpUrl","__APP__/Index/index");
    $this->success("您已退出成功！");
  }

  public function courseindex(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $message = new MessageModel();
    $usertype = Cookie::get('usertype');
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');

    $courselist = $course->where("course_id='$course_id'")->find();
    $messagelist = $message->where("course_id='$course_id'")->select();
    $this->assign('course',$courselist);
    $this->assign('messagelist',$messagelist);
    $this->assign('usertype',$usertype);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->display();
  }
}
?>