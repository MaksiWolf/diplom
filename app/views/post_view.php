<?php $this->layout('layout', ['title' => $results[0]['name'], 'category' => $category, 'auth'=>$auth]) ?>
<h4>Читать статью</h4>

<?d($result) ?>

<?php
echo $result['name'];
echo '<br/>'.'<br/>';
echo $result['text'];
?>

