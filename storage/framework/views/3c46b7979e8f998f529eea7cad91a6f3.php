<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AJAX CRUD</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="/">ZIMO GROUP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/ajaxcrud/index">All Companies</a>
            </li>
        </ul>
        
        <div>
            <button  href="#" id="logoutButton" class='btn btn-primary'>
                Logout
            </button>
        </div>
        <div>
            <button  href="#" id="ResetPasswordButton" class='btn btn-primary mx-3'>
                Reset Password
            </button>
        </div>
    </div>
</nav>

<!-- <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register</h5>
                <button type="button" id='loginModal_XBtn' class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 
                <form id="registrationForm">
                    <?php echo csrf_field(); ?>
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
</div> -->

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="loginModalLabel">You are not Logged in yet</h3>
                <button type="button" id='loginModal_XBtn' class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please Login first.</p> 
                <button  href="" id="loginLinkPage"  class='btn btn-primary mx-2' >
                    Login
                </button>   
            </div>                      
        </div>
    </div>
</div>


<div class="modal fade" id="resetPasswordLinkModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="resetPasswordLinkForm">
                        <div class="form-group">
                            <label for="resetEmail">Email address</label>
                            <input type="email" class="form-control" id="resetEmail" placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Reset Link</button>
                        <div id="resetMessage" class="mt-2"></div>
                    </form>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="passwordResetModal" tabindex="-1" aria-labelledby="passwordResetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="passwordResetModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form id="resetPasswordForm">
            <div class="form-group">
                <label for="reset_Email" >Email address</label>
                <input required type="email" class="form-control" id="reset_Email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input required type="password" class="form-control" id="reset_password" name="password" placeholder="Enter your new password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input required type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Confirm your new password" required>
            </div>
    <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
    </div>
    </div>
    </div>
</div>
<div id="message-container">
    <?php if($message = Session::get('success')): ?>
    <div class='alert alert-success'><strong><?php echo e($message); ?></strong></div>
    <?php endif; ?>
</div>
<div class="container mt-5">
    <div class="text-right">    
        <button class="btn btn-dark mt-2" data-toggle="modal" data-target="#addModal">New Company</button>
    </div>    

    <div class="modal fade" id="companyDetailsModal" tabindex="-1" role="dialog" aria-labelledby="companyDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="companyDetailsModalLabel">Company Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="companyDetailsBody">
                    <!-- Company details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <h2 class="mb-4">Company List</h2>
    <table class="table table-bordered" id="companyTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>Tax ID</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<!--AJAXCRUD TASK -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addCompanyForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="tax_id">Tax ID</label>
                        <input type="text" class="form-control" id="tax_id" name="tax_id" required>
                    </div>
                    <div class='form-group'>
                        <label>Image</label>
                        <input required type='file' name='image' id='image'class='form-control' placeholder="Select an image (JPEG, PNG, GIF)">     
                    </div> 
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCompanyForm">
                    <input type="hidden" id="editId" name="editId">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="editName" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" class="form-control" id="editAddress" name="editAddress" required>
                    </div>
                    <div class="form-group">
                        <label for="editCity">City</label>
                        <input type="text" class="form-control" id="editCity" name="editCity" required>
                    </div>
                    <div class="form-group">
                        <label for="editTaxId">Tax ID</label>
                        <input type="text" class="form-control" id="editTaxId" name="editTaxId" required>
                    </div>
                    <div class='form-group'>
        <label>Image</label>
        <input type='file' name='image' id='image'class='form-control' placeholder="Select an image (JPEG, PNG, GIF)">
    
    </div> 
                    <button type="submit" id='saveChanges' class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const ngrok_link = <?php echo json_encode($ngrok_link, 15, 512) ?>;

