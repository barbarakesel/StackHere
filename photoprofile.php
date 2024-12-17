<?php
$uploadfile = basename($_FILES['file']['name']);

if (move_uploaded_file($_FILES['file']['tmp_name'], './' . $uploadfile)) {
    echo "Файл успешно загружен.\n";
}