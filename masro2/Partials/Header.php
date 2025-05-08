<?php

use App\Cart;
session_start();
$isLoggedIn = false;
if (isset($_SESSION["userId"])) {
    $isLoggedIn = true;
    $userId = $_SESSION["userId"];
}

?>

<header class="bg-main py-3 border-b border-b-black sticky z-50 top-0">
    <div class="container flex justify-around items-center">
        <a href="/art_gallery/" class="logo text-2xl sm:text-3xl md:text-4xl flex-1">
            <span>ArtGallery</span>
        </a>
        <?php if (!$isLoggedIn) : ?>
            <nav class="flex-1 hidden md:block">
                <ul class="flex justify-around list-none">
                    <li>
                        <a class="block lg:text-lg p-2 relative group" href="/art_gallery/Pages/login.php">
                            <span class="absolute left-[50%] translate-x-[-50%] top-0 w-full h-[2px] rounded-lg scale-x-0 group-hover:scale-x-100 bg-black transition"></span>
                            <span class="absolute left-[50%] translate-x-[-50%] bottom-0 w-full h-[2px] rounded-lg scale-x-0 group-hover:scale-x-100 bg-black transition"></span>


                            Login
                            <span class="absolute top-[50%] translate-y-[-50%] left-0 w-[2px] h-6 rounded-lg scale-y-100 group-hover:scale-y-0 bg-black transition"></span>
                            <span class="absolute top-[50%] translate-y-[-50%] right-0 w-[2px] h-6 rounded-lg scale-y-100 group-hover:scale-y-0 bg-black transition"></span>
                        </a>
                    </li>
                    <li>
                        <a class="block lg:text-lg p-2 relative group" href="/art_gallery/Pages/signup.php">
                            <span class="absolute left-[50%] translate-x-[-50%] top-0 w-full h-[2px] rounded-lg scale-x-0 group-hover:scale-x-100 bg-black transition"></span>
                            <span class="absolute left-[50%] translate-x-[-50%] bottom-0 w-full h-[2px] rounded-lg scale-x-0 group-hover:scale-x-100 bg-black transition"></span>
                            Signup
                            <span class="absolute top-[50%] translate-y-[-50%] left-0 w-[2px] h-6 rounded-lg scale-y-100 group-hover:scale-y-0 bg-black transition"></span>
                            <span class="absolute top-[50%] translate-y-[-50%] right-0 w-[2px] h-6 rounded-lg scale-y-100 group-hover:scale-y-0 bg-black transition"></span>
                        </a>
                    </li>
                </ul>
            </nav>
        <?php endif ?>
        <div class="flex-1 burger-menu">
            <div class="group h-4 cursor-pointer flex flex-col justify-between align-middle">
                <div class="w-8 h-[2px] ms-auto bg-black scale-x-[calc(4/4)] origin-right"></div>
                <div class="w-8 h-[2px] ms-auto bg-black scale-x-[calc(3/4)] origin-right group-hover:translate-x-[-25%] transition"></div>
                <div class="w-8 h-[2px] ms-auto bg-black scale-x-[calc(2/4)] origin-right group-hover:translate-x-[-50%] transition"></div>
            </div>
        </div>
        <div class="menu fixed overflow-x-hidden bg-secondary w-screen overflow-y-auto h-screen top-0 right-0 translate-x-[100%]">
            <div class="close-menu absolute top-5 right-5 p-4 cursor-pointer z-20">
                <div class="w-8 h-[1px] relative">
                    <div class="w-0 h-[1px]  bg-white absolute top-[50%] left-[50%] origin-center translate-x-[-50%] translate-y-[-50%] rotate-90"></div>
                    <div class="w-0 h-[1px]  bg-white absolute top-[50%] left-[50%] origin-center translate-x-[-50%] translate-y-[-50%] rotate-90"></div>
                </div>
            </div>
            <nav class="w-full h-full relative z-10 min-h-[500px] flex items-center justify-center">
                <ul class="text-white text-center text-xl capitalize flex flex-col gap-4 font-bold">
                    <li class="py-2"><a href="/art_gallery/Pages/products.php">
                            Products
                        </a></li>
                    <li class="py-2"><a href="/art_gallery/Pages/events.php">
                            events
                        </a></li>
                    <li class="py-2"><a href="/art_gallery/Pages/contact.php">
                            Contact Us
                        </a></li>
                    <li class="py-2"><a class="flex items-center text-xl" href="/art_gallery/Pages/cart.php">
                            <ion-icon class="me-2 text-3xl" name="cart-sharp"></ion-icon> cart [ <?= Cart::$count ?> ]
                        </a></li>

                    <?php if (!$isLoggedIn) : ?>
                        <li class="py-2 md:hidden"><a href="/art_gallery/Pages/signup.php">
                                Signup
                            </a></li>
                        <li class="py-2 md:hidden"><a href="/art_gallery/Pages/login.php">
                                Login
                            </a></li>
                    <?php else: ?>
                        <li class="py-2"><a href="/art_gallery/Pages/signout.php">
                            Signout
                        </a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </div>
    </div>
    </div>
</header>