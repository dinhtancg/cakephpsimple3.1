<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
    </ul>
</nav>
<div class="users index large-9 medium-8 columns content">
  <div class="users form">
      <?= $this->Flash->render() ?>
      <?= $this->Form->create() ?>
          <fieldset>
              <legend><?= __('Login') ?></legend>
              <?= $this->Form->input('username') ?>
              <?= $this->Form->input('password') ?>
          </fieldset>
      <?= $this->Form->button(__('Login')); ?>
      <?= $this->Form->end() ?>
  </div>


</div>
