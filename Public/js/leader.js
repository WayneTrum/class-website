var vedioformdisplay,is_login,displaylist,teacherdisplaylist,is_courseinfo,editor_wysiwyg,zhangdisplay;

is_login = function(){
  var username = $.cookies.get('username');
  if (username) {
    $("li#user").show();
    $("li#login").hide();
    $("li#register").hide();
    $("li#loginout").show()
  } else{
    $("li#user").hide();
    $("li#login").show();
    $("li#register").show();
    $("li#loginout").hide();
  };
};

is_courseinfo = function(){
  var courseinfo = $("span#courseinfo_is_exist").text();
  if (courseinfo) {
    $("div#courseinfodisplay_title").hide();
    $("div#courseinfodisplay_content").hide();
  }
}

editor_wysiwyg = function(){
  $("div#editor").wysiwyg();
}

displaylist = function(){
  $("div#ManagerDoStudent").show();
  $("div#ManagerDoTeacher").hide();
  $("div#ManagerDoCourse").hide();
  $("div#ManagerDoSchool").hide();

  $("span#DoUser").click(function(){
    $("div#ManagerDoStudent").show();
    $("div#ManagerDoTeacher").hide();
    $("div#ManagerDoCourse").hide();
    $("div#ManagerDoSchool").hide();
  });

  $("span#DoTeacher").click(function(){
    $("div#ManagerDoStudent").hide();
    $("div#ManagerDoTeacher").show();
    $("div#ManagerDoCourse").hide();
    $("div#ManagerDoSchool").hide();
  });

  $("span#DoCourse").click(function(){
    $("div#ManagerDoStudent").hide();
    $("div#ManagerDoTeacher").hide();
    $("div#ManagerDoCourse").show();
    $("div#ManagerDoSchool").hide();
  });

  $("span#DoSchool").click(function(){
    $("div#ManagerDoStudent").hide();
    $("div#ManagerDoTeacher").hide();
    $("div#ManagerDoCourse").hide();
    $("div#ManagerDoSchool").show();
  });
}

zhangdisplay = function(){
  $("div#zhangaddform").hide();
  $("span#zhangaddlink").click(function(){
    $("div#zhangaddform").toggle();
  });
}

vedioformdisplay = function(){
  $("div#vedioaddform").hide();
  $("span.vedioaddlink").click(function(){
    $(this).siblings("div#vedioaddform").toggle();
  });
}


$(document).ready(is_login);
$(document).ready(is_courseinfo);
$(document).ready(displaylist);
$(document).ready(teacherdisplaylist);
$(document).ready(zhangdisplay);
$(document).ready(vedioformdisplay);