<?php $this->layout('layout', ['title' => $results[0]['name'], 'category' => $category, 'auth'=>$auth]) ?>
<h4>Редактировать статью</h4>

<form action="" method="POST" enctype='multipart/form-data'>
  <div class="form-group">

          <label for="formGroupExampleInput">Название статьи</label>
          <input type="text" class="form-control" id="formGroupExampleInput" name="name" value="">
      </div>
      <div class="form-group">
          <label for="formGroupExampleInput2">Текст статьи</label>
          <textarea name="text" class="form-control" id="formGroupExampleInput2" name="description" value=""></textarea>
      </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>

</form>