// Function to check if user is authenticated and toggle visibility of logout link
function checkAuthStatus() {
    $.ajax({
        url: ngrok_link + '/authTask/authCheck', 
        type: 'GET',
        success: function(response) {
            var isAuthenticated = response.authenticated;
            if (isAuthenticated) {
                $('#loginLink').hide();
                $('#logoutButton').show();
                $('#ResetPasswordButton').show();
            } else {
                window.location.href = ngrok_link + '/authTask/loginPage';
                $('#logoutButton').hide();
                $('#ResetPasswordButton').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error checking authentication status:', error);
        }
    });
}

// Initial check of authentication status

// document.addEventListener("DOMContentLoaded", function() {
//     // Get the close button element
//     const closeButton = document.getElementById('loginModal_XBtn');

//     // Add an event listener for the click event
//     closeButton.addEventListener('click', function(event) {
//         // Prevent the default action (closing the modal)
//         event.preventDefault();

//         // Reopen the modal
//         $('#loginModal').modal('show');
//     });
// });
// // Periodically check authentication status every 5 seconds
// // setInterval(checkAuthStatus, 5000);

// $(document).ready(function () {
//     $('#verifyEmailBtn').on('click', function () {
//         const csrfToken = $('meta[name="csrf-token"]').attr('content');
//         var email = $('#email').val().trim();

//         if (!isValidEmail(email)) {
//             $('#registeredDone').text('Please enter a valid email address.');
//             return;
//         }

//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             type: 'POST',
//             url: ngrok_link + '/authTask/checkEmailExists',
//             data: { email: email },
//             success: function (response) {
//                 if (response.exists) {
//                     $('#registeredDone').text('Email already exists. Please use a different email address.');
//                     alert('Email already exists!');
//                 } else {
//                     sendOTP(email);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error checking email existence:', xhr.responseText);
//             }
//         });
//     });

//     function isValidEmail(email) {
//         var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//         return emailRegex.test(email);
//     }

//     function sendOTP(email) {
//         const csrfToken = $('meta[name="csrf-token"]').attr('content');

//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             type: 'POST',
//             url: ngrok_link + '/authTask/sendOTP',
//             data: { email: email },
//             success: function (response) {
//                 alert('OTP is sent');
//                 $('#otpContainer').show();
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error sending OTP:', xhr.responseText);
//                 alert('Error sending OTP');
//                 $('#registeredDone').text('Error sending OTP. Please try again later.');
//             }
//         });
//     }
//     $('#verifyOTPBtn').on('click', function () {
//         var otp = $('#otp').val().trim();

//         if (otp.length !== 6) {
//             $('#registeredDone').text('Please enter a 6-digit OTP.');
//             return;
//         }
//         const csrfToken = $('meta[name="csrf-token"]').attr('content');
//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             type: 'POST',
//             url: ngrok_link + '/authTask/verifyOTP',
//             data: { otp: otp },
//             success: function (response) {
//                 if (response.valid) {
//                     alert('Email Verified');
//                 } else {
//                     $('#registeredDone').text('Invalid OTP. Please try again.');
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error verifying OTP:', xhr.responseText);
//                 alert('Error verifying OTP. Please try again later.');
//             }
//         });
//     });
// });

$(document).ready(function() {
    $('#resetPasswordForm').on('submit', function(event) {
        event.preventDefault();

        // Serialize form data
        var formData = $(this).serialize();

        // Retrieve form fields by their IDs
        var emailField = $('#resetEmail');
        var passwordField = $('#reset_password');
        var passwordConfirmationField = $('#confirm_password');

        // Check if all required form fields are present
        if (emailField.length && passwordField.length && passwordConfirmationField.length) {
            // Extract values from form fields
            var email = emailField.val().trim();
            var password = passwordField.val().trim();
            var passwordConfirmation = passwordConfirmationField.val().trim();

            // Check if password and confirmation match
            if (password === passwordConfirmation) {
                // Get CSRF token from meta tag
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Send AJAX request to reset password
                $.ajax({
                    url: ngrok_link + '/authTask/ResetPassword',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    success: function(response) {
                        // Handle success response
                        $('#passwordResetMessage').text('Password has been reset successfully.').addClass('text-success');
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        $('#passwordResetMessage').text('Error resetting password. Please try again.').addClass('text-danger');
                        alert('Error resetting password. Please try again.');
                    }
                });
            } else {
                // Passwords do not match
                alert('Password Mismatch. Kindly enter the same password');
            }
        } else {
            // One or more input fields are missing
            console.error('One or more input fields are missing.');
        }
    });
});




// document.addEventListener("DOMContentLoaded", function() {
//     document.getElementById("loginLinkPage").addEventListener("click", function(event) {
//         event.preventDefault();
//         window.location.href = ngrok_link + '/authTask/loginPage'
//         $('#registerModal').modal('hide');
//         $('#loginModal').modal('show');
//     });
// });

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("loginLink").addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = ngrok_link + '/authTask/loginPage'
        $('#registerModal').modal('hide');
        $('#loginModal').modal('show');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("ResetPasswordButton").addEventListener("click", function(event) {
        event.preventDefault();
        $('#passwordResetModal').modal('show');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("registerLink").addEventListener("click", function(event) {
        event.preventDefault();
        $('#registerModal').modal('show');
        $('#loginModal').modal('hide');
    });
});

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("resetPasswordLink").addEventListener("click", function(event) {
        event.preventDefault();
        $('#loginModal').modal('hide');
        $('#resetPasswordLinkModal').modal('show');
    });
});

