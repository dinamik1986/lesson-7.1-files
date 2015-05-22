

<?php

header('Content-type: text/html; charset=utf-8');
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1);

//POST

$news='Четыре новосибирские компании вошли в сотню лучших работодателей
Выставка университетов США: открой новые горизонты
Оценку «неудовлетворительно» по качеству получает каждая 5-я квартира в новостройке
Студент-изобретатель раскрыл запутанное преступление
Хоккей: «Сибирь» выстояла против «Ак Барса» в пятом матче плей-офф
Здоровое питание: вегетарианская кулинария
День святого Патрика: угощения, пивной теннис и уличные гуляния с огнем
«Красный факел» пустит публику на ночные экскурсии за кулисы и по закоулкам столетнего здания
Звезды телешоу «Голос» Наргиз Закирова и Гела Гуралиа споют в «Маяковском»';
$news=  explode("\n", $news);



function vivod($news) {


   $id = isset($_POST['id']) ? strtolower($_POST['id']): 'azaza_error)';





    if (is_numeric($id)) {

        if ($id >= 0 && $id <= count($news)-1) {
            echo $news[$id];
        } else {
            vivod_all($news);
        }

    } else {
     header("HTTP/1.1 404 Not Found");    
     header("Status: 404 Not Found");
     echo "Ошибка 404, введите корректный ID";
    }
}

// Функция вывода всего списка новостей.

// Функция вывода конкретной новости.

// Точка входа.
// Если новость присутствует - вывести ее на сайте, иначе мы выводим весь список

// Был ли передан id новости в качестве параметра?
// если параметр не был передан - выводить 404 ошибку
// http://php.net/manual/ru/function.header.php

vivod($news);

function vivod_all($news){
    foreach ($news as $key => $value)
    echo $value.'<br>';
}
?>

<html>
<head>
<meta charset = "utf-8">
<title>FORM</title>
</head>
<body>

<form method = "POST">

<p>
<input type = "test" name = "id" value = "">
</p>
<p><input type = "submit"></p>
</form>

</body>
</html>