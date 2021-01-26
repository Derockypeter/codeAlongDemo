// Index Page
$('#regDiv').addClass('hide');
function openForm() {
    if($('#regDiv').hasClass('hide')){
        $('#loginDiv').addClass('hide')
        $('#regDiv').removeClass('hide')
        $('title').text('Register')
    }
    else if($('#loginDiv').hasClass('hide')){
        $('#regDiv').addClass('hide')
        $('#loginDiv').removeClass('hide')
        $('title').text('Login')
    }  
}


//Signup
$('#regForm').submit(function(e){
    e.preventDefault();
    $('.fdBack').empty()
    var fName = $('input[name="fName"]').val();
    var lName = $('input[name="lName"]').val();
    var email = $('input[name="email"]').val();
    var uName = $('input[name="username"]').val();
    var password = $('input[name="password"]').val();
    var cPass = $('input[name="confirm_password"]').val();
    if(fName != "" && lName != "" && email != "" && password != "" && cPass != "" && uName != ""){
        // Confirm Password
        if(cPass === password){
            $.ajax({
                type: "POST",
                url: "gateway/registerController.php",
                data: 'fName='+fName+'&lName='+lName+'&email='+email+'&username='+uName+'&password='+password+'&submitReg=true',
                success: function(data) {
                    if(data == 1){
                        //inform of success
                        openForm();
                        $('.fdBack').addClass('successToast');
                        $('.fdBack').append('Registration Successful, Please Login!')
                    }
                    else {
                        $('.fdBack').addClass('errorToast');
                        $('.fdBack').append(`${data}`);
                    }
                }, error: function(){
                    $('.fdBack').addClass('errorToast');
                    $('.fdBack').append('Network Error. Try again later!');
                }, timeout: 3500
            });
        }
        else {
            $('.fdBack').addClass('errorToast');
            $('.fdBack').append('Password confirmation does not match!');
        }
        
    } else {
        $('.fdBack').addClass('errorToast');
        $('.fdBack').append('Please fill out all fields!');
    } 
});

// Login
$('#loginForm').submit(function(e){
    e.preventDefault();
    $('.loginfdBack').empty()
    var uName = $('input[name="loginUsername"]').val();
    var password = $('input[name="loginPassword"]').val();

    if(uName != "" && password != ""){  
        $.ajax({
            type: "POST",
            url: "gateway/loginController.php",
            data: 'uName='+uName+'&password='+password+'&submitted=true',
            success: function(data) {
                //returned successfully 
                if(data == 1){
                    function goToDash(){
                        $('.loginfdBack').addClass('successToast');
                        $('.loginfdBack').append('Login Success!')
                        window.location.replace('./modules/dashboard.php');
                    }
                    setTimeout(goToDash(), 3000);
                } else {
                    $('.loginfdBack').addClass('errorToast');
                    $('.loginfdBack').append(`${data}`)
                }
            }, error: function(){
                //network error
                $('.loginfdBack').addClass('errorToast');
                $('.loginfdBack').append('Network Error')
            }, timeout: 3500
        });
    } else {
        $('.loginfdBack').addClass('errorToast');
        $('.loginfdBack').append('Please ensure <b>Username</b> and <b>Password</b> fields are filled.');
    }
});