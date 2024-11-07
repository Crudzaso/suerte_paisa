<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/home-layout.css') }}">
    <title>Document</title>
</head>
<body>
    <header>
        <section class="top-header">
            <article>
                <p class="top-header-text">Participa en rifas activas 24/7!!</p>
            </article>
        </section>
        <nav class="bottom-header">
            <a href=""><img class="img-navbar" src="./th-removebg-preview.png" alt=""></a>
    
            <div class="links md:flex hidden space-x-4">
                <a href="">Sorteos</a>
                <a href="">Resultados</a>
                <a href="">Guía</a>
                <a href="">Transparencia</a>
            </div>
    
            <div class="auth-links md:flex hidden space-x-4 auth-buttons">
                <a href="">INICIAR SESION</a>
                <a href="">REGISTRARSE</a>
            </div>
    
            <!-- Botón de menú hamburguesa -->
            <button id="menu-toggle" class="hamburger-menu block md:hidden p-2">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </nav>
    
        <!-- Menú desplegable en modo móvil -->
        <div id="mobile-menu" class="md:hidden mobile-hamburguer">
            <a href="">Sorteos</a>
            <a href="">Resultados</a>
            <a href="">Guía</a>
            <a href="">Transparencia</a>
            <div class="auth-buttons">
                <a href="">INICIAR SESION</a>
                <a href="">REGISTRARSE</a>
            </div>
        </div>
    </header>

    <footer>
        <section class="top-footer">
            <article class="map-footer">
                <div>
                    <i class="bi bi-geo-alt-fill"></i>
                    <h5>Ubicacion</h5>
                </div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3378179448664!2d-75.58618982416107!3d6.219106326624008!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e44293f0e114eef%3A0x99610cdd44c7c081!2sRiwi!5e0!3m2!1ses!2sco!4v1730928081957!5m2!1ses!2sco" width="310" height="310" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </article>

            <article class="contact-footer">
                <div class="title-contact-footer">
                    <i < class="bi bi-person-lines-fill"></i>
                    <h5>Contacto</h5>
                </div>

                <div class="ancords-contact-footer">
                    <a href="https://wa.link/2kyeqs">
                        <i class="bi bi-whatsapp"></i>
                        <h5>WhatsApp</h5>
                    </a>
    
                    <a href="mailto:juanjoarenas1218@gmail.com">
                        <i class="bi bi-envelope"></i>
                        <h5>Email</h5>
                    </a>
                    <a href="tel:+573022260938">
                        <i class="bi bi-telephone"></i>
                        <h5>Telefono</h5>
                    </a>
                </div>
            </article>
            


            <article class="social-media-footer">
                <div class="title-media-footer">
                    <i class="bi bi-bezier2"></i>
                    <h5>Redes sociales</h5>
                </div>

                <div class="social-footer-ancords">
                    <a href="#">
                        <i class="bi bi-instagram"></i>
                        <h5>Instagram</h5>
                    </a>
                    <a href="#">
                        <i class="bi bi-twitter-x"></i>
                        <h5>Twitter</h5>
                    </a>
                </div>
            </article>
        </section>
        <section class="bottom-footer">
            <p>© Copyright 2024 - Todos los derechos reservados.</p>
        </section>
     </footer>
     <script>
        const menuToggle = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");
    
        menuToggle.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>
</body>
</html>