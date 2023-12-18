<?php use Cake\ORM\TableRegistry; ?>

<div class="container mx-auto my-8">
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($posts as $post): ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                
                <!-- Author's Name -->
                <p class="text-sm text-gray-500 mb-2"><?= h($post->user->name) ?></p>

                <!-- Hash Name -->
                <p class="text-sm text-gray-500 mb-2">@<?= h($post->user->name) ?></p>
                
                <!-- Thread Title with Link -->
                <h2 class="text-xl font-semibold mb-4"><?= $this->Html->link($post->title, ['action' => 'view', $post->id], ['class' => 'text-blue-500']) ?></h2>

                <!-- Thread Body -->
                <p class="text-gray-600"><?= $this->Text->truncate($post->body, 100, ['ellipsis' => '...']) ?></p>

                <!-- Date and Time -->
                <p class="text-sm text-gray-500 mt-4"><?= h($post->created->format('F j, Y g:i a')) ?></p>

                <?php
                    $likesTable = TableRegistry::getTableLocator()->get('Likes');
                    $liked = $likesTable->find()
                        ->where(['post_id' => $post->id, 'user_id' => $userId])
                        ->first();
                    $liked !== null;
                ?>
                <!-- Icons for Like, Share, Comment -->
               <div class="flex items-center mt-4">
                    <span class="mr-4" onclick="toggleLike(this, <?= $post->id ?>)"><i class="fa-<?= $liked ? 'solid' : 'regular' ?> fa-thumbs-up"></i></span>
                    <span class="mr-4" onclick="toggleComment(this)"><i class="fa-regular fa-comment"></i></span>
                    <span class="mr-4" onclick="toggleShare(this)"><i class="fa-solid fa-share"></i></span>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>


<script>
    function toggleLike(element, postId) {
        var isLiked = <?= $liked ? 'true' : 'false' ?>;
        $.ajax({
            url: '/users/threads/like', 
            method: 'POST',
            data: { postId: postId },
            success: function(response) {
               if (response) {

                   // Change the icon based on the updated like status
                   if (isLiked == "false") {
                       element.innerHTML = '<i class="fa-solid fa-thumbs-up"></i>';
                   } else {
                       element.innerHTML = '<i class="fa-regular fa-thumbs-up"></i>';
                   }

                   isLiked != isLiked;
               }
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

    function toggleComment(element) {
        // Your logic for toggling comments and changing the icon
    }

    function toggleShare(element) {
        // Your logic for toggling shares and changing the icon
    }
</script>


