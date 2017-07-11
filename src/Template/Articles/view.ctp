<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Parent Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>


    </ul>
</nav>
<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create($article) ?>
    <fieldset>
        <legend><?= __(' Article Information') ?></legend>
        <h1> <?= h($article->title) ?></h1>
        <h3><?= h($article->body)?></h3>
        <h5>

              Category : <?= h($article->category->name) ?>
              <br>
              Created: <?= h($article->created->format(DATE_RFC850)) ?>

        </h5>
        <?php if ($article->user_id == $this->request->session()->read('Auth.User.id') || $this->request->session()->read('Auth.User.role') ==='admin') {
    ?>
        <?= $this->Html->link('Edit Article', ['action'=>'edit', $article->id]) ?>
        <?php
} ?>
    </fieldset>


</div>
