<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
    <title><?= $this->e($title) ?></title>
</head>
<body>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" >
                <li class="cnav-item active">
                    <a class="nav-link" href="/diplom/user/register">Регистрация<span class="sr-only">(current)</span></a>
                </li>

                <?php if ($auth->isLoggedIn()) {
                    echo '<li class="nav-item active" >';
                    echo '<a class="nav-link" href = "/diplom/user/logout" > Выход<span class="sr-only" onclick = "return confirm("Уверены?")" > (current)</span ></a >';
                    echo '</li >';
                } else {
                    echo '<li class="nav-item active">';
                    echo '<a class="nav-link" href="/diplom/user/login">Вход<span class="sr-only">(current)</span></a>';
                    echo '</li>';
                }
                ?>
            </ul>
        </div>
        <a class="navbar-brand" href="/diplom/" align="right">На стартовую страницу</a>
    </nav>
    <br/>
    <?= $this->section('content') ?>
</div>

</body>
</html>