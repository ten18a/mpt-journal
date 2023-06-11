<?php
$directory = dirname(__FILE__); // Абсолютный путь к директории
$excludeFiles = array(basename(__FILE__), '.htaccess'); // Имена файлов, которые необходимо исключить

// Получаем список всех файлов и подпапок в директории (рекурсивно)
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::CHILD_FIRST
);

// Перебираем файлы и удаляем их
foreach ($files as $file) {
    // Проверяем, что файл не является одним из исключаемых файлов
    if (!in_array($file->getFilename(), $excludeFiles)) {
        // Удаляем файл или папку
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
}

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
