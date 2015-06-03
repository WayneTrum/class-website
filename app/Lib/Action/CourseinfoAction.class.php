<?php
import('ORG.Util.Cookie');
class CourseinfoAction extends Action{
  public function index(){
    $course_id = $_GET['id'];
    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');
    $course = new CourseModel();
    $courseinfo = new CourseinfoModel();
    $coursestudent = new CoursestudentModel();

    $message = '';
    $gotobutton = '';
    $gotourl = "";
    $courselist = $course->where("course_id='$course_id' and course_teacher_id='$userid'")->select();
    $courseinfolist = $courseinfo->where("course_id='$course_id'")->find();
    $coursestudentlist = $coursestudent->where("user_id='$userid' and course_id='$course_id'")->select();
    #the couseinfo dose not exist!
    if (empty($courseinfolist)) {
        #usertype is teacher and the teacher beleng to this course 
       if (!empty($courselist) and $usertype === 'Teacher') {
           #add a courseinfo of this course
            $this->assign("jumpUrl","__APP__/Courseinfo/add/id/{$course_id}");
            $this->error("该课程还未添加课程介绍！即将前往添加页面！");
       }
       else{
            $message = "本课程还未开放！";
            $this->assign('message',$message);
            $this->assign('usertype',$usertype);
            $this->assign('username',$username);
            $this->assign('userid',$userid);
            $this->display();
       }
    }
    #thecourseinfo exist!
    else{
        if ($username) {
            if ($usertype === 'User') {
                if (!empty($coursestudentlist)) {
                    $gotobutton = '进入课程';
                    $gotourl = "__APP__/{$usertype}/courseindex/id/{$course_id}";
                    $this->assign('gotourl',$gotourl);
                    $this->assign('gotobutton',$gotobutton);
                    $this->assign('course',$courselist);
                    $this->assign('courseinfo',$courseinfolist);
                    $this->assign('usertype',$usertype);
                    $this->assign('username',$username);
                    $this->assign('userid',$userid);
                    $this->display();
                }else{
                    $gotobutton = '加入课程';
                    $gotourl = "__APP__/Coursestudent/add/id/{$course_id}";
                    $this->assign('gotourl',$gotourl);
                    $this->assign('gotobutton',$gotobutton);
                    $this->assign('course',$courselist);
                    $this->assign('courseinfo',$courseinfolist);
                    $this->assign('usertype',$usertype);
                    $this->assign('username',$username);
                    $this->assign('userid',$userid);
                    $this->display();
                }
            }else{
                if (!empty($courselist)) {
                    $gotobutton = '进入课程';
                    $gotourl = "__APP__/{$usertype}/courseindex/id/{$course_id}";
                    $this->assign('gotourl',$gotourl);
                    $this->assign('gotobutton',$gotobutton);
                    $this->assign('course',$courselist);
                    $this->assign('courseinfo',$courseinfolist);
                    $this->assign('usertype',$usertype);
                    $this->assign('username',$username);
                    $this->assign('userid',$userid);
                    $this->display();
                }else{
                    $gotobutton = '无法进入课程';
                    $gotourl = '#';
                    $this->assign('gotourl',$gotourl);
                    $this->assign('gotobutton',$gotobutton);
                    $this->assign('course',$courselist);
                    $this->assign('courseinfo',$courseinfolist);
                    $this->assign('usertype',$usertype);
                    $this->assign('username',$username);
                    $this->assign('userid',$userid);
                    $this->display();
                }
                
            }
        }else{
            $gotobutton = '加入课程';
            $gotourl = "__APP__/User/login";
            $this->assign('gotourl',$gotourl);
            $this->assign('gotobutton',$gotobutton);
            $this->assign('course',$courselist);
            $this->assign('courseinfo',$courseinfolist);
            $this->display();
        }
    }
  }

  public function add(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $courselist = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $usertype = Cookie::get('usertype');
    $userid = Cookie::get('userid');

    $this->assign('courselist',$courselist);
    $this->assign('usertype',$usertype);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->display();
  }

  public function addcourseinfo(){
    $course_id = $_POST['course_id'];
    $courseinfo = D("courseinfo");

    $courseinfo->create();
    $result = $courseinfo->add();
    if ($result) {
        $this->assign("jumpUrl","__APP__/Courseinfo/index/id/$course_id");
        $this->success("添加成功！");
    }else{
        $this->assign("jumpUrl","__APP__/Courseinfo/add/id/$course_id");
        $this->error("添加失败！");
    }
  }
}
?>