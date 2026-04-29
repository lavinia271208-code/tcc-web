<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Makeup Studio</title>
</head>
<body>
<header style="display:flex; justify-content:space-between; padding:20px;">
    <a href="/" style="
    text-decoration: none; 
        background-color: #e6b0a2; 
        color: white; 
        padding: 10px 25px; 
        display: inline-block;">Home</a>
</header>


<div class="make_apppointment_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="appoint_ment_form">
                    <div class="section_title text-center mb-55">
                        <h3>Crie sua conta</h3>
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
                            Já tem uma conta? <a href="{{ route('login') }}" style="text-decoration: none; color: #e6b0a2; font-weight: bold;">Faça login</a>
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

.make_apppointment_area .appoint_ment_form form .single_field {
    margin-bottom: 32px;
}

.make_apppointment_area .appoint_ment_form form .single_field input,
.make_apppointment_area .appoint_ment_form form .single_field select {
    width: 100%;
    border: 0;
    border-bottom: 1px solid #c1c1c1;
    padding-left: 10px;
    height: 50px;
    font-family: "Lato", sans-serif;
    color: #fff;
    background: transparent;
}

.make_apppointment_area .appoint_ment_form form .single_field select {
    appearance: none;
    color: #96989a;
}

.make_apppointment_area .appoint_ment_form form .single_field input:focus,
.make_apppointment_area .appoint_ment_form form .single_field select:focus {
    outline: none;
    border-bottom: 1px solid #000;
}

.make_apppointment_area .appoint_ment_form form .single_field input::placeholder {
    color: #96989a;
}

.boxed-btn3 {
    display: inline-block;
    padding: 12px 35px;
    background: #e5b0a3;
    color: #fff;
    border: none;
    font-family: "Lato", sans-serif;
    font-weight: 600;
    font-size: 16px;
    transition: .3s;
    cursor: pointer;
    text-decoration: none;
}

.boxed-btn3:hover {
    background: #fff;
}

.appoint_ment_form a {
    color: white;
    transition: .3s;
}

.appoint_ment_form a:hover {
    color: #fff;
}

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
text-decoration: none,
header nav a:hover {
    color: #1a1a1a !important;
}

a:visited {
    color: #1a1a1a;
}

a[href="/cadastro"],
a[href="#cadastro"],
a[href="{{ route('cadastro') }}"] {
    color: #4a4948 !important;
}
</style>
</body>
</html>