async function downloadFile(fileId, filename) {
    try {
        const response = await fetch(`download.php?fileId=${fileId}`, {
        method: "GET",
        mode: "cors",
        credentials: "include",
        referrerPolicy: "strict-origin-when-cross-origin"
        });

        if (!response.ok) {
        throw new Error("File download failed");
        }

        const blob = await response.blob();

        // Create a temporary anchor element
        const downloadLink = document.createElement("a");
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = filename;

        // Simulate a click on the anchor element to trigger the file download
        downloadLink.click();

        // Clean up the temporary URL object
        URL.revokeObjectURL(downloadLink.href);
        // Reload the page
        location.reload();
    } catch (error) {
        console.error("Error during file download:", error);
    }
}

function deleteFile(fileId) {
if (confirm('Are you sure you want to delete this file?')) {
    // Perform the deletion logic here
    // You can use AJAX to send a request to the server for deleting the file
    // For example:
    fetch('delete.php?fileId=' + fileId, {
        method: 'GET'
    })
    .then(response => {
        // Handle the response if needed
    })
    .catch(error => {
        console.log('An error occurred during file deletion:', error);
    });
}
//reload page
location.reload();
}