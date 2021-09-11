<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$imgurl= base_url().'assets/images/';
$baseurl = base_url();
$result=json_decode($answer);//var_dump($answer);
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="NGP Websmart Interview Task">
  <meta name="author" content="Mahendran">

  <title>NGP::Ask Question</title>
  <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
  <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sweetalert2.min.css">
  <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/mystyle.css">

</head>

<body>

<div class="banner-image pb-5">

  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 text-center">
          
        <div class="p-4 mt-5 row">
            <div class="col-2 form-inline"><p class="color-gray m-0 fw-600">Ask<br>Question</p></div>
            <div class="col-8 form-inline"><textarea rows="3" name="question" id="makequestion" class="question-box" autofocus></textarea></div>
            <div class="col-2 jc-fd form-inline"><input type="button" class="btn submit_question" onclick="submit_question()" value="SUBMIT" /></div>
        </div>
        
        <?php
           $create_filter= '<div class="p-2 br-4 mt-5 row bg-gray">
           <div class="col-10 form-inline">
               <span class="fw-500">SORT</span>
               <div class="filter-box-radio">
                   <input id="votefilter" onClick="create_filter(this)" class="filter-btn" type="radio" name="filterby" value="vote">
                   <label for="votefilter">VOTE</label>
                   <input id="timefilter" onClick="create_filter(this)" class="filter-btn" type="radio" name="filterby" value="time">
                   <label for="timefilter">TIME</label>
               </div>
           </div>
           <div class="col-2 jc-fd form-inline">
               <button class="bookmark-btn filter-btn" onClick="create_filter(this)" value="bookmark" id="bookmarkfilter">BOOKMARKED</button>
           </div>
       </div>';
            if($result){
             
                $create_ans='';
                foreach($result as $ans){
                    if($ans->answered==1){
                        $answered=' answered';
                        $loadbtn='';$readed='readonly';
                    }else{
                        $answered=$readed='';
                        $loadbtn='<div class="submit-answer form-inline">
                                    <button class="answer-btn" onClick="submit_answer('.$ans->questionid.',this)" id="submitanswer">SUBMIT</button>
                                </div>';
                    }
                    $create_ans.= '<div class="br-4 mt-5 row bg-gray">
                        <div class="col-1 vote-container form-inline">
                            <p class="w-100 vote-value vote_'.$ans->questionid.'">'.$ans->vote.'</p>
                            <span onclick="vote_answer('.$ans->questionid.','.$ans->answerid.','.$ans->vote.',1)" class="w-50 vote-plus vote_plus_'.$ans->questionid.'"></span><span onclick="vote_answer('.$ans->questionid.','.$ans->answerid.','.$ans->vote.',0)" class="w-50 vote-minus  vote_minus_'.$ans->questionid.'"></span>
                        </div>
                        <div class="col-11  form-inline">
                        <div class="'.$ans->bookmarkclass.' bookmark_'.$ans->questionid.'_'.$ans->answerid.'" onclick="bookmark_question('.$ans->questionid.','.$ans->answerid.','.$ans->bookmarked.')"></div>
                            <div class="col-11 form-inline">
                                <p class="view-question">'.$ans->question.'</p>
                                <textarea class="answer-box'.$answered.' answer_for_'.$ans->questionid.'" rows="2" '.$readed.'>'.$ans->answer.'</textarea>
                            </div>
                            '.$loadbtn.'
                            <div class="col-12 jc-fd form-inline">
                                <p class="ques_time">'.$ans->creationtime.'</p>
                            </div>
                        </div>
                    </div>';
                }
                echo $create_filter.'<div class="answer-container">'.$create_ans.'</div>';
            }else{
                echo $create_filter.'<div class="answer-container"></div>';
            }
        

        ?>
        
      </div>      
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sweetalert_mobile_support.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/myscript.js"></script>

<script>
$(document).ready(function(){
    get_question_answer();
});