// $(document).ready(function () {
//     $('#registerButton').on('click', function () {
//         var formData = $('#registrationForm').serialize();
//         registerUser(formData);
//     });

//     function registerUser(formData) {
//         var csrfToken = $('meta[name="csrf-token"]').attr('content');

//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             type: 'POST',
//             url: ngrok_link + '/authTask/registerUser',
//             data: formData,
//             success: function (response) {
//                 if (response.success) {
//                     $('#registerModal').modal('hide');
//                     console.log('User registered successfully:', response.message);
//                     alert(response.message);
//                 } else {
//                     $('#registeredDone').text('Registration Failed');
//                     console.error('Error registering user:', response.message);
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error registering user:', xhr.responseText);
//             }
//         });
//     }
// });

// $(document).ready(function () {
//     $('#loginBtn').on('click', function (event) {
//         event.preventDefault();
//         const csrfToken = $('meta[name="csrf-token"]').attr('content');
//         var formData = $('#loginForm').serialize();

//         $.ajax({
//             headers: {
//                 'X-CSRF-TOKEN': csrfToken
//             },
//             type: 'POST',
//             url: ngrok_link + '/authTask/loginUser', 
//             data: formData,
//             success: function (response) {
//                 if (response.success) {

//                     $('#loginForm')[0].reset();
//                     $('#loginModal').modal('hide');
//                     console.log('User logged in successfully:', response.message);
//                     alert(response.message);
//                     $('#logoutButton').show();
//                     $('#ResetPasswordButton').show();
//                     $('#loginButton').hide();
//                 } else {
//                     console.error('Login failed:', response.message);
//                     alert('Invalid Username or Password');

                    
//                 }
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error occurred during login:', xhr.responseText);
//             }
//         });
//     });
// });

$(document).ready(function() {
    $('#logoutButton').on('click', function() {
        const csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: 'POST',
            url: ngrok_link + '/authTask/logoutUser',
            success: function(response) {
                console.log('User logged out successfully:', response.message);
                alert('User logged out successfully')
                window.location.href = ngrok_link + '/authTask/loginPage'
                    $('#loginModal').modal('show');
                    $('#logoutButton').hide();
                    $('#ResetPasswordButton').hide();
            },
            error: function(xhr, status, error) {
                console.error('Error occurred during logout:', xhr.responseText);
            }
        });
    });
});
</script>

