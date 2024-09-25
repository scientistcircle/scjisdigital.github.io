<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pengaturan Imam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        input[type="file"], input[type="text"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pengaturan Imam</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label>Upload CSV Nama Imam:</label>
        <input type="file" name="imam_csv">
        
        <label>Upload Logo:</label>
        <input type="file" name="logo">

        <label>Upload Background:</label>
        <input type="file" name="background">

        <label>Update Running Text:</label>
        <input type="text" name="running_text">

        <input type="submit" value="Update">
    </form>
</div>

</body>
</html>
