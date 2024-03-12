<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function login()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {

            //update active status
            $userId = $result->getData()->id;
            $activeUsersTable = $this->getTableLocator()->get('ActiveUsers');

            $activeUser = $activeUsersTable->find()
                        ->where(['user_id' => $userId])
                        ->first();
            if ($activeUser) {
                $activeUser->status = 'active';
                $activeUsersTable->save($activeUser);
            }

            $target = $this->Authentication->getLoginRedirect() ?? '/';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid email or password');
        }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $userId = $this->Authentication->getIdentity()->id;
        $activeUsersTable = $this->getTableLocator()->get('ActiveUsers');

        $activeUser = $activeUsersTable->find()
            ->where(['user_id' => $userId])
            ->first();
        if ($activeUser) {
            $activeUser->status = 'inactive';
            $activeUsersTable->save($activeUser);
        }

        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->get($id, [
            'contain' => ['Posts', 'Likes', 'Comments'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());


            $uploadedFile = $this->request->getData('avatar');
            if ($uploadedFile) {
                $avatarName = uniqid() . '_' . $uploadedFile->getClientFilename();
                $uploadedFile->moveTo(WWW_ROOT . 'img/avatar/' . $avatarName);
                $user->avatar = 'img/avatar/' . $avatarName;
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $uploadedFile = $this->request->getData('avatar');
            if ($uploadedFile) {
                $avatarName = uniqid() . '_' . $uploadedFile->getClientFilename();
                $uploadedFile->moveTo(WWW_ROOT . 'img/avatar/' . $avatarName);
                $user->avatar = 'img/avatar/' . $avatarName;
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->Authorization->skipAuthorization();
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    
    public function downloadCSVReport()
    {
        $this->Authorization->skipAuthorization();
        $this->autoRender = false;

        $users = $this->Users->find()->toList();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=users-' . date("Y-m-d-h-i-s") . '.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, array('Id', 'Name', 'Email'));

        if (count($users) > 0) {
            foreach ($users as $user) {
                $user_row = [
                    $user['id'],
                    ucfirst($user['name']),
                    $user['email'],
                ];

                fputcsv($output, $user_row);
            }
        }
    }
}
