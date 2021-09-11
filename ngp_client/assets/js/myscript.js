

function openform_two(){
    var input1 = $("#profilename").val();
    var input2 = $("#profilemobile").val();
    if(input1!='' && input2!=''){
        $(".form_one").addClass('hide');
        $(".form_two").removeClass('hide');
        $(".maintxt").text('Almost Done..!');
        $(".subtxt").text('One more steps to Find Life Partner..!');
    }else{
        swal({
            text: 'Please Fill All Fields..!',
            type: 'error',
            showCloseButton: false,
            allowOutsideClick: false,
            timer: 3000
        }).catch(swal.noop);
        $('.swal2-confirm').remove();
    }
    
}//setTimeout(function(){location.reload();},800);

function submitform(){
    var forminput = $(".creationform").serialize();
    $.ajax({
        async: 'false',
        url: 'create-account',
        type: 'post',
        data: forminput,
        dataType: 'json',
        success: function(data){
            $('.txt_csrfname').val(data.token);
            if(data.errorno==1){
                $(".form_one").removeClass('hide');
                $(".form_two").addClass('hide');
                $(".maintxt").text('You too can find a Life Partner');
                $(".subtxt").text('Lakhs of Tamils found their perfect match here!');
                swal({
                    text: 'Please Fill All Fields..!',
                    type: 'error',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
            }
            else if(data.errorno==2){
                //$(".form_one .form_two").remove();
                //$(".verify_form").removeClass('hide');
                swal({
                    text: 'Please Fill All Fields..!',
                    type: 'error',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
            }
            else if(data.errorno==99){
                //$(".form_one .form_two").remove();
                //$(".verify_form").removeClass('hide');
                swal({
                    text: 'Email already Exists..!',
                    type: 'error',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
            }
            else if(data.errorno==8){
                //$(".form_one .form_two").remove();
                //$(".verify_form").removeClass('hide');
                swal({
                    text: 'Your DOB is lower the 18 years..!',
                    type: 'error',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
            }
            else{
                swal({
                    text: 'Account Created Successfully..! Verification link sended to your Email.',
                    type: 'success',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
                //setTimeout(function(){location.reload();},2000);
            }
        },
        error: function(err){
            console.log(err);
        }
    });
}

function verifyaccount(){
    var vcode = $("#emailverifycode").val();
    $.ajax({
        async: 'false',
        url: 'create-account',
        type: 'post',
        data: forminput,
        dataType: 'json',
        success: function(data){
            if(data){
                $(".form_one .form_two").remove();
                $(".verify_form").removeClass('hide');
            }
        },
        error: function(err){
            console.log(err);
        }
    });
}

function check_login(){
    var forminput = $(".loginform").serialize();
    var pemail = $("#profileemail").val();
    var ppwd = $("#profilepassword").val();
    if(pemail=='' || ppwd==''){
        swal({
            text: 'Please Fill All Fields..!',
            type: 'error',
            showCloseButton: false,
            allowOutsideClick: false,
            timer: 3000
        }).catch(swal.noop);
        $('.swal2-confirm').remove();
        return false;
    }else{
        $.ajax({
            url: 'check-login',
            type: 'post',
            data: forminput,
            dataType: 'json',
            success: function(data){
            $('.txt_csrfname').val(data.token);
                if(data.errorno==0){
                    swal({
                        text: 'Logged successfully..!',
                        type: 'success',
                        showCloseButton: false,
                        allowOutsideClick: false,
                        timer: 3000
                    }).catch(swal.noop);
                    $('.swal2-confirm').remove();
                    setTimeout(function(){location.href='dashboard';},2000);
                }else{
                    swal({
                        text: data.errormsg,
                        type: 'error',
                        showCloseButton: false,
                        allowOutsideClick: false,
                        timer: 3000
                    }).catch(swal.noop);
                    $('.swal2-confirm').remove();
                }
            },
            error: function(err){
                console.log(err);
            }
        });
    }
   
}

function updateform(){
    var forminput = $(".creationform").serialize();
    $.ajax({
        async: 'false',
        url: '../save-profile',
        type: 'post',
        data: forminput,
        dataType: 'json',
        success: function(data){
            $('.txt_csrfname').val(data.token);
            if(data.errno==1){
                swal({
                    text: data.errmsg,
                    type: 'error',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
            }else{
                swal({
                    text: 'Profile Updated successfully..!',
                    type: 'success',
                    showCloseButton: false,
                    allowOutsideClick: false,
                    timer: 3000
                }).catch(swal.noop);
                $('.swal2-confirm').remove();
            }
            setTimeout(function(){location.reload();},2000);
        }
    });
}