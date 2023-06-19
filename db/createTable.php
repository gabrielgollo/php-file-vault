
<?php
include('../configs/banco.php');

try {
    $conn = Banco::conectar();

    $createFolderTable = 'CREATE TABLE IF NOT EXISTS FOLDER (
        folderId INT AUTO_INCREMENT PRIMARY KEY,
        folderName VARCHAR(255) DEFAULT "root" NOT NULL,
        parentFolderId INT,
        FOREIGN KEY (parentFolderId) REFERENCES FOLDER(folderId)
    )';
    $stmt2 = $conn->prepare($createFolderTable);
    $stmt2->execute();
    echo "Tables FOLDER created successfully.<br>";
    
    $createUserTable  = 'CREATE TABLE IF NOT EXISTS USER (
        userId INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        rootFolderId INT NOT NULL,
        FOREIGN KEY (rootFolderId) REFERENCES FOLDER(folderId)
    )';
    $stmt1 = $conn->prepare($createUserTable);
    $stmt1->execute();
    echo "Tables USER created successfully.<br>";
    
    $createFileTable='CREATE TABLE IF NOT EXISTS FILE (
        fileId VARCHAR(255) PRIMARY KEY,
        fileName VARCHAR(255) NOT NULL,
        mimeType VARCHAR(255) NOT NULL,
        createdAt TIMESTAMP NOT NULL,
        checkSum VARCHAR(255) NOT NULL,
        folderId INT NOT NULL,
        FOREIGN KEY (folderId) REFERENCES FOLDER(folderId)
    )';

    $stmt3 = $conn->prepare($createFileTable);
    $stmt3->execute();
    echo "Tables FILE created successfully.<br>";

    // SHOW TABLES
    $query = "SHOW TABLES";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($tables)) {
        echo "Tables in the database:<br>";
        foreach ($tables as $table) {
            echo $table . "<br>";
        }
    } else {
        echo "No tables found in the database.";
    }

    Banco::desconectar();
} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}

?>