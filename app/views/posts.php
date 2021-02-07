<?php $this->layout('layout', ['title' => 'Статьи', 'category' => $category, 'auth' => $auth]) ?>
<h3>Статьи</h3>

<?php
echo '<a href="/diplom/post/insert" class="btn btn-primary">Добавить статью </a> ';

foreach ($results as $result) {

    echo '<p class="text">' . $result['name'] . '</p>';
    if ($auth->isLoggedIn()) {
        echo '<a href="/diplom/post/viev/' . $result['id'] . '" class="btn btn-primary">Прочитать</a> ';

        echo '<a href="/diplom/post/edit/' . $result['id'] . '" class="btn btn-primary">Редактировать</a> ';
        echo '<a href="/diplom/post/delete/' . $result['id'] . '" class="btn btn-primary">Удалить</a> ';
    }

} ?>

