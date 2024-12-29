<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Cadastro de UBS</title>
</head>
<body>
    <h1>Cadastro Realizado com Sucesso!</h1>
    <p>Olá, {{ $ubs->nomeUBS }}!</p>
    <p>Sua unidade foi cadastrada com sucesso no sistema.</p>
    <p>Detalhes:</p>
    <ul>
        <li>CNPJ: {{ $ubs->cnpjUBS }}</li>
        <li>Endereço: {{ $ubs->logradouroUBS }}, {{ $ubs->numeroUBS }}</li>
        <li>Cidade: {{ $ubs->cidadeUBS }} - {{ $ubs->ufUBS }}</li>
        <li>E-mail: {{ $ubs->emailUBS }} </li>
    </ul>
    <p>Para inserir sua senha, visite <a href="http://127.0.0.1:8000/verificacao">nosso site</a>.</p>
    
    
    <p>Obrigado!</p>
</body>
</html>