<script>
    $(document).ready(function () {
    fetchCompanies();
    
    $('#addCompanyForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('address', $('#address').val());
        formData.append('city', $('#city').val());
        formData.append('tax_id', $('#tax_id').val());
        formData.append('image', $('#image')[0].files[0]);

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        $.ajax({
            type: "POST",
            url: ngrok_link + '/ajaxcrud/store',
            data: formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    $('#addModal').modal('hide');
                    fetchCompanies();
                    $('#addCompanyForm')[0].reset();
                } else {
                    alert('Error saving company.');
                }
            },
            error: function (response) {
                console.log(response);
            }
        });
    });

    function fetchCompanies() {
        $.ajax({
            type: "GET",
            url: ngrok_link + "/ajaxcrud/getCompanies",
            dataType: "json",
            success: function (response) {
                let rows = '';
                response.forEach(company => {
                    rows += `
                        <tr>
                            <td><a href="#" class="view-btn" data-id="${company.id}">${company.name}</a></td>
                            <td>${company.address}</td>
                            <td>${company.city}</td>
                            <td>${company.tax_id}</td>
                            <td><img src="/storage/ajaxcrud/${company.image}" class='rounded-circle' width='50' height='50'></td>
                            <td>
                                <button  href="#" class="edit-btn btn btn-sm btn-warning" data-id="${company.id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${company.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#companyTable tbody').html(rows);
            }
        });
    }
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $(document).on('click', '.edit-btn', function () {
        var companyId = $(this).data('id');       
        $.ajax({
            headers: {
        'X-CSRF-TOKEN': csrfToken
    },
            type: 'GET',
            url: ngrok_link +  '/ajaxcrud/edit/' + companyId,
            success: function(response) {
                $('#editId').val(response.id);
                $('#editName').val(response.name);
                $('#editAddress').val(response.address);
                $('#editCity').val(response.city);
                $('#editTaxId').val(response.tax_id);
                $('#editImage').attr('src', '/storage/ajaxcrud/' + response.image);
                $('#editModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error loading company details:', error);
            }
        });
    });
    $(document).on('click', '#saveChanges', function (e) {
        e.preventDefault();
        var companyId = $('#editId').val();
        var formData = new FormData();
        formData.append('name', $('#editName').val());
        formData.append('address', $('#editAddress').val());
        formData.append('city', $('#editCity').val());
        formData.append('tax_id', $('#editTaxId').val());

        var image = $('#image')[0].files[0];
        if (image) {
            formData.append('image', image);
        }
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            type: 'PUT',
            url: ngrok_link +  '/ajaxcrud/update/' + companyId,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Company updated successfully:', response);
                alert('Company updated successfully');
                $('#editModal').modal('hide');
                fetchCompanies();
            },
            error: function(xhr, status, error) {
                console.error('Error updating company:', xhr.responseText);
                alert('Error occurred during update: ' + xhr.responseText);
            }
        });
    });
    $(document).on('click', '.delete-btn', function () {
        if (!confirm('Are you sure?')) return;
        let id = $(this).data('id');
        $.ajax({
            type: "DELETE",
            url: ngrok_link + `/ajaxcrud/delete/${id}`,
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    fetchCompanies();
                } else {
                    alert('Error deleting company.');
                }
            }
        });
    });

    $(document).on('click', '.view-btn', function (event) {
        event.preventDefault();
        var companyId = $(this).data('id');
        
        $.ajax({
            type: 'GET',
            url: ngrok_link + '/ajaxcrud/show/' + companyId,
            success: function(response) {
                var companyDetailsHtml = `
                    <p><strong>Name:</strong> ${response.name}</p>
                    <p><strong>Address:</strong> ${response.address}</p>
                    <p><strong>City:</strong> ${response.city}</p>
                    <p><strong>Tax ID:</strong> ${response.tax_id}</p>
                    <p><strong>Image : </strong><img src="/storage/ajaxcrud/${response.image}" class='rounded-circle' width='50' height='50'></p>
                `;
                $('#companyDetailsBody').html(companyDetailsHtml);
                $('#companyDetailsModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error loading company details:', error);
            }
        });
    });
 });
</script>
</body>
</html>
<?php /**PATH C:\ZIMO TASKS\ZIMO-TASKS\resources\views/ajaxcrud/index.blade.php ENDPATH**/ ?>