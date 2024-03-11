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
                    <span class="mr-4 cursor-pointer" onclick="toggleLike(this, <?= $post->id ?>)"><i class="fa-<?= $liked ? 'solid' : 'regular' ?> fa-thumbs-up"></i></span>
                    <span class="mr-4 cursor-pointer"
                          data-hs-overlay="#hs-scroll-inside-body-modal"
                          data-comment-title="<?= h($post->title) ?>"
                          data-comment-name="<?= h($post->user->name) ?>"
                          data-comment-content="<?= h($post->body) ?>"
                          onclick="toggleComment(this, <?= $post->id ?>)">
                        <i class="fa-regular fa-comment"></i>
                    </span>
                    <span class="mr-4 cursor-pointer" onclick="toggleShare(this)"><i class="fa-solid fa-share"></i></span>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="hs-scroll-inside-body-modal" class="hs-overlay hidden w-full h-full fixed top-0 start-0 z-[60] overflow-x-hidden overflow-y-auto">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto h-[calc(100%-3.5rem)]">
    <div class="max-h-full overflow-hidden flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
        <h3 class="font-bold text-gray-800 dark:text-white">
         Thread
        </h3>
        <button type="button" class="flex justify-center items-center w-7 h-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#hs-scroll-inside-body-modal">
          <span class="sr-only">Close</span>
          <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </button>
      </div>
      <div class="p-4 overflow-y-auto">
        <div class="space-y-4">
          
            <div class="bg-white p-6 rounded-lg shadow-md">
                
                <!-- Author's Name -->
                <p class="text-sm text-gray-500 mb-2" id="comment-modal-name"></p>

                <!-- Hash Name -->
                <p class="text-sm text-gray-500 mb-2" id="comment-modal-name"></p>
                
                <!-- Thread Title with Link -->
                <h2 class="text-xl font-semibold mb-4" id="comment-modal-title"></h2>

                <!-- Thread Body -->
                <p class="text-gray-600" id="comment-modal-content"></p>
               
                <!-- Icons for Like, Share, Comment -->
               <div class="flex items-center mt-4 border-t border-b py-2 dark:border-gray-700">
                    <span class="mr-4 cursor-pointer" onclick="toggleLike(this, <?= $post->id ?>)"><i class="fa-solid fa-thumbs-up"></i></span>
                    <span class="mr-4 cursor-pointer"><i class="fa-regular fa-comment"></i></span>
                    <span class="mr-4 cursor-pointer" onclick="toggleShare(this)"><i class="fa-solid fa-share"></i></span>
                </div>
                <!-- Comments Section -->
                <div id="comments-container">

                  
                </div>

                <form id="commentForm" >
                  <input type="hidden" name="post_id" id="comment-modal-id">
                  <div class="p-4 border-t dark:border-gray-700 flex items-center ">
                      <input type="text" placeholder="Type your message..." name="comment" class="flex-1 py-2 px-3 rounded-md focus:outline-none focus:shadow-outline-red text-normal" />
                      <button class="ml-2 bg-gradient-to-r from-red-500 to-red-300 hover:bg-[#fb7185] text-white py-2 px-4 rounded-md" id="saveComment">Send</button>  
                  </div>
                </form>

            </div>


        </div>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $("#saveComment").on("click", function(event) {
            event.preventDefault(); // Prevent the default form submission behavior
            var formData = $("#commentForm").serialize();
            $.ajax({
                method: 'POST',
                url: '/users/threads/comment',
                data: formData,
                success: function(response) {
                    if (response) {
                        console.log("Post saved successfully!");
                    } else {
                        alert("Error saving post!");
                    }
                },
                error: function() {
                    alert("AJAX request failed!");
                }
            });
        });
    });
</script>


<script>
    function toggleComment(element, postId) {
        // Retrieve data attributes from the clicked element
        var title = element.dataset.commentTitle;
        var name = element.dataset.commentName;
        var content = element.dataset.commentContent;

        // Update the modal content dynamically
        document.getElementById('comment-modal-title').innerText = title;
        document.getElementById('comment-modal-name').innerText = name;
        document.getElementById('comment-modal-content').innerText = content;
        document.getElementById('comment-modal-id').value = postId;

        // Load comments dynamically using AJAX
        $.ajax({
            url: '/users/threads/get-comments', // Replace with your actual endpoint
            method: 'GET',
            data: { postId: postId },
            cache: false,
            success: function(response) {
                if (response.length > 0) {
                    var commentsArray = JSON.parse(response);
                    console.log(response);

                    // Clear existing comments
                    var commentsContainer = document.getElementById('comments-container');
                    commentsContainer.innerHTML = '';

                    // Loop through comments and append them to the container
                    commentsArray.forEach(function(comment) {
                        var commentHtml = `
                            <div class="bg-dark-100 text-white py-4 px-6">
                                <div class="flex items-center">
                                    <img src="${window.location.origin}/${comment.avatar}" alt="${comment.user_name} Avatar" class="h-10 w-10 rounded-full mr-3 border-2 border-white" />
                                    <h6 class="text-lg font-semibold text-black">@${comment.user_name}</h6>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 " style="font-size: small; margin-left: 30px; margin-top: 10px;">${comment.content}</p>
                                <div class="flex items-center">
                                    <div class="cursor-pointer" onclick="toggleLike(this, ${comment.id})">
                                        <i class="fa-solid fa-thumbs-up text-blue-500"></i> Like
                                    </div>
                                    <div class="cursor-pointer">
                                        <i class="fa-regular fa-comment text-gray-500"></i> Reply
                                    </div>
                                </div>
                            </div>
                        `;
                        commentsContainer.innerHTML += commentHtml;
                    });
                }
            },
            error: function(error) {
                console.error(error);
            }
        });

    }
</script>

<script>
    function toggleLike(element, postId) {
        var icon = element.firstChild;
        
        $.ajax({
            url: '/users/threads/like', 
            method: 'POST',
            data: { postId: postId },
            cache: false,
            success: function(response) {
               if (response) {
                    var isSolid = icon.classList.contains('fa-solid');

                    // Update the icon based on the response
                    if (response === "null") {
                        if (isSolid) {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                        } else {
                            icon.classList.add('fa-solid');
                            icon.classList.remove('fa-regular');
                        }
                    } else {

                        if (isSolid) {
                            icon.classList.add('fa-solid');
                            icon.classList.remove('fa-regular');
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                        }
                    }
                   
               }
            },
            error: function(error) {
                console.error(error);
            }
        });
    }

</script>


