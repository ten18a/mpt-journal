<?php
$archiveUrl = 'https://github.com/ten18a/mpt-journal/archive/refs/heads/main.zip';
$zipFile = 'repo.zip';
$extractPath = './';

// Скачиваем архив
file_put_contents($zipFile, file_get_contents($archiveUrl));

// Создаем экземпляр ZipArchive
$zip = new ZipArchive;

// Открываем архив
if ($zip->open($zipFile) === TRUE) {
    // Перебираем все файлы и директории в архиве
    for ($i = 0; $i < $zip->numFiles; $i++) {
        $filename = $zip->getNameIndex($i);

        // Получаем относительный путь файла или директории
        $relativePath = substr($filename, strlen('mpt-journal-main/'));

        // Создаем директории при их отсутствии
        if (substr($filename, -1) === '/') {
            mkdir($extractPath . '/' . $relativePath, 0777, true);
        } else {
            // Извлекаем файл
            file_put_contents($extractPath . '/' . $relativePath, $zip->getFromIndex($i));
        }
    }

    // Закрываем архив
    $zip->close();

    // Удаляем загруженный архив
    unlink($zipFile);

    echo 'Обновление API завершено';
} else {
    echo 'Ошибка при открытии архива';
}
?>
