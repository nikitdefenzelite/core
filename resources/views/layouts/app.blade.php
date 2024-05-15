<!DOCTYPE html>
<html lang="en">

<head>
	@yield('meta_data')
   @include('site.include.head')
   @stack('head')
</head>

	<body>
		<div>
			<!-- initiate header-->
			<div class="content-wrapper">
				@include('site.include.header')
				<div class="main-content pl-0 ">
					@yield('content')
				</div>
			</div>
			<!-- Back to top -->
			<a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle" style="height: 32px !important;"></i></a>
			@if (!isset($customer))
				@include('site.include.footer')
			@else
				@include('site.include.footer_bar')
			@endif
		</div>
		
		<!-- initiate scripts-->
		@include('site.include.script')
		@stack('script')
	</body>
</html>