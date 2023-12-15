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

        // Fetch data from the Users model
        $postsData = $this->Posts->find('all');

        // Pass data to the view
        $this->set('posts', $postsData);
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

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $thread = $this->Threads->newEmptyEntity();
        if ($this->request->is('post')) {
            $thread = $this->Threads->patchEntity($thread, $this->request->getData());
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));
        }
        $this->set(compact('thread'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Thread id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $thread = $this->Threads->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $thread = $this->Threads->patchEntity($thread, $this->request->getData());
            if ($this->Threads->save($thread)) {
                $this->Flash->success(__('The thread has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The thread could not be saved. Please, try again.'));
        }
        $this->set(compact('thread'));
    }

   
}
