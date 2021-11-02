<?php


?>
<div class="home-slider-wrapper">
    <div class="home-slider-nav home-slider-left" data-action="prev"><i class="las la-angle-left"></i></div>
    <div class="home-slider-nav home-slider-right" data-action="next"><i class="las la-angle-right"></i></div>
    <ul id="home-slider" class="owl-carousel owl-theme">
            <li style="background-image: url(<?= get_asset_path('images/slider', 'first_slide.jpeg') ?>);">
                <div class="container">
                    <div class="home-slider-desc">
                        <h2>Большой выбор <span>самокатов</span></h2>
                        <p><span>более 60 моделей</span> для разных возрастов</p>
                        <a href="#" class="btn btn-orange">выбрать</a>
                    </div>
                </div>
            </li>
    </ul>
</div>