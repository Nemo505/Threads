<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user,array('enctype'=>'multipart/form-data')) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('email');
                    echo $this->Form->control('password');
                    echo $this->Form->control('role');
                    echo $this->Form->control('avatar', [
                        'type' => 'file',
                        'style' => 'margin-bottom: 10px; width: 200px;'
                    ]);     


                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['style' => 'padding: 10px;']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
