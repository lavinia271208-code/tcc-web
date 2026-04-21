<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Estúdio de Maquiagem</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

    <!-- header-start -->
    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-3">
                            <div class="logo-img">
                                <a href="index.html">
                                    <img src="img/logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9">
                            <div class="menu_wrap d-none d-lg-block">
                                <div class="menu_wrap_inner d-flex align-items-center justify-content-end">
                                    <div class="main-menu">
                                        <nav> <!-- ID'SSS -->
                                            <ul id="navigation">
                                                <li><a class="active" href="index.html">Home</a></li>
                                                <li><a href="#servicos">Serviços</a></li>
                                                <li><a href="{{ route('cadastro') }}">Cadastro</a></li>
                                                <li><a href="">Login</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="book_room">
                                        <div class="book_btn">
                                            <a class="popup-with-form" href="#test-form">Agendar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- header-end -->

    <!-- slider_area_start -->
    <div class="slider_area">
        <div class="slider_active owl-carousel">
            <div class="single_slider d-flex align-items-center justify-content-center slider_bg_1 overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="slider_text">
                                <h3>makeup studio</h3>
                                <p>Agende seu horário!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider d-flex align-items-center justify-content-center slider_bg_2 overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="slider_text">
                                <h3>makeup studio</h3>
                                <p>Agende seu horário!</p>
                                <a href="#" class="boxed-btn3">Agendar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider d-flex align-items-center justify-content-center slider_bg_3 overlay">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="slider_text">
                                <h3>makeup studio</h3>
                                <p>Agende seu horário!</p>
                                <a href="#" class="boxed-btn3">Agendar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- slider_area_end -->

    <!-- about_area_start -->
    <div class="about_area ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_thumbs">
                        <div class="large_img_1">
                            <img src="{{ asset('img/about/about_lft.png') }}" alt="">
                        </div>
                        <div class="small_img_1">
                            <img src="{{ asset('img/about/about_right.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="about_info">
                        <div class="section_title mb-20px">
                            <h3>Sobre nós</h3>
                            <p>Trabalhos com maquiagem e penteados. Encontre seu estilo!</p>
                        </div>
                        <p class="opening_hour">
                            Aberto
                            <span>08:00 - 20:00 </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about_area_end -->

    <div class="service_area" id="servicos">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-6 col-md-10">
                    <div class="section_title text-center mb-55">
                        <h3>Nossos Serviços</h3>
                        <p>Maquiagem e pentedos para noivas, debutantes, fantasias e mais.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                         <div class="service_thumb">
                             <img src="{{ asset('img/service/1.png') }}" alt="">
                         </div>
                         <div class="service_content text-center">
                            <div class="icon">
                                <i class="flaticon-shave"></i>
                            </div>
                            <h3>Noiva</h3>
                            <p>Maquiagem elaborada e delicada. Com tons leves e suaves.</p>
                         </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                         <div class="service_thumb">
                             <img src="{{ asset('img/service/2.png') }}" alt="">
                         </div>
                         <div class="service_content text-center">
                            <div class="icon">
                                <i class="flaticon-barber"></i>
                            </div>
                            <h3>Debutante</h3>
                            <p>Maquiagem elaborada e intensa. Com tons fortes e marcantes.</p>
                         </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_service">
                         <div class="service_thumb">
                             <img src="{{ asset('img/service/3.png') }}" alt="">
                         </div>
                         <div class="service_content text-center">
                            <div class="icon">
                                <i class="flaticon-null"></i>
                            </div>
                            <h3>Penteados</h3>
                            <p>Presos e semipresos. Elegantes e modernos.</p>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="prising_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="section_title mb-55">
                    <h3>Nossos preços</h3>
                    <p>Confira os valores dos nossos penteados e maquiagens.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="prising_slider_active owl-carousel">
                    <div class="prising_active d-flex justify-content-between">
                        
                        <div class="single_prising">
                            <div class="prise_title">
                                <h4>Maquiagens</h4>
                            </div>
                            
                            <div class="single_service">
                                <div class="service_inner">
                                    <div class="thumb">
                                        <img src="{{ asset('img/prising/1.png') }}" alt="Maquiagem Noiva">
                                    </div>
                                </div>
                                <div class="hair_style_info">
                                    <div class="prise d-flex justify-content-between">
                                        <span>Noiva</span>
                                        <span>R$ 450,00</span>
                                    </div>
                                    <p>Tons sutis</p>
                                </div>
                            </div>

                            <div class="single_service">
                                <div class="service_inner">
                                    <div class="thumb">
                                        <img src="{{ asset('img/prising/2.png') }}" alt="Maquiagem Debutante">
                                    </div>
                                </div>
                                <div class="hair_style_info">
                                    <div class="prise d-flex justify-content-between">
                                        <span>Debutante</span>
                                        <span>R$ 550,00</span>
                                    </div>
                                    <p>Tons marcantes</p>
                                </div>
                            </div>

                            <div class="single_service">
                                <div class="service_inner">
                                    <div class="thumb">
                                        <img src="{{ asset('img/prising/3.png') }}" alt="Maquiagem Casual">
                                    </div>
                                </div>
                                <div class="hair_style_info">
                                    <div class="prise d-flex justify-content-between">
                                        <span>Casual</span>
                                        <span>R$ 250,00</span>
                                    </div>
                                    <p>Neutra</p>
                                </div>
                            </div>
                        </div>

                        <div class="single_prising">
                            <div class="prise_title">
                                <h4>Penteado</h4>
                            </div>

                            <div class="single_service">
                                <div class="service_inner">
                                    <div class="thumb">
                                        <img src="{{ asset('img/prising/4.png') }}" alt="Rabo de Cavalo">
                                    </div>
                                </div>
                                <div class="hair_style_info">
                                    <div class="prise d-flex justify-content-between">
                                        <span>Rabo de Cavalo</span>
                                        <span>R$ 100,00</span>
                                    </div>
                                    <p>Preso com franja</p>
                                </div>
                            </div>

                            <div class="single_service">
                                <div class="service_inner">
                                    <div class="thumb">
                                        <img src="{{ asset('img/prising/5.png') }}" alt="Preso com Tiara">
                                    </div>
                                </div>
                                <div class="hair_style_info">
                                    <div class="prise d-flex justify-content-between">
                                        <span>Preso com Tiara</span>
                                        <span>R$ 120,00</span>
                                    </div>
                                    <p>Coque com cachos</p>
                                </div>
                            </div>

                            <div class="single_service">
                                <div class="service_inner">
                                    <div class="thumb">
                                        <img src="{{ asset('img/prising/6.png') }}" alt="Semipreso com Laço">
                                    </div>
                                </div>
                                <div class="hair_style_info">
                                    <div class="prise d-flex justify-content-between">
                                        <span>Semi Preso com Laço</span>
                                        <span>R$ 90,00</span>
                                    </div>
                                    <p>Delicado</p>
                                </div>
                            </div>
                        </div> </div> </div> </div>
        </div>
    </div>
