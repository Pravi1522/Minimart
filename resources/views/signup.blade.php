@extends('layouts.app')
@section('content')
<main id="site-content" role="main" class="main-container">
	<section class="col-md-4 py-5 my-3 mx-auto">
		<div class="border mx-auto px-4 py-4 rounded-4 w-100 py-4">
			<h3 class="fs-4 mb-4 mx-auto text-center">Signup</h3>
			<div class="card-body transition-none">
				<div class="form">
					<form action="{{ route('create_user') }}" method="POST" class="" id="signup_form">
						@csrf
						<div class="form-floating">
							<input type="text" name="email" class="form-control" id="signup_email" placeholder="Email" value="{{ old('email') }}">
							<label for="signup_email" class="form-label"> Email </label>
							<span class="text-danger"> {{ $errors->first('email') }} </span>
						</div>
						<div class="form-floating">
							<input type="text" name="first_name" class="form-control" placeholder="First name" value="{{ old('first_name') }}">
							<label for="first_name" class="form-label"> First name </label>
							<span class="text-danger"> {{ $errors->first('first_name') }} </span>
						</div>
						<div class="form-floating">
							<input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ old('last_name') }}">
							<label for="last_name" class="form-label"> Last name  </label>
							<span class="text-danger"> {{ $errors->first('last_name') }} </span>
						</div>
						<div class="password-with-toggler input-group floating-input-group">
							<div class="form-floating flex-grow-1 mb-0">
								<input type="password" name="password" class="password form-control" placeholder="Password" id="password">
								<label for="password" class="form-label">Password</label>
							</div>
						</div>
						<span class="text-danger"> {{ $errors->first('password') }} </span>
						<div class="form-group mt-4">
							<button type="submit" class="btn btn-primary d-flex w-100 justify-content-center">
							Signup
							</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</main>
@endsection


