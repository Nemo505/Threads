<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Http\Exception\ForbiddenException;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 * @method \App\Model\Entity\Post[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PostsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $posts = $this->paginate($this->Posts);

        $this->set(compact('posts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        $post = $this->Posts->get($id, [
            'contain' => ['Users'],
        ]);

        try {
            $this->Authorization->authorize($post);
        } catch (ForbiddenException $exception) {
            $this->Flash->error('You are not authorized to perform this action.');
            return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
        }

        $this->set(compact('post'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEmptyEntity();

        $user = $this->Authentication->getIdentity();
        $this->loadModel('Users');
        $userinfo = $this->Users->get($user->id);
        if ($userinfo->role == 'user') {
            $this->Flash->error(__('User Role cannot add the Post'));
            return $this->redirect($this->referer());
            
        } else {
            
            if ($this->request->is('post')) {
                $post = $this->Posts->patchEntity($post, $this->request->getData());
                if ($this->Posts->save($post)) {
                    $this->Flash->success(__('The post has been saved.'));
    
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The post could not be saved. Please, try again.'));
            }
            $users = $this->Posts->Users->find('list', ['limit' => 200])->all();
            $this->set(compact('post', 'users'));
        }
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {   
        $post = $this->Posts->get($id, [
            'contain' => [],
        ]);
        
        try {
            $this->Authorization->authorize($post);
        } catch (ForbiddenException $exception) {
            $this->Flash->error('You are not authorized to perform this action.');
            return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
        }
        $users = $this->Posts->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('post', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $post = $this->Posts->get($id);

        try {
        $this->Authorization->authorize($post);
        } catch (ForbiddenException $exception) {
            $this->Flash->error('You are not authorized to perform this action.');
            return $this->redirect(['controller' => 'Posts', 'action' => 'index']);
        }

        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
