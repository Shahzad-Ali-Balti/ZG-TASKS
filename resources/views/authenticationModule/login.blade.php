<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
  
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="/">ZIMO GROUP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
</nav>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div>
        <div class="text-center">
            <p>Please Login Here</p>
            <form id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input required type="email" class="form-control" id="loginEmail" name="email">
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" class="form-control" id="loginPassword" name="password" required>
                </div>
            </form>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-primary" id="loginBtn">Login</button>
        </div>
        <div class="text-center mx-2">
            <p>Don't have an account? <a href="#" id="registerLink">Register</a></p>
        </div>
    </div>
</div>


<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" id='loginModal_XBtn' class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 
                <form id="registrationForm">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input required type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input required type="email" class="form-control" id="email" name="email">
                        <button type="button" id="verifyEmailBtn" class='btn btn-success my-2'>Send OTP</button>
                    </div>
                    <div class="form-group">
                        <label for="email">OTP</label>
                        <input required type="otp" class="form-control" id="otp" name="otp">
                        <button type="button" id="verifyOTPBtn" class='btn btn-success my-2'>Check OTP</button>
                    </div>                
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input required type="password" class="form-control" id="password" name="password" required>
                    </div>
                </form>
                <p id='registeredDone'></p>
            </div>
            <div class="modal-footer">
                <button id="registerButton" type="button" class="btn btn-primary">Register</button>
            </div>
            <div class='mx-2'>
                    <p>don't have any Account. <span><a  href="#" id="loginLink">Login</a>
                    </span> </p>
            </div>
    </div>
</div>
</div> 

<script>

const ngrok_link = @json($ngrok_link);

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("registerLink").addEventListener("click", function(event) {
        event.preventDefault();
        $('#registerModal').modal('show');
        $('#loginModal').modal('hide');
    });
});



document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loginLink").addEventListener("click", function(event) {
        event.preventDefault();
        $('#registerModal').modal('hide');
    });
});


$(document).ready(function () {
    $(document).ready(function () {
    $('#loginBtn').on('click', function (event) {
        event.preventDefault();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        var formData = $('#loginForm').serialize();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: 'POST',
            url: ngrok_link + '/authTask/loginUser', 
            data: formData,
            success: function (response) {
                if (response.success) {
                    window.location.href = ngrok_link + '/ajaxcrud/index';
                    $('#loginForm')[0].reset();
                    $('#loginModal').modal('hide');
                    console.log('User logged in successfully:', response.message);
                    alert(response.message);
                    $('#logoutButton').show();
                    $('#ResetPasswordButton').show();
                    $('#loginButton').hide();
                } else {
                    console.error('Login failed:', response.message);
                    alert('Invalid Username or Password');

                    
                }
            },
            error: function (xhr, status, error) {
                console.error('Error occurred during login:', xhr.responseText);
            }
        });
    });
});

$('#registerButton').on('click', function () {
        var formData = $('#registrationForm').serialize();
        registerUser(formData);
    });

    function registerUser(formData) {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: 'POST',
            url: ngrok_link + '/authTask/registerUser',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#registerModal').modal('hide');
                    console.log('User registered successfully:', response.message);
                    alert(response.message);
                } else {
                    $('#registeredDone').text('Registration Failed');
                    console.error('Error registering user:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error registering user:', xhr.responseText);
            }
        });
    };

    $('#verifyEmailBtn').on('click', function () {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        var email = $('#email').val().trim();
        if (!isValidEmail(email)) {
            $('#registeredDone').text('Please enter a valid email address.');
            return;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: 'POST',
            url: ngrok_link + '/authTask/checkEmailExists',
            data: { email: email },
            success: function (response) {
                if (response.exists) {
                    $('#registeredDone').text('Email already exists. Please use a different email address.');
                    alert('Email already exists!');
                } else {
                    sendOTP(email);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error checking email existence:', xhr.responseText);
            }
        });
    });
    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    function sendOTP(email) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: 'POST',
            url: ngrok_link + '/authTask/sendOTP',
            data: { email: email },
            success: function (response) {
                alert('OTP is sent to ' + email);
                $('#otpContainer').show();
            },
            error: function (xhr, status, error) {
                console.error('Error sending OTP:', xhr.responseText);
                alert('Error sending OTP');
                $('#registeredDone').text('Error sending OTP. Please try again later.');
            }
        });
    }
    $('#verifyOTPBtn').on('click', function () {
        var otp = $('#otp').val().trim();

        if (otp.length !== 6) {
            $('#registeredDone').text('Please enter a 6-digit OTP.');
            return;
        }
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: 'POST',
            url: ngrok_link + '/authTask/verifyOTP',
            data: { otp: otp },
            success: function (response) {
                if (response.valid) {
                    alert('Email Verified');
                } else {
                    $('#registeredDone').text('Invalid OTP. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error verifying OTP:', xhr.responseText);
                alert('Error verifying OTP. Please try again later.');
            }
        });
    });
});



</script>
</body>
</html>