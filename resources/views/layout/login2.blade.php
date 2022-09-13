@extends('layout.home_display')
    @section('header')
    	@include('layout.header')
    @endsection
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://web.digikhata.pk/css/web_app.css" rel="stylesheet"> -->
	<style type="text/css">
		.login_page{	    
		    width: 100%;
		    height: auto;
		    background-color: #f5781e;
		    background-image: url('{{asset("E-khata")}}/images/bg-login.png');
		    background-repeat: no-repeat;
	  		background-size: auto; 
		}

		.row.bg-white.rounded-lg {
		    border-radius: 30px;
		}
		.img_input{
			display: flex;
			height: 35px;
			border-radius: 20px;
			border: 1px solid black;
		    margin-left: 8px;
		}

		input#phone_number {
		    border-top-style: hidden;
		    border-right-style: hidden;
		    border-left-style: hidden;
		    border-bottom-style: hidden;
		    width: auto;
		    border-radius: 30px;
		    background-color: transparent;
		}
		
		.img_input img{
			margin: 3px 5px 4px;
			width: 30px;	
		}
		.img_input span{
			margin: 6px 0px 5px 0px;
		}

		button.btn.btn-sm.get_pin_button {
		    background-color: #f47112;
		    display: inline-block;
		    width: 200px;
		    border-radius: 10px;
		    margin-top: 20px;
		}

		@media screen and (min-width: 100rem) {
		  div.img_input {
		   width: 60%;
		  }
		}

		.two-column {
		  -moz-column-count: 2;
		  -webkit-column-count: 2;
		  column-count: 2;
		  -moz-column-rule-style: solid;
		  -webkit-column-rule-style: solid;
		  column-rule-style: solid;
		  -moz-column-rule-color: black;
		  -webkit-column-rule-color: black;
		  column-rule-color: black;
		  -moz-column-rule-width: 5px;
		  -webkit-column-rule-width: 5px;
		  column-rule-width: 5px;
		  border-radius: 10px;
		  height: 300px;
		  width: 100%;
		  margin: 10px auto 10px auto;
		}


		.vl{
			border-left:1px solid black;
		    height:150px;
		}	
	</style>

    @section('main_content')

		<!-- <div class="login_page p-3">
		    <h3 class="text-center">E-Khata</h3>
			<div class="two-column bg-white">
				<div class="p-4">
					<h4>To use E-Khata on your computer:</h4>
					<ol class="list-group list-group-numbered">
						<li>
							Enter Your Phone Number
						</li>
						<li>
							Digi Khata will send you 6-digit code to verify your number
						</li>
						<li>
							Enter the 6-digit code and login
						</li>
					</ol>
				</div>

				<div class="p-4">
					<h5>Enter your Phone Number</h5>
					<div class="img_input">
						<img src="{{asset('E-khata')}}/images/flag-symbolism-Pakistan-design-Islamic.png"><span>+92</span><input type="text" name="phone_number" id="phone_number" class="text_input">

					</div>
						<button class="btn btn-sm get_pin_button">Get Pin</button>
				</div>
			</div>
		</div> -->

		<div class="container-fluid login_page p-5">
			<div class="row">
				<div class="col-md-12">
		    		<h3 class="text-center">E-Khata</h3>					
				</div>
			</div>
			<div class="row bg-white rounded-lg">
				<div class="col-md-6 p-5">
					<h4>To use E-Khata on your computer:</h4>
					<ol class="list-group list-group-numbered">
						<li>
							Enter Your Phone Number
						</li>
						<li>
							Digi Khata will send you 6-digit code to verify your number
						</li>
						<li>
							Enter the 6-digit code and login
						</li>
					</ol>
				</div>
				<div class="col-md-1 mt-5 mb-5">
					<div class="vl"></div>					
				</div>
				<div class="col-md-5 p-5 text-center">
					<div class="alert alert-danger" id="error" style="display: none;"></div>
					<h5>Enter your Phone Number</h5>
					<div class="alert alert-success" id="successAuth" style="display: none;"></div>
					<form action="">
                        <div class="img_input">
                            <img src="{{asset('E-khata')}}/images/flag-symbolism-Pakistan-design-Islamic.png" />
                            <span>+92</span>
                            <input type="text" name="number" id="number" class="text_input" />
                            
                        </div>
                        <div id="recaptcha-container"></div>
                        <button class="btn btn-sm get_pin_button" onclick="sendOTP();"><span><b>Get Pin</b></span></button>
                    </form>
				</div>
				<div class="mb-5 mt-5">
					<h3>Add verification code</h3>
					<div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>

					<form>
						<input type="text" id="verification" class="form-control" placeholder="Verification code">
						<button type="button" class="btn btn-danger mt-3" onclick="verify()">Verify code</button>
					</form>
				</div>
			</div>
		</div>
		<!-- <div class="landing-wrapper container-fluid">
			<div class="landing-header mb-4">
				<span class="digikhata-logo">
					<img src="https://web.digikhata.pk/images/web-app/logo.png" class="loginPage_logo" alt="">
				</span>
			</div>
			<div class="login-window offset-md-1 col-md-10 offset-md-1 login-main">
				<div class="col-lg-5 col-md-6 col-12 pr-0 landing-right-block text-center  float-right">
					<form method="post" role="form" id="login_form" class="mb-0" action="https://web.digikhata.pk/find" name="login_form">
						<input type="hidden" name="_token" value="HWALWXhnqDUfUuSQiIHQzsyL1YQNEfkqdZOC9e5W">
						<div id="number_block">
							<div class="loader_cricle display-none" id="loader"></div>
								<div class="login-title">
									<span class="heading-1">Enter Your Phone Number </span>
							</div>
							<div class="iti iti--separate-dial-code">
								<div class="iti__flag-container">
									<div class="iti__selected-flag" role="combobox" aria-owns="iti-0__country-listbox" aria-expanded="false" title="Pakistan (&#x202B;پاکستان&#x202C;&lrm;): +92">
										<div class="iti__flag iti__pk"></div>
										<div class="iti__selected-dial-code">+92</div>
									</div>
								</div>
								<input name="phone" id="number" min="0" inputmode="numeric" class="number-field" type="number" autocomplete="adad" autofocus="" placeholder="301 2345678" style="padding-left: 85px;">
								<input type="hidden" name="number">
							</div>
							<p class="phone-error pt-1 m-0" id="invalid_phone">Please Enter Valid Phone Number </p>
							<p class="color-red font-13 display-none pt-2 text-center text-sm-left" id="promotional_error">Please Unblock Promotional message to get the otp </p>
							<br>
							<button type="submit" disabled="" id="send_otp" class="btn btn_next mt-md-5 mt-2 color-white">
							GET PIN
							</button>
						</div>
						<div class="loader_cricle loader-afterOtp display-none" id="loader_afterOtp"></div>
			 			<div id="resend_otp1" class="display-none">
							<span class="display-flex cursor-pointer">
								<img id="" class="" src="https://web.digikhata.pk/images/web-app/sms_icon.svg" alt="">
								<span class="font-12 pl-1">Resend Code by SMS </span>
							</span>
							<br>
							<span class="display-flex cursor-pointer">
								<img class="" src="https://web.digikhata.pk/images/web-app/call_icon.svg" alt="">
								<span class="font-12 pl-1">Resend Code by Call </span>
							</span>
						</div>
					</form>
					<div id="business-name-block" style="display: none">
						<form action="https://web.digikhata.pk/business/store" method="post">
							<input type="hidden" name="_token" value="HWALWXhnqDUfUuSQiIHQzsyL1YQNEfkqdZOC9e5W">
							<div class="login-title">
								<span class="heading-1">Enter your Business Name </span>
							</div>
							<input type="text" autocomplete="off" class="form-control business-field" placeholder="Enter your Business name" name="business_name" id="business_name_input" required=""> <br>
							<input type="submit" value="SAVE"id="add_businessBtn" class="btn btn_next mt-5 color-white">
						</form>
					</div>
				</div>
				<div class="col-lg-7 col-md-6 col-12 landing-left-block float-left border-right-272727 margin-top-urdu">
					<div class="login-title">
						<span class="heading-1 login-heading-one semi-bold">To use Digi Khata on your computer: </span>
					</div>
					<ol class="login-list">
						<li>Enter Your Phone Number </li>
						<li>
							Digi Khata will send you 6-digit code to verify your number
						</li>
						<li>Enter the 6-digit code and login </li>
					</ol>
				</div>
			</div>
		</div> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<script>
	var firebaseConfig = {
		apiKey: "AIzaSyBGhyp0Bt_iMqITUeRMC3A_XnSyg3-eSwU",
authDomain: "ekhata-e128b.firebaseapp.com",
projectId: "ekhata-e128b",
storageBucket: "ekhata-e128b.appspot.com",
messagingSenderId: "894836973005",
appId: "1:894836973005:web:0169be2cd4d6253a20b884",
measurementId: "G-LSFJGTTG2N"
	};
	firebase.initializeApp(firebaseConfig);
</script>
<script type="text/javascript">
	window.onload = function () {
		render();
	};
	function render() {
		window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
		recaptchaVerifier.render();
	}
	function sendOTP() {
		var number = $("#number").val();
		firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
			window.confirmationResult = confirmationResult;
			coderesult = confirmationResult;
			console.log(coderesult);
			$("#successAuth").text("Message sent");
			$("#successAuth").show();
		}).catch(function (error) {
			$("#error").text(error.message);
			$("#error").show();
		});
	}
	function verify() {
		var code = $("#verification").val();
		coderesult.confirm(code).then(function (result) {
			var user = result.user;
			console.log(user);
			window.location.href= "{{ route('all_business',['phone'=>$phone]) }}";
			$("#successOtpAuth").text("Auth is successful");
			$("#successOtpAuth").show();
		}).catch(function (error) {
			$("#error").text(error.message);
			$("#error").show();
		});
	}
</script>
@endsection

