<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <h3><?= __('Users') ?></h3>

    <a href="/download-csv" class="button float-left">Download CSV</a>

    <span class="mr-4 cursor-pointer button float-left"
            data-hs-overlay="#importModal">Import
    </span>

    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('avatar') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('role') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
                    <td><img src="<?= $this->Url->build('/') . h($user->avatar) ?>" alt="Avatar" width="70px"></td>
                    <td><?= h($user->name) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= h($user->role) ?></td>
                    <td><?= h($user->created) ?></td>
                    <td><?= h($user->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" 
    class="hs-overlay hidden w-full h-full 
           fixed top-0 start-0 z-[60] 
            
           overflow-y-auto">
  <div class="hs-overlay-open:mt-7 
              hs-overlay-open:opacity-100 
              hs-overlay-open:duration-500 
              mt-0 opacity-0 ease-out transition-all 
              sm:max-w-2xl sm:w-full 
              m-3 sm:mx-auto 
              h-[calc(100%-3.5rem)]">
    <div class="max-h-full overflow-hidden 
                flex flex-col bg-white 
                border shadow-sm rounded-xl 
                pointer-events-auto 
                dark:bg-gray-800 
                dark:border-gray-700 
                dark:shadow-slate-700/[.7]">
      <div class="flex justify-between items-center 
                  py-3 px-4 
                  border-b 
                  dark:border-gray-700">
        <h3 class="font-bold text-gray-800 dark:text-white">
         Import Data
        </h3>
        <button type="button" 
                class="flex justify-center 
                       items-center w-7 h-7 
                       text-sm font-semibold 
                       rounded-full border 
                       border-transparent 
                       text-gray-800 hover:bg-gray-100 
                       disabled:opacity-50 
                       disabled:pointer-events-none 
                       dark:text-white dark:hover:bg-gray-700 
                       dark:focus:outline-none 
                       dark:focus:ring-1 
                       dark:focus:ring-gray-600" 
                data-hs-overlay="#importModal">
            <span class="sr-only">Close</span>
            <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" 
                width="24" height="24" viewBox="0 0 24 24" 
                fill="none" stroke="currentColor" 
                stroke-width="2" stroke-linecap="round" 
                stroke-linejoin="round">
                <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
            </svg>
        </button>

      </div>
      <div class="p-4 overflow-y-auto">
        <div class="space-y-4">
          <!-- Form for importing data -->
            <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'import'], 'type' => 'file']) ?>
                <div class="bg-white p-6 rounded-lg shadow flex justify-between ">
                    <?= $this->Form->file('file', ['class' => 'form-control']) ?>
                    <a href="/path/to/sample/file.csv" 
                    class="bg-blue-500 hover:bg-blue-700 
                            text-white font-bold py-2 px-4 
                            rounded mr-2">Sample</a>
                </div>
                <div class=" flex justify-between items-center">
                    <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</a>
                    <?= $this->Form->button('Import', ['class' => 'bg-green-500 hover:bg-green-700 text-white font-bold mt-2 px-4 rounded button']) ?>
                </div>

            <?= $this->Form->end() ?>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- end model -->
