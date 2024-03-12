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

use Cake\I18n\FrozenTime;

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

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'output', 'fontawesome.min']) ?>
    <?= $this->Html->script('all.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <!-- Add the following CSS for snowfall effect -->
    <style>
        body {
            overflow: hidden;
            /* Hide overflowing snowflakes */
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../node_modules/preline/dist/preline.js"></script>
    <!-- Add the following script for generating snowflakes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

    <nav id="navbar" class="bg-gradient-to-r from-red-500 via-green-700 to-red-500 p-4 transition-all">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo or brand -->
            <a href="#" class="text-white text-2xl font-semibold flex items-center">
                <img src="https://img1.pnghut.com/12/11/16/3wQMsha9S4/christmas-tree-fir-santa-claus-s-reindeer-jingle-bell-gift.jpg" alt="Christmas Logo" class="h-8 mr-2 inline">
                Christmas ChatBot
            </a>

            <div class="flex">
                <button id="sidebarToggle" class="text-white float-right focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>

                <!-- Logout button -->
                <form action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" method="post">
                    <?= $this->Form->button(__('Logout'), ['type' => 'submit', 'class' => 'px-2 text-white hover:text-gray-300']); ?>
                </form>
            </div>
        </div>
    </nav>

    <aside id="sidebar" class="sidebar hidden bg-gray-100 text-white w-1/4 h-screen fixed top-0 right-0 overflow-y-auto transition-all">
        <!-- Panel content -->
        <div class="flex-1 p-4 space-y-8 overflow-y-hidden hover:overflow-y-auto">
            <!-- content -->
            <div class="flex flex-col items-center space-y-2">
                <!-- User avatar -->
                <img class="w-20 h-20 rounded-full dark:opacity-70" src="<?= $this->Url->build('/') . h($user->avatar) ?>" alt="Ahmed Kamel" />
                <h2 class="text-xl font-medium text-gray-600 dark:text-light"><?= h($user->name) ?></h2>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-normal text-gray-600 dark:text-light">Active People</h3>
                    <a href="#" class="text-blue-500 hover:underline">View all</a>
                </div>

                <?php foreach ($activeUsers as $user) : ?>
                    <?php
                    // echo ($user->_matchingData['ActiveUsers']['modified']);
                    $frozenTime = new FrozenTime($user->_matchingData['ActiveUsers']['modified']);
                    $modifiedAgo = $frozenTime->timeAgoInWords();
                    ?>
                    <div class="flex items-center justify-between">
                        <a href="#" class="flex space-x-2 group items-center">
                            <img class="flex-shrink-0 object-cover w-12 h-12 rounded-full" src="<?= $this->Url->build('/') . h($user->avatar) ?>" alt="<?php echo h($user->username); ?>" />
                            <div class="overflow-hidden">
                                <p class="font-semibold text-gray-400 transition-colors dark:text-indigo-700 group-hover:text-gray-900 dark:group-hover:text-indigo-400">
                                    <?= h($user->name) ?>
                                </p>
                            </div>
                        </a>
                        <div class="flex items-center">
                            <?php if ($user->_matchingData['ActiveUsers']['status'] == 'active') : ?>
                                <span class="bg-green-500 w-3 h-3 rounded-full inline-block ml-1"></span>
                            <?php else : ?>
                                <span class="text-xs text-gray-500 whitespace-nowrap dark:text-indigo-500">
                                    <?= h($modifiedAgo) ?> ago
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-normal text-gray-600 dark:text-light">Popular Thread</h3>
                </div>
                <div class="flex items-center justify-between">
                    <a href="#" class="flex space-x-2 group items-center">
                        <img class="flex-shrink-0 object-cover w-12 h-12 rounded-full" src="https://photoscissors.com/images/samples/1-before.jpg" alt="" />
                        <div class="overflow-hidden">
                            <p class="font-semibold text-gray-400 transition-colors dark:text-indigo-700 group-hover:text-gray-900 dark:group-hover:text-indigo-400">
                                highlight_filename
                            </p>
                            <p class="text-sm font-semibold text-gray-400 transition-colors 
                                        dark:text-indigo-700 
                                        group-hover:text-gray-900 
                                        dark:group-hover:text-indigo-400">
                                user name
                                <span class="font-light">: how are you</span>
                            </p>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </aside>


    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            var navbar = document.getElementById('navbar');
            document.getElementById('sidebar').classList.toggle('hidden');
            navbar.classList.toggle('w-full');
            navbar.classList.toggle('w-3/4');

            if (navbar.classList.contains('w-full')) {
                navbar.classList.remove('w-full');
            }
        });
    </script>

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