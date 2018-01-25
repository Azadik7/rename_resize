<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "alimekteb";

include('classSimpleImage.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$sql = "SELECT user_firstname, user_lastname, user_erizeN  FROM users_data";
$result = $conn->query($sql);

function translit($var) {
    if (preg_match( '/[^A-Za-z0-9_\-]/', $var )) {
    $tr = array( "А" => "a", "Б" => "b", "В" => "v", "Г" => "g", "Д" => "d", "Е" => "e", "Ж" => "j", "З" => "z", "И" => "i", "Й" => "y", "К" => "k", "Л" => "l", "М" => "m", "Н" => "n", "О" => "o", "П" => "p", "Р" => "r", "С" => "s", "Т" => "t", "У" => "u", "Ф" => "f", "Х" => "h", "Ц" => "ts", "Ч" => "ch", "Ш" => "sh", "Щ" => "sch", "Ъ" => "", "Ы" => "yi", "Ь" => "", "Э" => "e", "Ю" => "yu", "Я" => "ya", "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j", "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l", "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h", "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y", "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya", "ı" => "i", "I" => "i", "Ü" => "u", "ü" => "u", "Ə" => "E", "İ" => "i", "i" => "i", "Ö" => "o", "ö" => "o", "Ğ" => "g", "Ç" => "c", "ç" => "c", "Ş" => "s", "ş" => "s", "ğ" => "g", "&#601;" => "e", "&#214;" => "o", "&#231;" => "ch", "ə" => "e", " " => "-", "/" => "-", " - " => "-", "--" => "-", "&#305;" => "i", "&#199;" => "ch", "&#287;" => "g", "&#252;" => "u", "&#351;" => "sh", "&#246;" => "o", "." => "" );
    $var = strtr( trim( $var ), $tr );
            $var = strtolower( $var );
            $var = str_replace( '--', '-', $var );
            }
    $var = htmlspecialchars( trim( $var ) );
    return $var;
}

if ($result->num_rows > 0) {
    // output data of each row
    $i = 1;
    while($row = $result->fetch_assoc()) {
        $first_name = translit($row["user_firstname"]);
        $user_lastname = translit($row["user_lastname"]);
        $user_erizeN = $row["user_erizeN"];

        echo $user_erizeN. " - Name: " . $first_name . " " . $user_lastname. "\n";

        // file render
        $filename = __DIR__.('/photo/').$user_erizeN.'.jpg';
        $newName  = __DIR__.('/new/').$first_name.'_'.$user_lastname.'_'.$user_erizeN.'.jpg';

        if (file_exists($filename)) {
            echo "The file $filename exists \n";
            rename($filename, $newName);

            $image = new SimpleImage();
            $image->load($newName);
            $image->scale(80);
            $image->save($newName);
        } else {
            echo "The file $filename does not exist \n";
        }
        // file render
    }
} else {
    echo "0 results";
}
$conn->close();