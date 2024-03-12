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
        $this->Authorization->skipAuthorization();
        // Load the Users model
        $usersTable = $this->getTableLocator()->get('Users');
        $activeUsersTable = $this->getTableLocator()->get('ActiveUsers');

        //active users along with their status from the Users table
        $activeUsers = $usersTable->find()
        ->innerJoinWith('ActiveUsers', function ($query) {
            return $query->where(['ActiveUsers.user_id = Users.id']);
        })
            ->select(['Users.name', 'Users.avatar', 'ActiveUsers.status', 'ActiveUsers.modified'])
            ->all();

        $postsTable = $this->getTableLocator()->get('Posts');
        $posts = $postsTable->find()
            ->contain(['Users'])
            ->order(['posts.created' => 'DESC']);
        
        $user = $this->Authentication->getIdentity();
        $userId = $user->get('id');

        $this->set(compact('posts', 'userId', 'user', 'activeUsers'));
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
        $this->Authorization->skipAuthorization();

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

    public function toggleComment()
    {
        $this->Authorization->skipAuthorization();
        $this->autoRender = false; 
        $this->request->allowMethod(['post']);
        $postId = $this->request->getData('post_id');
        $comment = $this->request->getData('comment');
    
        $user = $this->Authentication->getIdentity();
        $userId = $user->get('id');


        $this->loadModel('Comments');

        $comment = $this->Comments->newEntity([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $comment,
        ]);
        $this->Comments->save($comment);
        echo json_encode($comment);
       
    }

    public function getComment()
    {   
        $this->Authorization->skipAuthorization();
        $this->autoRender = false; 
        $this->request->allowMethod(['get']);
        $postId = $this->request->getQuery('postId');

        $this->loadModel('Comments');

        $comments = $this->Comments->find( 'all', [
            'conditions' => ['post_id' => $postId],
            'contain' => ['Users'],
        ]);

        $commentsArray = $comments->toArray();

        $result = [];

        foreach ($commentsArray as $comment) {
            $result[] = [
                'id' => $comment->id,
                'avatar' => $comment->user->avatar,
                'content' => $comment->content,
                'user_id' => $comment->user_id,
                'user_name' => $comment->user->name, 
            ];
        }
        echo json_encode($result);
    }

   
}
