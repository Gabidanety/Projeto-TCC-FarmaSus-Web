<!--CSS OK, ASS:DUDA-->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="{{ asset('css/Farmacia-CSS/Verificacao.css')}}">

    <title>Login Farmácia | FarmaSUS</title>
    <link rel="shortcut icon" href="{{ asset('Image/favicon-farmacia.ico')}}" type="image/x-icon">
</head>
<body>
    <div class="login-container">
        <div class="login-image">
            <img src="{{ asset('Image/loginFarmacia3.gif')}}" alt="Ilustração de login">
        </div>
        
        <!-- Lado do formulário -->
        <div class="login-form">
            <h1> Login Farmácia </h1>
            <form id="formCadastrar" action="{{ route('verificar.email') }}" method="POST">
                @csrf
                <label for="email"></label>
                <input type="email" name="email" id="email" placeholder="Digite seu email" required>

                <label for="senha"></label>
                <input type="password" name="senha" id="senha" class="form-control" placeholder="Digite sua senha" required>

                <button type="submit" class="btn-login">LOGIN</button>
                <p class="signup-link">
                    Não é Farmácia? <a href="/login">Clique aqui</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
