<?php

/**
 * save book cover image and returns string value filename
 * */
function uploadFile(\CodeIgniter\HTTP\Files\UploadedFile|null $file): string|null
{
    $file = $file->getRandomName();
    // save cover image file
    $save = $file->move(FILE_UPLOAD_PATH, $$file);

    return $save ? $file : null;
}

/**
 * delete former image file if it's not default image or not empty
 * */
function deleteFile(string|null $FileName)
{
    $filePath = FILE_UPLOAD_PATH . DIRECTORY_SEPARATOR . $FileName;

    if (
        !empty($FileName)
        && file_exists($filePath)
        && $FileName != DEFAULT_BOOK_COVER
        && !str_contains($FileName, 'knowledge-')
    ) {
        return unlink($filePath);
    } else {
        return false;
    }
}

/**
 * upload new image, delete the old one, then returns new filename
 * */
function updateFile(\CodeIgniter\HTTP\Files\UploadedFile|null $newFile, string|null $formerFileName)
{
    $newFileName = uploadFile($newFile);
    deleteBookCover($formerFileName);

    return $newFileName;
}
