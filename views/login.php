<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/assets/css/style_telaLogin.css">
    <title>Login - Gestão Loja</title>
</head>

<body>
    <div class="main">
        <div class="centralizar">
            <div class="loginContainer">
                <div class="logo-container">
                    <img src="public/assets/img/logo/top_motos.png" alt="">
                </div>
                <form action="autenticacao" method="post">
                    <div class="row">
                        <div class="column">
                            <label for="email-user">Email:</label>
                            <input type="email" name="email-user">
                        </div>
                        <div class="column">
                            <label for="senha-user">Senha:</label>
                            <input type="password" name="senha-user">
                        </div>
                        <div class="submit-container">
                            <button type="submit">Entrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>