<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Парсер zip каталога</title>
</head>

<body>

    <?php

        $catalog_path = "catalogs/";

        // качаем основную страницу в переменную $buf
        $buf=implode("",file("https://promoavon.ru/catalogs/"));

        // получем ссылки на страницы с каталогами в массив
        preg_match_all("/[hH]1>[ \r\n\t]*<[Aa][ \r\n\t]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\n\r\t]*([^ \"'>\r\n\t#]+)[^>]*>/",$buf,$url);

          ///////////////////////////////////////////////////
         ///////Получаем архивы с первого каталога//////////
        ///////////////////////////////////////////////////
        $url_1=$url[1][0];

        // качаем первую страницу каталога в переменную $catalog_1
        $catalog_1=implode("",file($url_1));

        // получем ссылки на архивы zip с каталогами в массив
        preg_match_all("/<[Aa][ \r\n\t]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\n\r\t]*([^ \"'>\r\n\t#]+[zZ][iI][pP])[^>]*>/",$catalog_1,$url_zip_1);

        //ссылки на файлы первого каталога
        $file_zip_1_1 = $url_zip_1[1][0];
        $file_zip_1_2 = $url_zip_1[1][1];
        $file_zip_1_3 = $url_zip_1[1][2];
        $file_zip_1_4 = $url_zip_1[1][3];

        //создаем дирректорию для загрузки первого каталога
        preg_match_all("/\d\d\d\d/", $file_zip_1_1, $catalog_1_dir_array);
        $catalog_1_dir = $catalog_1_dir_array[0][0];
        $uploaddir_1 = $catalog_path.$catalog_1_dir;
        mkdir($uploaddir_1, 0755);

        //создаем дирректории для загрузки файлов
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_1_1, $catalog_1_1_dir_array);
        $catalog_1_1_file_dir = $catalog_1_1_dir_array[0][0];
        $full_path_upload_1_1 = $uploaddir_1.$catalog_1_1_file_dir;
        mkdir($full_path_upload_1_1, 0755);
        
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_1_2, $catalog_1_2_dir_array);
        $catalog_1_2_file_dir = $catalog_1_2_dir_array[0][1];
        $full_path_upload_1_2 = $uploaddir_1.$catalog_1_2_file_dir;
        mkdir($full_path_upload_1_2, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_1_3, $catalog_1_3_dir_array);
        $catalog_1_3_file_dir = $catalog_1_3_dir_array[0][0];
        $full_path_upload_1_3 = $uploaddir_1.$catalog_1_3_file_dir;
        mkdir($full_path_upload_1_3, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_1_4, $catalog_1_4_dir_array);
        $catalog_1_4_file_dir = $catalog_1_4_dir_array[0][0];
        $full_path_upload_1_4 = $uploaddir_1.$catalog_1_4_file_dir;
        mkdir($full_path_upload_1_4, 0755);

        // Загрузка первого файла на сервер
        $full_path_upload_1_1 = $full_path_upload_1_1."/".basename($file_zip_1_1);
        // Копируем файл
        if (copy($file_zip_1_1, $full_path_upload_1_1)){
            echo "Каталог 1_1 успешно загружен на сервер<br>";
        }

        // Загрузка второго файла на сервер
        $full_path_upload_1_2 = $full_path_upload_1_2."/".basename($file_zip_1_2);
        // Копируем файл
        if (copy($file_zip_1_2, $full_path_upload_1_2)){
            echo "Каталог 1_2 успешно загружен на сервер<br>";
        }

        // Загрузка третьего файла на сервер
        $full_path_upload_1_3 = $full_path_upload_1_3."/".basename($file_zip_1_3);
        // Копируем файл
        if (copy($file_zip_1_3, $full_path_upload_1_3)){
            echo "Каталог 1_3 успешно загружен на сервер<br>";
        }

        // Загрузка четвертого файла на сервер
        $full_path_upload_1_4 = $full_path_upload_1_4."/".basename($file_zip_1_4);
        // Копируем файл
        if (copy($file_zip_1_4, $full_path_upload_1_4)){
            echo "Каталог 1_4 успешно загружен на сервер<br>";
        }
    ?>

</body>

</html>