function get_question_answer(){
    $.ajax({
        method: "GET",
        url : "http://localhost/ngp_server/get-answer",
        dataType: 'JSON',
        crossDomain:true,
        cors: true,
        contentType: 'application/json',
        secure: true,
        headers:{'Access-Control-Allow-Origin':'https://localhost'},
        success: function(data){
            var response = data.response;
            var status = data.status;
            if(status == 200){
                var userId = response[0].user_id;
                //success of user 
            }else{
                console.log(data);
            }
        },
        error: function(status){
            console.log("Error occured");
        }
    });
}

function vote_answer(quesid,ansid,vote,mode){
    $.ajax({
        method: "POST",
        url : "http://localhost/ngp_server/vote-answer",
        data: {'questionid':quesid,'answerid':ansid,'mode':mode,'vote':vote},
        dataType: 'JSON',
        success: function(data,txt,xhr){console.log(data);
            var res = data;
            var status = xhr.status;
            //console.log(res.status);console.log(status);
            if(res.status == 200){                
                $(".vote_"+quesid).text(res.message);
                $('.vote_plus_'+quesid).attr("onclick","vote_answer("+quesid+","+ansid+","+res.message+",1)");
                $('.vote_minus_'+quesid).attr("onclick","vote_answer("+quesid+","+ansid+","+res.message+",0)");
                swal({
                        text: 'Voted Successfully..!',
                        type: 'success',
                        showCloseButton: false,
                        allowOutsideClick: false,
                        timer: 3000
                    }).catch(swal.noop);
                    $('.swal2-confirm').remove();
            }else{
                swal({
                        text: data.message,
                        type: 'error',
                        showCloseButton: false,
                        allowOutsideClick: false,
                        timer: 3000
                    }).catch(swal.noop);
                    $('.swal2-confirm').remove();
            }
        },
        error: function(status){
            console.log("Error occured");
        }
    });
}

function submit_question(){
    var question=$("#makequestion").val();
    if(question==''){
        swal({
            text: 'Please type your Question...!',
            type: 'error',
            showCloseButton: false,
            allowOutsideClick: false,
            timer: 3000
        }).catch(swal.noop);
        $('.swal2-confirm').remove();
        return false;
    }
    if(question.length<5){
        swal({
            text: 'Your Question maximum 5 character long...!',
            type: 'error',
            showCloseButton: false,
            allowOutsideClick: false,
            timer: 3000
        }).catch(swal.noop);
        $('.swal2-confirm').remove();
        return false;
    }
    if(true){
        $.ajax({
            method: "POST",
            url : "http://localhost/ngp_server/post-answer",
            data: {'question':question},
            dataType: 'JSON',
            success: function(data,txt,xhr){
                var res = data[0];
                var status = xhr.status;
                if(status == 200){
                    $("#makequestion").val('');
                    swal({
                            text: 'Question raised successfully..!',
                            type: 'success',
                            showCloseButton: false,
                            allowOutsideClick: false,
                            timer: 3000
                        }).catch(swal.noop);
                        $('.swal2-confirm').remove();
                    //console.log(data);
                    //console.log('qs-'+res.question);//success of user 
                    var make_ans='<div class="br-4 mt-5 row bg-gray"><div class="col-1 vote-container form-inline"><p class="w-100 vote-value vote_'+res.questionid+'">'+res.vote+'</p><span onclick="vote_answer('+res.questionid+','+res.answerid+','+res.vote+',1)" class="w-50 vote-plus vote_plus_'+res.questionid+'"></span><span onclick="vote_answer('+res.questionid+','+res.answerid+','+res.vote+',0)" class="w-50 vote-minus  vote_minus_'+res.questionid+'"></span></div><div class="col-11  form-inline"><div class="'+res.bookmarkclass+' bookmark_'+res.questionid+'_'+res.answerid+'" onclick="bookmark_question('+res.questionid+','+res.answerid+','+res.bookmarked+')"></div><div class="col-11 form-inline"><p class="view-question">'+res.question+'</p><textarea class="answer-box answer_for_'+res.questionid+'" name="answer" rows="2"></textarea></div><div class="submit-answer form-inline"><button class="answer-btn" id="submitanswer" onClick="submit_answer('+res.questionid+',this)">SUBMIT</button></div><div class="col-12 jc-fd form-inline"><p class="ques_time">'+res.creationdate+'</p></div></div></div>';
                    $(".answer-container").prepend(make_ans);
                }else{
                    console.log(data);
                }
            },
            error: function(status){
                console.log("Error occured");
            }
        });
    }
}

