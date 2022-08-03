<?php

$layout = 'master';
$title = 'Сравнение текста';

?>

<form class="center" action="compare" method="POST">
    <label>Новый текст</label>
    <textarea  name="new" placeholder="Введите новый текст"></textarea>
    <label>Измененный текст</label>
    <textarea   name="changed" placeholder="Введите измененный текст"></textarea>

    <button class="button" type="submit">Сравнить</button>
</form>


