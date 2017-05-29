<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Парсер zip каталога</title>
</head>

<body>

    <?php
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
        $file_zip_1 = $url_zip_1[1][0];
        $file_zip_2 = $url_zip_1[1][1];
        $file_zip_3 = $url_zip_1[1][2];
        $file_zip_4 = $url_zip_1[1][3];

        //Дирректория загрузки первого каталога
        $uploaddir_1 = 'D:\Work\OpenServer\domains\parser2\catalogs\01_';

        // Загрузка первого файла на сервер
        $uploadfile_1 = $uploaddir_1.basename($file_zip_1);
        // Копируем файл
        if (copy($file_zip_1, $uploadfile_1)){
            echo "Файл 1 успешно загружен на сервер<br>";
        }

        // Загрузка второго файла на сервер
        $uploadfile_1 = $uploaddir_1.basename($file_zip_2);
        // Копируем файл
        if (copy($file_zip_2, $uploadfile_1)){
            echo "Файл 2 успешно загружен на сервер<br>";
        }

        // Загрузка третьего файла на сервер
        $uploadfile_1 = $uploaddir_1.basename($file_zip_3);
        // Копируем файл
        if (copy($file_zip_3, $uploadfile_1)){
            echo "Файл 3 успешно загружен на сервер<br>";
        }

        // Загрузка четвертого файла на сервер
        $uploadfile_1 = $uploaddir_1.basename($file_zip_4);
        // Копируем файл
        if (copy($file_zip_4, $uploadfile_1)){
            echo "Файл 4 успешно загружен на сервер<br>";
        }

    ?>

</body>

</html>