function bookmark_question(quesid,ansid,bookmark){
    $.ajax({
            method: "POST",
            url : "http://localhost/ngp_server/bookmark-answer",
            data: {'questionid':quesid,'answerid':ansid,'bookmarked':bookmark},
            dataType: 'JSON',
            success: function(data,txt,xhr){
                var res = data;
                var status = xhr.status;
                //console.log(res.status);console.log(status);
                if(res.status == 200){ 
                    if(bookmark==1){
                        $('.bookmark_'+quesid+'_'+ansid).removeClass('bookmarked');
                        $('.bookmark_'+quesid+'_'+ansid).addClass('bookmark');
                        bookmark=0;
                    }else{
                        $('.bookmark_'+quesid+'_'+ansid).removeClass('bookmark');
                        $('.bookmark_'+quesid+'_'+ansid).addClass('bookmarked');
                        bookmark=1
                    }               
                    $('.bookmark_'+quesid+'_'+ansid).attr("onclick","bookmark_question("+quesid+","+ansid+","+bookmark+")");
                    swal({
                            text: res.message,
                            type: 'success',
                            showCloseButton: false,
                            allowOutsideClick: false,
                            timer: 3000
                        }).catch(swal.noop);
                        $('.swal2-confirm').remove();
                }else{
                    swal({
                            text: data.message,
                            type: 'error',
                            showCloseButton: false,
                            allowOutsideClick: false,
                            timer: 3000
                        }).catch(swal.noop);
                        $('.swal2-confirm').remove();
                }
            },
            error: function(status){
                console.log("Error occured");
            }
        });
}

function submit_answer(quesid,thiz){
    var answer=$(".answer_for_"+quesid).val();
    if(answer==''){
        swal({
            text: 'Please type your Answer...!',
            type: 'error',
            showCloseButton: false,
            allowOutsideClick: false,
            timer: 3000
        }).catch(swal.noop);
        $('.swal2-confirm').remove();
        return false;
    }
    if(answer.length<5){
        swal({
            text: 'Your answer maximum 5 character long...!',
            type: 'error',
            showCloseButton: false,
            allowOutsideClick: false,
            timer: 3000
        }).catch(swal.noop);
        $('.swal2-confirm').remove();
        return false;
    }
    if(true){
        $.ajax({
                method: "POST",
                url : "http://localhost/ngp_server/make-answer",
                data: {'questionid':quesid,'answer':answer},
                dataType: 'JSON',
                success: function(data,txt,xhr){
                    var res = data;
                    var status = xhr.status;
                    //console.log(res.status);console.log(status);
                    if(res.status == 200){ 
                        $(".answer_for_"+quesid).addClass('answered');
                        $(".answer_for_"+quesid).prop('readonly',true);
                        $(thiz).remove();
                        swal({
                                text: data.message,
                                type: 'success',
                                showCloseButton: false,
                                allowOutsideClick: false,
                                timer: 3000
                            }).catch(swal.noop);
                            $('.swal2-confirm').remove();
                    }
                },
                error: function(status){
                    console.log("Error occured");
                }
            });
        }
}

function create_filter(filter){
    var get_val=$(filter).val();
    var username = 'admin';var password='1234';
    $(".filter-btn").prop('checked',false);
    $("#"+get_val+"filter").prop('checked',true);
    $.ajax({
            method: "POST",
            url : "http://localhost/ngp_server/make-filter",
            data: {'filter':get_val},
            dataType: 'JSON',
            headers:{"Authorization": "Basic " + btoa(username + ":" + password)},
            success: function(data,txt,xhr){
                var res = data;
                var status = xhr.status;
                //console.log(res.status);console.log(status);
                if(status == 200){ 
                    $(".answer-container").html(res);
                }
            },
            error: function(status){
                console.log("Error occured");
            }
        });
    
}
</script>
</body>
</html>