<?php
    function generateFileUploadForm($folderId)
    {
        $fileUploadForm = '
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="folderId" value="' . $folderId . '">
            <div class="form-group">
                <label for="file">Select File</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>';
    
        return $fileUploadForm;
    }
?>