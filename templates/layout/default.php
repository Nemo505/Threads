<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Cake';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'output']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- Add the following CSS for snowfall effect -->
    <style>
        body {
            overflow: hidden; /* Hide overflowing snowflakes */
        }

        snowflake {
            position: absolute;
            animation: fall linear infinite;
            transform-origin: 50% 50%;
            display: inline-block;
            font-size: 20px;
            color: #fff;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    </style>

    <!-- Add the following script for generating snowflakes -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Number of snowflakes
            var numSnowflakes = 10;

            // Function to create a snowflake element
            function createSnowflake() {
                var snowflake = document.createElement('snowflake');
                snowflake.innerHTML = '🍰'; // Unicode snowflake character
                snowflake.style.top = -20 + 'px'; // Set the initial position above the viewport
                snowflake.style.left = Math.random() * window.innerWidth + 'px';
                snowflake.style.animationDuration = (Math.random() * 9 + 1) + 's'; // Vary animation duration
                document.body.appendChild(snowflake);
            }

            // Create the specified number of snowflakes
            for (var i = 0; i < numSnowflakes; i++) {
                createSnowflake();
            }
        });
    </script>

    
</head>
    <body class=" bg-gradient-to-r from-yellow-500 via-green-500 to-yellow-500">

    <!-- Christmas decorations -->
     <div class="absolute top-0 right-0 h-full flex items-center justify-center pointer-events-none">
        <img src="https://i.pinimg.com/originals/f9/f9/d0/f9f9d087599c729d158bb4a68c75ae45.png" alt="Christmas Tree" class="h-full">
        <!-- Add more images or icons for decorations -->
    </div>

        <!-- Christmas navbar -->
    <nav class="bg-gradient-to-r from-red-500 via-green-700 to-red-500 p-4">
        <div class="container mx-auto flex justify-between items-center">

            <!-- Logo or brand -->
            <a href="#" class="text-white text-2xl font-semibold">
                <img src="https://img1.pnghut.com/12/11/16/3wQMsha9S4/christmas-tree-fir-santa-claus-s-reindeer-jingle-bell-gift.jpg" alt="Christmas Logo" class="h-8 mr-2 inline">
                Christmas ChatBot
            </a>
        </div>
    </nav>

    <main class="main mt-2">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
  
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
