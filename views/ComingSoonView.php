<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <?php
    if(isset($meta) && myIsArray($meta))
    {
        ?>
        <title><?php echo $meta['title'];?></title>
        <meta name="description" content="<?php echo $meta['description'];?>" />

        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="<?php echo $meta['title'];?>">
        <meta itemprop="description" content="<?php echo $meta['description'];?>">
        <meta itemprop="image" content="<?php echo base_url().EVENT_PATH_THUMB.$meta['img'];?>">

        <!-- Twitter Card data -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@godoolally">
        <meta name="twitter:title" content="<?php echo $meta['title'];?>">
        <meta name="twitter:description" content="<?php echo $meta['description'];?>">
        <meta name="twitter:creator" content="@godoolally">
        <!-- Twitter summary card with large image must be at least 280x150px -->
        <meta name="twitter:image:src" content="<?php echo base_url().EVENT_PATH_THUMB.$meta['img'];?>">

        <!-- Open Graph data -->
        <meta property="og:title" content="<?php echo $meta['title'];?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo $meta['link'];?>" />
        <meta property="og:image" content="<?php echo base_url().EVENT_PATH_THUMB.$meta['img'];?>" />
        <meta property="og:description" content="<?php echo $meta['description'];?>" />
        <?php
    }
    else
    {
        ?>
        <title>Doolally</title>
        <?php
    }
    ?>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/temp/component-coming.css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans|Averia+Serif+Libre' rel='stylesheet' type='text/css'>
    <link rel="icon" sizes="76x76" href="<?php echo base_url();?>asset/images/doolally-app-icon.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url();?>asset/images/doolally-app-icon-apple.png"/>
    <style>
        .trigger-headline { color: burlywood;}
        .trigger-headline {
            font-family: 'Averia Serif Libre';
            top: 0;
            left: 0;
            position: absolute;
            font-size: 4em;
            text-transform: capitalize;
            pointer-events: none;
            line-height: 1;
            width: 100%;
            height: 100%;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-align-items: center;
            -ms-flex-align: center;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .trigger-headline span {
            display: inline-block;
            position: relative;
            padding: 0 5vw;
            -webkit-transition: opacity 2s, -webkit-transform 2s;
            transition: opacity 2s, transform 2s;
            -webkit-transition-timing-function: cubic-bezier(0.2,1,0.3,1);
            transition-timing-function: cubic-bezier(0.2,1,0.3,1);
            -webkit-transition-delay: 0.7s;
            transition-delay: 0.7s;
        }

        .js .trigger-headline--hidden span {
            pointer-events: none;
            opacity: 0;
        }

        .js .trigger-headline--hidden span:nth-child(1) {
            -webkit-transform: translate3d(-100px,0,0);
            transform: translate3d(-100px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(2) {
            -webkit-transform: translate3d(-50px,0,0);
            transform: translate3d(-50px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(3) {
            -webkit-transform: translate3d(-25px,0,0);
            transform: translate3d(-25px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(4) {
            -webkit-transform: translate3d(25px,0,0);
            transform: translate3d(25px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(5) {
            -webkit-transform: translate3d(50px,0,0);
            transform: translate3d(50px,0,0);
        }

        .js .trigger-headline--hidden span:nth-child(6) {
            -webkit-transform: translate3d(100px,0,0);
            transform: translate3d(100px,0,0);
        }
    </style>
</head>
<body>
<main>
	<!-- Initial markup -->
	<div class="segmenter" style="background-image: url(<?php echo base_url();?>asset/images/2.jpg)"></div>
	<h2 class="trigger-headline trigger-headline--hidden"><span>Desktop <label style="color:greenyellow">Version</label>
            <label style="color:crimson">Coming</label> Soon</span></h2>
</main>
<script src="<?php echo base_url(); ?>asset/js/temp/anime.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/temp/imagesloaded.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/temp/main-coming.js"></script>
<script>
	(function() {
		var headline = document.querySelector('.trigger-headline'),
			trigger = document.querySelector('.btn--trigger'),
			segmenter = new Segmenter(document.querySelector('.segmenter'), {
				pieces: 8,
				positions: [
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100},
					{top: 0, left: 0, width: 100, height: 100}
				],
				shadows: false,
				parallax: true,
				parallaxMovement: {min: 10, max: 30},
				animation: {
					duration: 2500,
					easing: 'easeOutExpo',
					delay: 0,
					opacity: .1,
					translateZ: {min: 10, max: 25}
				},
				onReady: function() {
					//trigger.classList.remove('btn--hidden');
                    segmenter.animate();
                    headline.classList.remove('trigger-headline--hidden');
					/*trigger.addEventListener('click', function() {
						segmenter.animate();
						headline.classList.remove('trigger-headline--hidden');
						this.classList.add('btn--hidden');
					});*/
				}
			});
	})();

</script>

</body>
</html>