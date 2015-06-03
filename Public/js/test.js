var delaytime;

delaytime = function(){
  var delayminutes = document.getElementById("delayminutes").innerHTML;
  var delayseconds = document.getElementById("delayseconds").innerHTML;
  $("div.start").show();
  $("div#test").hide();
  function delay(){
    if (delayseconds <= 9) {
      document.getElementById("zero").innerHTML ='0';
    }else{
      document.getElementById("zero").innerHTML ='';
    }
    if (delayseconds > 0) {
      delayseconds--;
      document.getElementById("delayseconds").innerHTML = delayseconds;
    }else{
      if (delayminutes > 0) {
        delayminutes--;
        delayseconds = 59;
        document.getElementById("delayminutes").innerHTML = delayminutes;
        document.getElementById("zero").innerHTML ='';
        document.getElementById("delayseconds").innerHTML = delayseconds;
      }else{

      }
    }
    setTimeout(delay,1000);
  }
  
  $("button#start").click(function(){
    $("div.start").hide();
    $("div#test").show();
    delay();
  });


}

$(document).ready(delaytime);