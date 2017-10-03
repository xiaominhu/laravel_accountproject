<html lang="en"><!--<![endif]--><!-- BEGIN HEAD --><head>
        <meta charset="utf-8">
        <title>WaZaPAY | Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="Login for WaZaPAY" name="description">
        <meta content="" name="author">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
		
       
		<link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		
		<link href="{{ URL::asset('assets/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css">
		
       
		<link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
		
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="{{ URL::asset('assets/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('assets/select2/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css">
		
		<link href="{{ URL::asset('assets/components.min.css') }}" rel="stylesheet" type="text/css">
		
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
		<link href="{{ URL::asset('assets/login.min.css') }}" rel="stylesheet" type="text/css">
		
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('assets/custom.css') }}" rel="stylesheet" type="text/css">
		
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico"> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="index-home.html">
                <img src="images/logo.png" alt=""> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="index-home.html" method="post" novalidate="novalidate">
            <!--Please check the login action tap-->
                <h3 class="form-title font-green">Sign In</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any phone number and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Phone Number</label>
                    <input class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="Phone Number" name="phone" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">e-Wallet PIN</label>
                    <input class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="e-wallet PIN" name="pin" type="password"> </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-green uppercase">Login</button>
                    <label class="rememberme check mt-checkbox mt-checkbox-outline">
                        <input name="remember" value="1" type="checkbox">Remember
                        <span></span>
                    </label>
                    <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                </div>
                <div class="login-options">
                    <h4>Or login with</h4>
                    <ul class="social-icons">
                        <li>
                            <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                        </li>
                        <li>
                            <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                        </li>
                    </ul>
                </div>
                <div class="create-account">
                    <p>
                        <a href="javascript:;" id="register-btn" class="uppercase">Create a client account</a>
                    </p>
                </div>
                <div class="create-account">
                    <p>
                        <a href="#" id="register-vendor-btn" class="uppercase">Create a vendor account</a>
                    </p>
                </div>
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="index.home.html" method="post" novalidate="novalidate">
                <h3 class="font-green">Forget Password ?</h3>
                <p> Enter your e-mail address below to reset your password. </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" autocomplete="off" placeholder="Email" name="email" type="text"> 
				</div>
				<p><b>OR</b></p>			
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" autocomplete="off" placeholder="Phone Number" name="phone" type="text"> 
				</div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn btn-default btn-outline">Back</button>
                    <button type="submit" class="btn btn-green uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM - CLIENTS -->
            <form class="register-form" action="index.home.html" method="post" novalidate="novalidate">
                <h3 class="font-green">Sign Up</h3>
                <p class="hint"> Enter your personal details below: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                    <input class="form-control placeholder-no-fix" placeholder="Full Name" name="fullname" type="text"> </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control placeholder-no-fix" placeholder="Email" name="email" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Phone Number</label>
                    <input class="form-control placeholder-no-fix" placeholder="Phone Number" name="phone" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">e-Wallet PIN</label>
                    <input class="form-control placeholder-no-fix" placeholder="e-Wallet PIN" name="pin" type="text"> </div>
				<div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input name="tnc" type="checkbox"> I agree to the
                        <a href="javascript:;">Terms of Service </a> &amp;
                        <a href="javascript:;">Privacy Policy </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn btn-default">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-green uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END REGISTRATION FORM - CLIENTS -->
            <!-- BEGIN REGISTRATION FORM - VENDORS -->
            <form class="register-vendor-form" action="index.home.html" method="post" style="display: none;">
                <h3 class="font-green">Sign Up</h3>
                <p class="hint"> Enter your personal details below: </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Company Name or Service</label>
                    <input class="form-control placeholder-no-fix" placeholder="Company Name or Service" name="fullname" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Business License Number</label>
                    <input class="form-control placeholder-no-fix" placeholder="Business License Number" name="license" type="text"> </div>
				<div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control placeholder-no-fix" placeholder="Email" name="email" type="text"> </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Location</label>
                    <input class="form-control placeholder-no-fix" placeholder="Location" name="location" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">City</label>
                    <input class="form-control placeholder-no-fix" placeholder="City" name="city" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Region</label>
                    <input class="form-control placeholder-no-fix" placeholder="Region" name="region" type="text"> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Phone Number</label>
                    <input class="form-control placeholder-no-fix" placeholder="Phone Number" name="phone" type="text"> </div>
				<div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input name="tnc" type="checkbox"> I agree to the
                        <a href="javascript:;">Terms of Service </a> &amp;
                        <a href="javascript:;">Privacy Policy </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                <div class="form-actions">
                    <button type="button" id="vendor-register-back-btn" class="btn btn-default">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-green uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END REGISTRATION FORM - VENDORS -->
        </div>
        <div class="copyright"> 2016 © WaZaPAY </div>
        <!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script> 
<script src="assets/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
		<script type="text/javascript" src="{{URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
		
		<script type="text/javascript" src="{{URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		
		<script type="text/javascript" src="{{URL::asset('assets/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
		
		
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<script type="text/javascript" src="{{URL::asset('assets/jquery-validation/jquery.validate.min.js') }}"></script>
		<script type="text/javascript" src="{{URL::asset('assets/jquery-validation/additional-methods.min.js') }}"></script>
		
     
		<script type="text/javascript" src="{{URL::asset('assets/select2/select2.full.min.js') }}"></script>
		
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script type="text/javascript" src="{{URL::asset('assets/app.min.js') }}"></script>
		
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script type="text/javascript" src="{{URL::asset('assets/login.min.js') }}"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    

</body></html>