<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/cadfarmacia.css')}}">

	<title>Login | BuscaSUS </title>
	<link rel="shortcut icon" href="{{ asset('Image/favicon (1).ico')}}" type="image/x-icon">

</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('Image/logoFarma.png')}}" alt="IMG" style=" width: 350% ; margin-top: -38%">
				</div>

				<form class="login100-form validate-form" action="/farmaciaLogin" method="post">
					<span class="login100-form-title" style="font-size: 20px; margin-top: -25% "> Farmácia | Login </span>
					@csrf
                    <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input" type="text" name="cnpj" placeholder="CNPJ">
						<span class="focus-input"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
                    

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input" type="password" name="senha" placeholder="Senha">
						<span class="focus-input"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn"type="submit">
							Login
						</button>
					</div>

					<div class="text-center p-t-24">
						<a class="txt2" href="/cadastroFarmacia">
							Não Possui cadastro ?
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>

                    <div class="text-center p-t-24">
						<a class="txt2" href="/login">
							Não é Farmácia ?
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>

				</form>
			</div>
		</div>
	</div>
	
	

		
	<script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{ asset('vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('vendor/select2/select2.min.js')}}"></script>
	<script src="{{ asset('vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<script src="{{ asset('js/main.js')}}"></script>

</body>
</html>