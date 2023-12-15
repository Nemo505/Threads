
<div class="flex items-center justify-center h-screen">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Please enter your Email and password') ?></legend>
            <?= $this->Form->control('email') ?>
            <?= $this->Form->control('password') ?>
        </fieldset>
        <?= $this->Form->button(__('Login'), ['class' => 'bg-gradient-to-r from-red-500 to-red-300 text-white font-bold mt-3 py-2 px-4 rounded']); ?>
        <?= $this->Form->end() ?>
    </div>
</div>