</div>
    
   

   <footer class="footer"> <div class="copy-right_text">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="copy_right text-center"> <p>Copyright &copy; ... </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
    <!-- footer_end  -->


    <!-- form itself end-->
    <form id="test-form" class="white-popup-block mfp-hide">
            <div class="popup_box ">
                    <div class="popup_inner">
                        <h3>Solicite seu horário</h3>
                        <form action="#">
                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <input id="datepicker" placeholder="Date">
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <input id="timepicker" placeholder="time">
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <select class="form-select wide" id="default-select" class="">
                                        <option data-display="Escolha os serviços">Maquiagem de Noiva</option>
                                        <option value="1">Maquiagem de Debutante</option>
                                        <option value="3">Maquiagem Casual</option>
                                        <option value="4">Penteado Rabo de Cavalo</option>
                                        <option value="1">Penteado com Tiara</option>
                                        <option value="1">Penteado com Laço</option>
                                        <option value="1">Maquiagem + Penteado</option>
                                    </select>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <input type="text" placeholder="Seu nome">
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <input type="text" placeholder="Seu contato">
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <input type="email" placeholder="Seu e-mail">
                                </div>
                                <div class="col-xl-12">
                                    <button type="submit" class="boxed-btn3">Solicitar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </form>
<!-- form itself end -->

    <!-- JS here -->
    <script src="{{ asset('js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/ajax-form.js') }}"></script>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/scrollIt.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/gijgo.min.js') }}"></script>

    <script src="{{ asset('js/contact.js') }}"></script>
    <script src="{{ asset('js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('js/jquery.form.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/mail-script.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $('#datepicker').datepicker({
            iconsLibrary: 'fontawesome',
            disableDaysOfWeek: [0, 0], // Aqui você pode bloquear domingos, por exemplo
            // icons: {
            //  rightIcon: '<span class="fa fa-caret-down"></span>'
            // }
        });
        $('#datepicker2').datepicker({
            iconsLibrary: 'fontawesome',
            icons: {
                rightIcon: '<span class="fa fa-caret-down"></span>'
            }
        });
        var timepicker = $('#timepicker').timepicker({
            format: 'HH:MM'
        });
    </script>
</body>

</html>