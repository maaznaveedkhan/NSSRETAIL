<!DOCTYPE html>	
<html lang="">
	
	<head>
		<title>E-Khata</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link href="{{asset('E-khata')}}/layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
		<!-- Bootstrap CSS -->
	    <link href="{{asset('E-khata')}}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	     <!--Style CSS-->
	    <link href="{{asset('E-khata')}}/style/style.css" rel="stylesheet">

	    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css' rel='stylesheet'>
      <style></style>
      <script type='text/javascript' src=''></script>
      <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
      <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js'></script>
	</head>
	<body id="top">
		<!-- ################################################################################################ -->

		@yield('header')

		<!-- ################################################################################################ -->

		@yield('main_content')
		
		<!-- ################################################################################################ -->

		@yield('footer')			

		<!-- ################################################################################################ -->
		<script src="{{asset('E-khata')}}/bootstrap/js/bootstrap.min.js"></script>
		<script src="{{asset('E-khata')}}/jquery/jquery-3.6.0.min.js"></script>  		
		{{-- <script type="text/javascript">
			console.clear();

			var videoEl = document.querySelector("video");
			document.querySelector(".video-button").addEventListener("click", function () {
			  if (this.dataset.aperture === "open") {
			    this.dataset.aperture = "closed";
			    videoEl.pause();
			    videoEl.progress = 0;
			  } else {
			    this.dataset.aperture = "open";
			    videoEl.play();
			  }
			});
		</script> --}}
	</body>
</html>