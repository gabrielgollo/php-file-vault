<?php
function listFilesInDirectory() {
    $filesInFolder = scandir('../uploads');
    $html = '<ul>';
    foreach ( $filesInFolder as $file ) {
        if ($file !== '.' && $file !== '..') {
            $html .= '<li><a href="../uploads/' . $file . '">' . $file . '</a></li>';
        }
    }
    $html .= '</ul>';
    return $html;
}
?>