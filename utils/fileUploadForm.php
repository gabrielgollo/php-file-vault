<?php
    function generateFileUploadForm($folderId)
    {
        $fileUploadForm = '
        <form action="upload.php" method="POST" enctype="multipart/form-data" style="border:0px;" id="fileForm">
            <input type="hidden" name="folderId" value="' . $folderId . '">
            <div class="form-group">
                <input type="file" class="form-control form-control-lg" id="file" name="file" onchange="()=>{document.querySelector("#fileForm").submit()}">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>';
    
        return $fileUploadForm;
    }
?>