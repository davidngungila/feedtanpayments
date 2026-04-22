<!DOCTYPE html>
<html lang="en" class="layout-wide customizer-hide">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Forgot Password - FeedTan Pay</title>
    <meta name="description" content="" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    
    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    
    <!-- Template Config -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Forgot Password Card -->
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-6">
                            <a href="{{ route('dashboard') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <defs>
                                                <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                                <path d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z" id="path-3"></path>
                                                <path d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z" id="path-4"></path>
                                                <path d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z" id="path-5"></path>
                                            </defs>
                                            <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                            <mask id="mask-2" fill="white">
                                                                <use xlink:href="#path-1"></use>
                                                            </mask>
                                                            <use fill="currentColor" xlink:href="#path-1"></use>
                                                            <g id="Path-3" mask="url(#mask-2)">
                                                                <use fill="currentColor" xlink:href="#path-3"></use>
                                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                                            </g>
                                                            <g id="Path-4" mask="url(#mask-2)">
                                                                <use fill="currentColor" xlink:href="#path-4"></use>
                                                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                                            </g>
                                                        </g>
                                                        <g id="Triangle" transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000)">
                                                            <use fill="currentColor" xlink:href="#path-5"></use>
                                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </span>
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold">Sneat</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        
                        <h4 class="mb-1">Forgot Password? <span class="text-primary">Reset</span>  </h4>
                        <p class="mb-6">Enter your email and we'll send you instructions to reset your password</p>
                        
                        <form id="formForgotPassword" class="mb-6" onsubmit="return false">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    placeholder="Enter your email"
                                    autofocus
                                    required />
                            </div>
                            
                            <!-- Success Message -->
                            <div id="successMessage" class="alert alert-success mb-6" style="display: none;">
                                <i class="bx bx-check-circle me-2"></i>
                                <strong>Success!</strong> Password reset instructions have been sent to your email.
                            </div>
                            
                            <!-- Error Message -->
                            <div id="errorMessage" class="alert alert-danger mb-6" style="display: none;">
                                <i class="bx bx-error-circle me-2"></i>
                                <strong>Error!</strong> Please check your email and try again.
                            </div>
                            
                            <button class="btn btn-primary d-grid w-100" type="submit" id="sendResetBtn">
                                <i class="bx bx-envelope me-2"></i>Send Reset Link
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="d-flex justify-content-center">
                                <i class="icon-base bx bx-chevron-left me-1"></i>
                                Back to login
                            </a>
                        </div>
                        
                        <!-- Alternative Methods -->
                        <div class="divider my-6">
                            <div class="divider-text">or try alternative methods</div>
                        </div>
                        
                        <div class="d-flex flex-column gap-3">
                            <button class="btn btn-outline-secondary" type="button" onclick="usePhoneRecovery()">
                                <i class="bx bx-phone me-2"></i>Use Phone Number
                            </button>
                            <button class="btn btn-outline-secondary" type="button" onclick="useSecurityQuestions()">
                                <i class="bx bx-help-circle me-2"></i>Answer Security Questions
                            </button>
                        </div>
                        
                        <!-- Phone Recovery Form (Hidden by default) -->
                        <div id="phoneRecovery" class="mt-6" style="display: none;">
                            <h6 class="mb-3">Phone Recovery</h6>
                            <form onsubmit="return false">
                                <div class="mb-4">
                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+1</span>
                                        <input type="tel" class="form-control" id="phoneNumber" placeholder="234 567 8900" />
                                    </div>
                                </div>
                                <button class="btn btn-primary d-grid w-100" type="button" onclick="sendPhoneCode()">
                                    <i class="bx bx-message-square me-2"></i>Send Verification Code
                                </button>
                            </form>
                        </div>
                        
                        <!-- Security Questions Form (Hidden by default) -->
                        <div id="securityQuestions" class="mt-6" style="display: none;">
                            <h6 class="mb-3">Security Questions</h6>
                            <form onsubmit="return false">
                                <div class="mb-4">
                                    <label for="question1" class="form-label">What was your first pet's name?</label>
                                    <input type="text" class="form-control" id="question1" placeholder="Enter your answer" />
                                </div>
                                <div class="mb-4">
                                    <label for="question2" class="form-label">What city were you born in?</label>
                                    <input type="text" class="form-control" id="question2" placeholder="Enter your answer" />
                                </div>
                                <div class="mb-4">
                                    <label for="question3" class="form-label">What's your mother's maiden name?</label>
                                    <input type="text" class="form-control" id="question3" placeholder="Enter your answer" />
                                </div>
                                <button class="btn btn-primary d-grid w-100" type="button" onclick="verifySecurityAnswers()">
                                    <i class="bx bx-check-circle me-2"></i>Verify Answers
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password Card -->
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script>
        document.getElementById('formForgotPassword').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const sendBtn = document.getElementById('sendResetBtn');
            const successMsg = document.getElementById('successMessage');
            const errorMsg = document.getElementById('errorMessage');
            
            // Hide messages
            successMsg.style.display = 'none';
            errorMsg.style.display = 'none';
            
            // Basic email validation
            if (!email || !email.includes('@')) {
                errorMsg.style.display = 'block';
                return;
            }
            
            // Show loading state
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i>Sending...';
            
            // Simulate API call
            setTimeout(() => {
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<i class="bx bx-envelope me-2"></i>Send Reset Link';
                
                // Show success message
                successMsg.style.display = 'block';
                
                // Clear form
                document.getElementById('email').value = '';
            }, 2000);
        });
        
        function usePhoneRecovery() {
            const phoneRecovery = document.getElementById('phoneRecovery');
            const securityQuestions = document.getElementById('securityQuestions');
            
            phoneRecovery.style.display = phoneRecovery.style.display === 'none' ? 'block' : 'none';
            securityQuestions.style.display = 'none';
        }
        
        function useSecurityQuestions() {
            const phoneRecovery = document.getElementById('phoneRecovery');
            const securityQuestions = document.getElementById('securityQuestions');
            
            securityQuestions.style.display = securityQuestions.style.display === 'none' ? 'block' : 'none';
            phoneRecovery.style.display = 'none';
        }
        
        function sendPhoneCode() {
            const phoneNumber = document.getElementById('phoneNumber').value;
            
            if (!phoneNumber || phoneNumber.length < 10) {
                alert('Please enter a valid phone number');
                return;
            }
            
            alert('Verification code sent to: +1 ' + phoneNumber);
        }
        
        function verifySecurityAnswers() {
            const answer1 = document.getElementById('question1').value;
            const answer2 = document.getElementById('question2').value;
            const answer3 = document.getElementById('question3').value;
            
            if (!answer1 || !answer2 || !answer3) {
                alert('Please answer all security questions');
                return;
            }
            
            // Simulate verification
            alert('Security answers verified! You can now reset your password.');
        }
    </script>
</body>
</html>
