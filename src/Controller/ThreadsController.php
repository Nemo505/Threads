<?php
declare(strict_types=1);

namespace App\Controller;
/**
 * Threads Controller
 *
 * @method \App\Model\Entity\Thread[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ThreadsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // Load the Users model
        $this->loadModel('Posts');

        $posts = $this->Posts->find()
            ->contain(['Users'])
            ->order(['posts.created' => 'DESC']);
        
        $user = $this->Authentication->getIdentity();
        $userId = $user->get('id');

        $this->set(compact('posts', 'userId'));
    }

    /**
     * View method
     *
     * @param string|null $id Thread id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $thread = $this->Threads->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('thread'));
    }

    public function toggleLike() {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);
        
        $postId = $this->request->getData('postId');
        
        $user = $this->Authentication->getIdentity();
        $userId = $user->get('id');


        $this->loadModel('Likes');
        $isLiked = $this->Likes->find()
                        ->where(['post_id' => $postId, 'user_id' => $userId])
                        ->first();

        $like = $this->Likes->newEntity([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);

        if (!$isLiked) {
            $this->Likes->save($like);
        } else {
            // Find and delete the like based on the post and user
            $existingLike = $this->Likes->find()
                ->where(['post_id' => $postId, 'user_id' => $userId])
                ->first();

            if ($existingLike) {
                $this->Likes->delete($existingLike);
            }
        }
        
        $response =  $isLiked;
        echo json_encode($response);
    }

   
}
