@extends('layouts.app')
@section('content')
<main id="site-content" role="main" class="main-container px-2">
	<section class="col-xxl-3 col-xl-4 col-md-6 py-5 hstack login-form-wrap mx-auto my-3">
		<div class="border mx-auto px-4 py-4 rounded-4 w-100 py-4">
			<h3 class="fs-4 mb-4 mx-auto text-center">Login</h3>
			<div class="card-body transition-none">
				<div class="form">
					<form action="{{ route('authenticate') }}" method="POST" class="form-horizontal" id="user_login_form">
						@csrf
						<div class="form-floating">
							<input type="text" name="email" value="{{  'praveena@gmail.com'}}" class="email form-control" placeholder="Email">
							<label class="form-label"> Email </label>
							 <span class="text-danger">{{ $errors->first('email') }}</span>
						</div>
						<div class="password-with-toggler input-group floating-input-group flex-nowrap">
							<div class="form-floating flex-grow-1">
								<input type="password" name="password" class="password password form-control" value="{{  '12345678'}}" placeholder="Password">
								<label class="form-label"> Password </label>
								 <span class="text-danger">{{ $errors->first('password') }}</span>
							</div>
							<span class="input-group-text"><i class="icon icon-eye cursor-pointer toggle-password active" area-hidden="true"></i></span>
						</div>
						<div class="form-floating mt-4">
							<button type="submit" class="btn btn-primary d-flex w-100 justify-content-center disable-after-click">
								Login
							</button>
						</div>
					</form>
				</div>
				<div class="mt-4 text-center">
					<a href="{{ route('signup') }}" class="">
						Signup
					</a>
				</div>
			</div>
		</div>
	</section>
</main>
@endsection