<!-- src/Template/Threads/index.ctp -->
<div class="container mx-auto my-8">
    <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($posts as $post): ?>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <!-- Author's Name -->
                <p class="text-sm text-gray-500 mb-2"><?= h("Nemo") ?></p>

                <!-- Hash Name -->
                <p class="text-sm text-gray-500 mb-2">@<?= h("Nemo") ?></p>
                
                <!-- Thread Title with Link -->
                <h2 class="text-xl font-semibold mb-4"><?= $this->Html->link($post->title, ['action' => 'view', $post->id], ['class' => 'text-blue-500']) ?></h2>

                <!-- Thread Body -->
                <p class="text-gray-600"><?= $this->Text->truncate($post->body, 100, ['ellipsis' => '...']) ?></p>

                <!-- Date and Time -->
                <p class="text-sm text-gray-500 mt-4"><?= h($post->created->format('F j, Y g:i a')) ?></p>

                <!-- Icons for Like, Share, Comment -->
                <div class="flex items-center mt-4">
                    <span class="mr-4">Like Icon</span>
                    <span class="mr-4">Share Icon</span>
                    <span>Comment Icon</span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


