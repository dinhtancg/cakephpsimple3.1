<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Category'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="articles index large-9 medium-8 columns content">
    <h3> <?= __('Articles') ?></h3>
    <!-- <?= $this->Html->link('Add Article', ['action'=>'add']) ?> -->
    <table cellpadding="0" cellspaceing="0">
      <thead>
        <th><?= $this->Paginator->sort('id') ?></th>
        <th><?= $this->Paginator->sort('category_name ') ?></th>
        <th><?= $this->Paginator->sort('title') ?></th>
        <th><?= $this->Paginator->sort('created') ?></th>
        <th class="actions"><?= __('Actions') ?></th>
      </thead>
      <tr>

      </tr>
      <?php foreach ($articles as $article): ?>
      <tr>
        <td><?= $article->id ?></td>
          <td><?= $article->has('category_id') ? $this->Html->link($article->category->name, ['controller' => 'Categories', 'action' => 'view', $article->category->id]) : '' ?></td>
        <td><?= $this->Html->link($article->title, ['action'=>'view', $article->id ]) ?></td>
        <td>
          <?= $article->created->format(DATE_RFC850) ?>
        </td>
        <td>
          <?php if ($article->user_id == $this->request->session()->read('Auth.User.id') || $this->request->session()->read('Auth.User.role') ==='admin') {
    ?>
            <?= $this->Html->link('Edit', ['action'=>'edit', $article->id]) ?>
            <?= $this->Form->postLink('Delete',
              ['action'=>'delete', $article->id],
              ['confirm' => __('Are you sure you want to delete # {0}?', $article->id)])
             ?>
          <?php
} ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
