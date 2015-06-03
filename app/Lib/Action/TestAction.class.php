<?php
import('ORG.Util.Cookie');
class TestAction extends Action{
  public function index(){
    $course_id = $_GET['id'];
    $course = new CourseModel();
    $zhang = new ZhangModel();
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');

    $courselist = $course->where("course_id='$course_id'")->find();
    $zhanglist = $zhang->where("course_id='$course_id'")->select();

    if ($usertype === 'Teacher') {
        $urlturn = 'teacherindex';
    }elseif ($usertype === 'User') {
        $urlturn = 'studentindex';
    }

    $this->assign('urlturn',$urlturn);
    $this->assign('zhanglist',$zhanglist);
    $this->assign('course',$courselist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->display();
  }

  public function studentindex(){
    $zhang_id = $_GET['id'];
    $zhang = new ZhangModel();
    $course = new CourseModel();
    $test = new TestModel();
    $student_test = new Student_testModel();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    
    $testlist = $test->where("zhang_id='$zhang_id'")->select();
    $zhanglist = $zhang->where("zhang_id='$zhang_id'")->find();
    $course_id = $zhanglist['course_id'];
    $courselist = $course->where("course_id='$course_id'")->find();
    $result = $student_test->where("zhang_id='$zhang_id' and user_id='$userid'")->find();

    if ($result) {
        $this->assign("jumpUrl","__APP__/Test/studentresult/id/{$zhang_id}");
        $this->success("你已经进行了测试，即将跳转至结果窗口！");
    }else{
        $this->assign('course',$courselist);
        $this->assign('zhang',$zhanglist);
        $this->assign('testlist',$testlist);
        $this->assign('username',$username);
        $this->assign('userid',$userid);
        $this->assign('usertype',$usertype);
        $this->display();
    }
  }

  public function teacherindex(){
    $zhang_id = $_GET['id'];
    $zhang = new ZhangModel();
    $course = new CourseModel();
    $test = new TestModel();
    $testlist = $test->where("zhang_id='$zhang_id'")->select();
    $zhanglist = $zhang->where("zhang_id='$zhang_id'")->find();
    $course_id = $zhanglist['course_id'];
    $courselist = $course->where("course_id='$course_id'")->find();

    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');

    $this->assign('course',$courselist);
    $this->assign('zhang',$zhanglist);
    $this->assign('testlist',$testlist);
    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->display();
  }

  public function addtest(){
    $zhang_id = $_POST['zhang_id'];
    $test = D('test');
    $test->create();
    $result = $test->add();
    if ($result) {
        $this->assign("jumpUrl","__APP__/Test/teacherindex/id/{$zhang_id}");
        $this->success("add success!");
    }else{
        $this->assign("jumpUrl","__APP__/Test/teacherindex/id/{$zhang_id}");
        $this->error("failed!");
    }
  }

  public function testresult(){
    $zhang_id = $_POST['zhang_id'];
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');
    $score = 0;
    $test_number = 0;
    $findstudent_test = new Student_testModel();
    $is_exist = $findstudent_test->where("user_id='$userid' and zhang_id='$zhang_id'")->find();
    if (empty($is_exist)) {
        $student_test = M('student_test');
        $test = new TestModel();
        $testlist = $test->where("zhang_id='$zhang_id'")->select();
    
        foreach ($testlist as $key) {
            $test_id = $key['test_id'];
            if ($key['test_option_right'] === $_POST[$test_id]) {
                $score = $score + 1;
            }
            $test_number = $test_number + 1;
        }
        $score = (int)($score/$test_number*100);
        $data['zhang_id']= $zhang_id;
        $data['user_id']= $userid;
        $data['test_score'] = $score;
        $result = $student_test->add($data);
        if ($result) {
            $this->assign("jumpUrl","__APP__/Test/studentresult/id/{$zhang_id}");
            $this->success("提交成功");
        }else{
            $this->assign("jumpUrl","__APP__/Test/studentindex/id/{$zhang_id}");
            $this->error("提交失败，请稍后再试！");
        }
    }else{
        $this->assign("jumpUrl","__APP__/Test/studentresult/id/{$zhang_id}");
        $this->error("你已经进行了测试，即将跳转至结果窗口！");
    }

    
  }

  public function studentresult(){
    $zhang_id = $_GET['id'];
    $username = Cookie::get('username');
    $userid = Cookie::get('userid');
    $usertype = Cookie::get('usertype');

    $test = new TestModel();
    $testlist = $test->where("zhang_id='$zhang_id'")->select();
    $student_test = new Student_testModel();
    $student_testlist = $student_test->where("user_id='$userid'")->find();
    $zhang = new ZhangModel();
    $zhanglist = $zhang->where("zhang_id='$zhang_id'")->find();
    $course_id =$zhanglist['course_id'];
    $course = new CourseModel();
    $courselist = $course->where("course_id='$course_id'")->find();

    $this->assign('username',$username);
    $this->assign('userid',$userid);
    $this->assign('usertype',$usertype);
    $this->assign('zhang',$zhanglist);
    $this->assign('student_test',$student_testlist);
    $this->assign('testlist',$testlist);
    $this->assign('course',$courselist);
    $this->display();
  }
}
?>