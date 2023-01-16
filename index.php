<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Uplaod to ImageBB</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="record_image" accept="image/*">
        <button type="submit">Get Link</button>
    </form>
    <?php
    function save_record_image($image, $name = null)
    {
        $API_KEY = '......................';
        //Get Api Key From https://api.imgbb.com/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $file_name = ($name) ? $name . '.' . $extension : $image['name'];
        $data = array('image' => base64_encode(file_get_contents($image['tmp_name'])), 'name' => $file_name);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
        } else {
            return json_decode($result, true);
        }
        curl_close($ch);
    }
    if (!empty($_FILES['record_image'])) {
        $image_data = save_record_image($_FILES['record_image'], 'test');
        $image = $image_data['data'];
        echo 'Main Image : ' . $image['image']['url'];
        echo '<br>';
        echo 'thumb Image : ' . $image['thumb']['url'];
        echo '<br>';
        echo 'medium Image : ' . $image['medium']['url'];
        echo '<br>';
    }
    ?>
</body>

</html>