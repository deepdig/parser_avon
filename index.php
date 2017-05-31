<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Парсер zip каталога сайта Avon</title>
</head>
<body>

    <?php
        set_time_limit(540);
        $custom_main = "zip_catalog/custom/main/";
        $custom_dop_1 = "zip_catalog/custom/dop_1/";
        $custom_dop_2 = "zip_catalog/custom/dop_2/";
        $custom_dop_3 = "zip_catalog/custom/dop_3/";
        $catalog_path = "zip_catalog/other/";

        // качаем основную страницу в переменную $buf
        $buf=implode("",file("https://promoavon.ru/catalogs/"));

        // получем ссылки на страницы с каталогами в массив
        preg_match_all("/[hH]1>[ \r\n\t]*<[Aa][ \r\n\t]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\n\r\t]*([^ \"'>\r\n\t#]+)[^>]*>/",$buf,$url);

        /////////////////////////////////////////////////////
        /////// Получаем архивы с первого каталога //////////
        /////////////////////////////////////////////////////
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

        //загрузка в текущий каталог custom-----------------------               
        // Копируем 1 файл в основной каталог
        $custom_main_file = $custom_main."/"."main.zip";
        if (copy($file_zip_1_1, $custom_main_file)){
            echo "Файл 1_1 успешно загружен в текущий каталог <br>";            
        }
        
        // Функция по извлечению файлов из архива без вложенных папок
        function zip_flatten ( $zipfile, $dest='.' ) 
        { 
            $zip = new ZipArchive; 
            if ( $zip->open( $zipfile ) ) 
            { 
                for ( $i=0; $i < $zip->numFiles; $i++ ) 
                { 
                    $entry = $zip->getNameIndex($i); 
                    if ( substr( $entry, -1 ) == '/' ) continue;
                    
                    $fp = $zip->getStream( $entry ); 
                    $ofp = fopen( $dest.'/'.basename($entry), 'w' ); 
                    
                    if ( ! $fp ) 
                        throw new Exception('Unable to extract the file.'); 
                    
                    while ( ! feof( $fp ) ) 
                        fwrite( $ofp, fread($fp, 8192) ); 
                    
                    fclose($fp); 
                    fclose($ofp); 
                } 

                        $zip->close();
            } 
            else 
                return false;            
            return $zip;
        } 
        //распаковываем архив 1_1
        if (zip_flatten( $custom_main_file, $custom_main )) {
            echo 'Архив 1_1 успешно разархивирован <br>';
        }
        else {
            echo 'Ошибка распаковки Архива 1_1 <br>';    
        }
       
        // Копируем 1_2 файл в дополнительный каталог
        $custom_dop_1_file = $custom_dop_1."/".basename($file_zip_1_2);
        if (copy($file_zip_1_2, $custom_dop_1_file)){
            echo "Файл 1_2 успешно загружен в текущий каталог <br>";
        }
        //распаковываем архив 1_2
        if (zip_flatten( $custom_dop_1_file, $custom_dop_1 )) {
            echo 'Архив 1_2 успешно разархивирован <br>';
        }
        else {
            echo 'Ошибка распаковки Архива 1_2 <br>';    
        }

        // Копируем 3 файл в дополнительный каталог
        $custom_dop_2_file = $custom_dop_2."/".basename($file_zip_1_3);
        if (copy($file_zip_1_3, $custom_dop_2_file)){
            echo "Файл 1_3 успешно загружен в текущий каталог <br>";
        }
        //распаковываем архив 1_3
        if (zip_flatten( $custom_dop_2_file, $custom_dop_2 )) {
            echo 'Архив 1_3 успешно разархивирован <br>';
        }
        else {
            echo 'Ошибка распаковки Архива 1_3 <br>';    
        }

        // Копируем 4 файл в дополнительный каталог
        $custom_dop_3_file = $custom_dop_3."/".basename($file_zip_1_4);
        if (copy($file_zip_1_4, $custom_dop_3_file)){
            echo "Файл 1_4 успешно загружен в текущий каталог <br>";
        }
        //распаковываем архив 1_4
        if (zip_flatten( $custom_dop_3_file, $custom_dop_3 )) {
            echo 'Архив 1_4 успешно разархивирован <br>';
        }
        else {
            echo 'Ошибка распаковки Архива 1_4 <br>';    
        }        

        //загрузка в дирректорию other-----------------------
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
            echo "Файл 1_1 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка второго файла на сервер
        $full_path_upload_1_2 = $full_path_upload_1_2."/".basename($file_zip_1_2);
        // Копируем файл
        if (copy($file_zip_1_2, $full_path_upload_1_2)){
            echo "Файл 1_2 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка третьего файла на сервер
        $full_path_upload_1_3 = $full_path_upload_1_3."/".basename($file_zip_1_3);
        // Копируем файл
        if (copy($file_zip_1_3, $full_path_upload_1_3)){
            echo "Файл 1_3 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка четвертого файла на сервер
        $full_path_upload_1_4 = $full_path_upload_1_4."/".basename($file_zip_1_4);
        // Копируем файл
        if (copy($file_zip_1_4, $full_path_upload_1_4)){
            echo "Файл 1_4 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        ////////////////////////////////////////////////////
        ////// Получаем архивы со второго каталога /////////
        ////////////////////////////////////////////////////
        $url_2=$url[1][1];

        // качаем вторую страницу каталога в переменную $catalog_2
        $catalog_2=implode("",file($url_2));

        // получем ссылки на архивы zip с каталогами в массив
        preg_match_all("/<[Aa][ \r\n\t]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\n\r\t]*([^ \"'>\r\n\t#]+[zZ][iI][pP])[^>]*>/",$catalog_2,$url_zip_2);

        //ссылки на файлы первого каталога
        $file_zip_2_1 = $url_zip_2[1][0];
        $file_zip_2_2 = $url_zip_2[1][1];
        $file_zip_2_3 = $url_zip_2[1][2];
        $file_zip_2_4 = $url_zip_2[1][3];        

        //загрузка в дирректорию other-----------------------
        //создаем дирректорию для загрузки первого каталога
        preg_match_all("/\d\d\d\d/", $file_zip_2_1, $catalog_2_dir_array);
        $catalog_2_dir = $catalog_2_dir_array[0][0];
        $uploaddir_2 = $catalog_path.$catalog_2_dir;
        mkdir($uploaddir_2, 0755);

        //создаем дирректории для загрузки файлов
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_2_1, $catalog_2_1_dir_array);
        $catalog_2_1_file_dir = $catalog_2_1_dir_array[0][0];
        $full_path_upload_2_1 = $uploaddir_2.$catalog_2_1_file_dir;
        mkdir($full_path_upload_2_1, 0755);
        
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_2_2, $catalog_2_2_dir_array);
        $catalog_2_2_file_dir = $catalog_2_2_dir_array[0][1];
        $full_path_upload_2_2 = $uploaddir_2.$catalog_2_2_file_dir;
        mkdir($full_path_upload_2_2, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_2_3, $catalog_2_3_dir_array);
        $catalog_2_3_file_dir = $catalog_2_3_dir_array[0][0];
        $full_path_upload_2_3 = $uploaddir_2.$catalog_2_3_file_dir;
        mkdir($full_path_upload_2_3, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_2_4, $catalog_2_4_dir_array);
        $catalog_2_4_file_dir = $catalog_2_4_dir_array[0][0];
        $full_path_upload_2_4 = $uploaddir_2.$catalog_2_4_file_dir;
        mkdir($full_path_upload_2_4, 0755);

        // Загрузка первого файла на сервер
        $full_path_upload_2_1 = $full_path_upload_2_1."/".basename($file_zip_2_1);
        // Копируем файл
        if (copy($file_zip_2_1, $full_path_upload_2_1)){
            echo "Файл 2_1 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка второго файла на сервер
        $full_path_upload_2_2 = $full_path_upload_2_2."/".basename($file_zip_2_2);
        // Копируем файл
        if (copy($file_zip_2_2, $full_path_upload_2_2)){
            echo "Файл 2_2 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка третьего файла на сервер
        $full_path_upload_2_3 = $full_path_upload_2_3."/".basename($file_zip_2_3);
        // Копируем файл
        if (copy($file_zip_2_3, $full_path_upload_2_3)){
            echo "Файл 2_3 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка четвертого файла на сервер
        $full_path_upload_2_4 = $full_path_upload_2_4."/".basename($file_zip_2_4);
        // Копируем файл
        if (copy($file_zip_2_4, $full_path_upload_2_4)){
            echo "Файл 2_4 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        ///////////////////////////////////////////////////
        /////// Получаем архивы с третьего каталога ///////
        ///////////////////////////////////////////////////
        $url_3=$url[1][2];

        // качаем третью страницу каталога в переменную $catalog_3
        $catalog_3=implode("",file($url_3));

        // получем ссылки на архивы zip с каталогами в массив
        preg_match_all("/<[Aa][ \r\n\t]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\n\r\t]*([^ \"'>\r\n\t#]+[zZ][iI][pP])[^>]*>/",$catalog_3,$url_zip_3);

        //ссылки на файлы первого каталога
        $file_zip_3_1 = $url_zip_3[1][0];
        $file_zip_3_2 = $url_zip_3[1][1];
        $file_zip_3_3 = $url_zip_3[1][2];
        $file_zip_3_4 = $url_zip_3[1][3];        

        //загрузка в дирректорию other-----------------------
        //создаем дирректорию для загрузки первого каталога
        preg_match_all("/\d\d\d\d/", $file_zip_3_1, $catalog_3_dir_array);
        $catalog_3_dir = $catalog_3_dir_array[0][0];
        $uploaddir_3 = $catalog_path.$catalog_3_dir;
        mkdir($uploaddir_3, 0755);

        //создаем дирректории для загрузки файлов
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_3_1, $catalog_3_1_dir_array);
        $catalog_3_1_file_dir = $catalog_3_1_dir_array[0][0];
        $full_path_upload_3_1 = $uploaddir_3.$catalog_3_1_file_dir;
        mkdir($full_path_upload_3_1, 0755);
        
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_3_2, $catalog_3_2_dir_array);
        $catalog_3_2_file_dir = $catalog_3_2_dir_array[0][1];
        $full_path_upload_3_2 = $uploaddir_3.$catalog_3_2_file_dir;
        mkdir($full_path_upload_3_2, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_3_3, $catalog_3_3_dir_array);
        $catalog_3_3_file_dir = $catalog_3_3_dir_array[0][0];
        $full_path_upload_3_3 = $uploaddir_3.$catalog_3_3_file_dir;
        mkdir($full_path_upload_3_3, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_3_4, $catalog_3_4_dir_array);
        $catalog_3_4_file_dir = $catalog_3_4_dir_array[0][0];
        $full_path_upload_3_4 = $uploaddir_3.$catalog_3_4_file_dir;
        mkdir($full_path_upload_3_4, 0755);

        // Загрузка первого файла на сервер
        $full_path_upload_3_1 = $full_path_upload_3_1."/".basename($file_zip_3_1);
        // Копируем файл
        if (copy($file_zip_3_1, $full_path_upload_3_1)){
            echo "Файл 3_1 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка второго файла на сервер
        $full_path_upload_3_2 = $full_path_upload_3_2."/".basename($file_zip_3_2);
        // Копируем файл
        if (copy($file_zip_3_2, $full_path_upload_3_2)){
            echo "Файл 3_2 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка третьего файла на сервер
        $full_path_upload_3_3 = $full_path_upload_3_3."/".basename($file_zip_3_3);
        // Копируем файл
        if (copy($file_zip_3_3, $full_path_upload_3_3)){
            echo "Файл 3_3 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        // Загрузка четвертого файла на сервер
        $full_path_upload_3_4 = $full_path_upload_3_4."/".basename($file_zip_3_4);
        // Копируем файл
        if (copy($file_zip_3_4, $full_path_upload_3_4)){
            echo "Файл 3_4 успешно загружен в каталог ".$catalog_path ."<br>";
        }

        ///////////////////////////////////////////////////
        ////// Получаем архивы с четвертого каталога //////
        ///////////////////////////////////////////////////
        $url_4=$url[1][3];

        // качаем четвертую страницу каталога в переменную $catalog_4
        $catalog_4=implode("",file($url_4));

        // получем ссылки на архивы zip с каталогами в массив
        preg_match_all("/<[Aa][ \r\n\t]{1}[^>]*[Hh][Rr][Ee][Ff][^=]*=[ '\"\n\r\t]*([^ \"'>\r\n\t#]+[zZ][iI][pP])[^>]*>/",$catalog_4,$url_zip_4);

        //ссылки на файлы первого каталога
        $file_zip_4_1 = $url_zip_4[1][0];
        $file_zip_4_2 = $url_zip_4[1][1];
        $file_zip_4_3 = $url_zip_4[1][2];
        $file_zip_4_4 = $url_zip_4[1][3];        

        //загрузка в дирректорию other-----------------------
        //создаем дирректорию для загрузки первого каталога
        preg_match_all("/\d\d\d\d/", $file_zip_4_1, $catalog_4_dir_array);
        $catalog_4_dir = $catalog_4_dir_array[0][0];
        $uploaddir_4 = $catalog_path.$catalog_4_dir;
        mkdir($uploaddir_4, 0755);

        //создаем дирректории для загрузки файлов
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_4_1, $catalog_4_1_dir_array);
        $catalog_4_1_file_dir = $catalog_4_1_dir_array[0][0];
        $full_path_upload_4_1 = $uploaddir_4.$catalog_4_1_file_dir;
        mkdir($full_path_upload_4_1, 0755);
        
        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_4_2, $catalog_4_2_dir_array);
        $catalog_4_2_file_dir = $catalog_4_2_dir_array[0][1];
        $full_path_upload_4_2 = $uploaddir_4.$catalog_4_2_file_dir;
        mkdir($full_path_upload_4_2, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_4_3, $catalog_4_3_dir_array);
        $catalog_4_3_file_dir = $catalog_4_3_dir_array[0][0];
        $full_path_upload_4_3 = $uploaddir_4.$catalog_4_3_file_dir;
        mkdir($full_path_upload_4_3, 0755);

        preg_match_all("/\/\w*\d\d\d\d/", $file_zip_4_4, $catalog_4_4_dir_array);
        $catalog_4_4_file_dir = $catalog_4_4_dir_array[0][0];
        $full_path_upload_4_4 = $uploaddir_4.$catalog_4_4_file_dir;
        mkdir($full_path_upload_4_4, 0755);

        // Загрузка первого файла на сервер
        $full_path_upload_4_1 = $full_path_upload_4_1."/".basename($file_zip_4_1);
        // Копируем файл
        if (copy($file_zip_4_1, $full_path_upload_4_1)){
            echo "Файл 4_1 успешно загружен в каталог ".$catalog_path ."<br>";
        }
        else {
            echo "Файл 4_1 отсутствует на сайте источнике <br>";   
        }

        // Загрузка второго файла на сервер
        $full_path_upload_4_2 = $full_path_upload_4_2."/".basename($file_zip_4_2);
        // Копируем файл
        if (copy($file_zip_4_2, $full_path_upload_4_2)){
            echo "Файл 4_2 успешно загружен в каталог ".$catalog_path ."<br>";
        }
        else {
            echo "Файл 4_2 отсутствует на сайте источнике <br>";   
        }

        // Загрузка третьего файла на сервер
        $full_path_upload_4_3 = $full_path_upload_4_3."/".basename($file_zip_4_3);
        // Копируем файл
        if (copy($file_zip_4_3, $full_path_upload_4_3)){
            echo "Файл 4_3 успешно загружен в каталог ".$catalog_path ."<br>";
        }
        else {
            echo "Файл 4_3 отсутствует на сайте источнике <br>";   
        }

        // Загрузка четвертого файла на сервер
        $full_path_upload_4_4 = $full_path_upload_4_4."/".basename($file_zip_4_4);
        // Копируем файл
        if (copy($file_zip_4_4, $full_path_upload_4_4)){
            echo "Файл 4_4 успешно загружен в каталог ".$catalog_path ."<br>";
        }
        else {
            echo "Файл 4_4 отсутствует на сайте источнике <br>";   
        }
    ?>

</body>
</html>
