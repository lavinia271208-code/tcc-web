<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Makeup Studio</title>
</head>
<body>

<div class="make_apppointment_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="appoint_ment_form">
                    <div class="section_title text-center mb-55">
                        <h3>Criar sua conta</h3>
                        <p>Preencha os dados abaixo para se cadastrar</p>
                    </div>
                    
                    <form action="{{ route('cadastro.store') }}" method="POST">
                        @csrf
                        
                        <div class="single_field">
                            <input type="text" placeholder="Seu nome" name="nome" required>
                        </div>
                        
                        <div class="single_field">
                            <input type="email" placeholder="Seu e-mail" name="email" required>
                        </div>
                        
                        <div class="single_field">
                            <input type="tel" placeholder="Seu contato" name="telefone" required>
                        </div>
                        
                        <div class="single_field">
                            <input type="password" placeholder="Senha" name="password" required>
                        </div>
                        
                        <div class="single_field">
                            <input type="password" placeholder="Confirmar senha" name="password_confirmation" required>
                        </div>
                        
                        <div class="single_field text-center">
                            <button type="submit" class="boxed-btn3">Cadastrar</button>
                        </div>
                        
                        <p class="text-center mt-20">
                            Já tem uma conta? <a href="{{ route('login') }}">Faça login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.make_apppointment_area {
    padding-top: 150px;
    padding-bottom: 120px;
    background: #fdf9f6;
}

@media (max-width: 767px) {
    .make_apppointment_area {
        padding-top: 60px;
        padding-bottom: 30px;
    }
}

.make_apppointment_area .appoint_ment_form {
    margin-bottom: 30px;
}

.make_apppointment_area .appoint_ment_form form .single_field {
    margin-bottom: 32px;
}

.make_apppointment_area .appoint_ment_form form .single_field input,
.make_apppointment_area .appoint_ment_form form .single_field textarea {
    width: 100%;
    border: 0;
    padding-bottom: 3px;
    border-bottom: 1px solid #c1c1c1;
    padding-left: 10px;
    height: 50px;
    font-family: "Lato", sans-serif;
    color: #1a1a1a;
    background: transparent;
}

.make_apppointment_area .appoint_ment_form form .single_field input::placeholder,
.make_apppointment_area .appoint_ment_form form .single_field textarea::placeholder {
    color: #96989a;
    font-weight: 400;
    font-family: "Lato", sans-serif;
}

.make_apppointment_area .appoint_ment_form form .single_field input:focus,
.make_apppointment_area .appoint_ment_form form .single_field textarea:focus {
    outline: none;
}

.make_apppointment_area .appoint_ment_form form .single_field textarea {
    resize: none;
    margin-top: 41px;
    padding: 11px 20px 14px 10px;
}

.make_apppointment_area .appoint_ment_form form .single_field:last-child {
    margin-bottom: 0;
}

.make_apppointment_area .appoint_ment_form form button {
    transition: .3s;
    cursor: pointer;
}

.make_apppointment_area .appoint_ment_form form p {
    margin-top: 17px;
    margin-bottom: 40px;
    font-size: 16px;
    font-weight: 400;
    color: #464444;
    line-height: 30px;
}

/* Estilo do botão */
.boxed-btn3 {
    display: inline-block;
    padding: 12px 35px;
    background: #1a1a1a;
    color: #fff;
    border: none;
    font-family: "Lato", sans-serif;
    font-weight: 600;
    font-size: 16px;
    transition: .3s;
    cursor: pointer;
}

.boxed-btn3:hover {
    background: #4a4948;
}

/* Estilo para links */
.appoint_ment_form a {
    color: #4a4948;
    text-decoration: underline;
    transition: .3s;
}

.appoint_ment_form a:hover {
    color: #1a1a1a;
}

/* Utilitários */
.text-center {
    text-align: center;
}

.mb-55 {
    margin-bottom: 55px;
}

.mt-20 {
    margin-top: 20px;
}

.section_title h3 {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 15px;
    font-family: "Lato", sans-serif;
}

.section_title p {
    font-size: 16px;
    color: #7f7f7f;
    font-family: "Lato", sans-serif;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -15px;
}

.justify-content-center {
    justify-content: center;
}

.col-xl-6 {
    flex: 0 0 50%;
    max-width: 50%;
    padding: 0 15px;
}

.col-lg-8 {
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
}

.col-md-10 {
    flex: 0 0 83.333333%;
    max-width: 83.333333%;
}

@media (max-width: 992px) {
    .col-xl-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .section_title h3 {
        font-size: 28px;
    }
}

/* Estilo para todos os links do menu */
.main-menu a,
nav a,
header nav a {
    color: #4a4948 !important;
    text-decoration: none;
    transition: .3s;
    font-family: "Lato", sans-serif;
}

.main-menu a:hover,
nav a:hover,
header nav a:hover {
    color: #1a1a1a !important;
}

/* Remove o azul padrão do navegador */
a:link,
a:visited {
    color: #4a4948;
}

/* Específico para o link de cadastro no menu */
a[href="/cadastro"],
a[href="#cadastro"],
a[href="{{ route('cadastro') }}"] {
    color: #4a4948 !important;
}
</style>

</body>
</html>