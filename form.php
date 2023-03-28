<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'envoi d'image</title>
</head>
<body>
    <h1>Formulaire d'envoi d'image</h1>
    <?php
        if($_SERVER['REQUEST_METHOD'] === "POST"){ 
            $uploadDir = 'public/uploads/';
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg','gif','png', 'webp'];
            $maxFileSize = 1000000;
            $errors = [];

            // Vérification de l'extension
            if(!in_array($extension, $authorizedExtensions)){
                $errors[] = 'Veuillez sélectionner une image de type Jpg, Png, Gif ou Webp !';
            }

            // Vérification de la taille
            if(file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize){
                $errors[] = "Votre fichier doit faire moins de 1Mo !";
            }

            // Génération d'un nom de fichier unique
            $uniqueFileName = uniqid() . '_' . time() . '.' . $extension;
            $uploadFile = $uploadDir . $uniqueFileName;

            if(count($errors) === 0){
                if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadFile)){
                    echo "<p>L'image a été téléchargée avec succès.</p>";
                    echo "<img src='$uploadFile' alt='Image téléchargée' width='500'>";
                } else {
                    echo "Une erreur s'est produite lors du téléchargement du fichier.";
                }
            } else {
                foreach($errors as $error){
                    echo "<p>$error</p>";
                }
            }
        }
    ?>
    <form method="post" enctype="multipart/form-data">
        <label for="imageUpload">Upload an profile image</label>    
        <input type="file" name="avatar" id="imageUpload" />
        <button type="submit" name="send">Send</button>
    </form>
</body>
</html>
