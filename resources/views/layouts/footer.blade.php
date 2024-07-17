<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ecommerce Cart/Wishlist Page Design</title>
    @vite(['resources/scss/footer.scss', 'resources/css/app.css', 'resources/js/app.js'])
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

    <div>
        <div class="footer-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <a href="/">
                        <img src="/img/footerlogo.svg"  class="block h-20 w-auto" alt="logo">
                        </a>
                        <p class="pt-3 w-60">
                            Bake Street, your ultimate destination to satisfy your sweet tooth.
                        </p>
                    </div>
                    <div class="col-md-3">
                        <h4 class="footer-heading">Quick Links</h4>
                        <div class="footer-underline"></div>
                        <div class="mb-2 hover:font-bold"><a href="/" class="text-white">Home</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/about-us" class="text-white">About Us</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/allproducts" class="text-white">All Products</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/contactus/create" class="text-white">Contact Us</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/blog" class="text-white">Blogs</a></div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="footer-heading">Shop By</h4>
                        <div class="footer-underline"></div>
                        <div class="mb-2 hover:font-bold"><a href="{{ route('bakeries.list') }}" class="text-white">Bakery</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/christmas" class="text-white">Christmas</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/selfcollect" class="text-white">Self-Collect</a></div>
                        <div class="mb-2 hover:font-bold"><a href="{{ route('corporateOrder') }}" class="text-white">Corporate Order</a></div>
                        <div class="mb-2 hover:font-bold"><a href="/customise-cake" class="text-white">Cake Customisation</a></div>
                    </div>
                    <div class="col-md-3">
                        <h4 class="footer-heading">Contact Us</h4>
                        <div class="footer-underline"></div>
                        
                        <div class="mb-2 pt-1">
                            <a href="tel:+60312345678" class="text-white">
                                <i class="fa fa-phone pr-1"></i> +603 1234 5678
                            </a>
                        </div>
                        <div class="mb-2 pt-1">
                            <a href="mailto:bakestreet.official@gmail.com" class="text-white">
                                <i class="fa fa-envelope pr-1"></i> bakestreet.official@gmail.com
                            </a>
                        </div>
                        <div class="mb-2 pt-1 w-60">
                            <a>
                                <i class="fa fa-map-marker pr-1"></i> No. 5, Jalan Universiti, Bandar Sunway 47500 Selangor.
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <p class=""> &copy; 2024 Bake Street. All rights reserved.</p>
                    </div>
                    <div class="col-md-4">
                        <div class="social-media">
                            Get Connected:
                            <a href=""><i class="fa fa-facebook"></i></a>
                            <a href=""><i class="fa-brands fa-x-twitter"></i></a>
                            <a href=""><i class="fa fa-instagram"></i></a>
                            <a href=""><i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>