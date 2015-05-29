<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1);

session_start();

if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'delete':{
            if(isset($_GET['id'])){
                unset($_SESSION['ads'][(int)$_GET['id']]);
                header('Location: '.$_SERVER['PHP_SELF']);
                exit;
            }
            break;
        }
        case 'edit':{
            if(isset($_GET['id'])){
                $id = (int)$_GET['id'];
                if(isset($_SESSION['ads'][$id])){
                    show_form($id);
                }
            }
            break;
        }
    }
}else{
    show_form();
}





function getFullList()
{
    
    if(count($_SESSION['ads']))
    {
        $ads = $_SESSION['ads'];
        foreach($ads as $key=>$val)
        {
            echo "<a href='?action=edit&id=$key'>".$val['title']."</a> - <a href='?action=delete&id=$key'>удалить</a><br>";
        }
        
    }
    
    else
    {
        echo "Объявлений нет";
    }
    
}



function show_form($id=false){
    // вытащить объявление из базы (массив сессии)
    //распихать значения объявления по форме
    $ad['seller_name']='';
    $ad['email']='';
    $ad['price']='0';
    $ad['main_form_submit']='Отправить';
    $ad['phone'] = '';
    $ad['title'] = '';
    $ad['description'] = '';
    $gorod = ''; 
    $stanciya = '';
    $metka = '';
    $ad['private1'] = 'checked';
    $ad['private2'] = '';
    $ad['allow_mails'] = '';
    
    
    if (!empty($_POST))
    {
        $ad['seller_name']=$_POST['seller_name'];
        $ad['email']=$_POST['email'];
        $ad['price']=$_POST['price'];
        $ad['phone'] =$_POST['phone'];
        $ad['title'] =$_POST['title'];
        $ad['description'] =$_POST['description'];
        $gorod = $_POST['location_id'];
        $stanciya = $_POST['metro_id'];
        $metka = $_POST['category_id'];
        
        
        if ($_POST['private']=='1')
        {
            $ad['private1'] = 'checked';
            $ad['private2'] = '';
        }
        else
        {
         $ad['private1'] = '';
         $ad['private2'] = 'checked';
        }
        
    }
    
    
    

    if(isset($id) && is_numeric($id)) 
    {
        $ad = $_SESSION['ads'][$id];
        $ad['main_form_submit']='Сохранить';
        $gorod = $_SESSION['ads'][$id]['location_id'];
        $stanciya = $_SESSION['ads'][$id]['metro_id'];
        $metka = $_SESSION['ads'][$id]['category_id'];
        
        if ($_SESSION['ads'][$id]['private']=='1')
        {
            $ad['private1'] = 'checked';
            $ad['private2'] = '';
        }
        else
        {
         $ad['private1'] = '';
         $ad['private2'] = 'checked';
        }
    
    if (isset($_SESSION['ads'][$id]['allow_mails']))
        {
            $ad['allow_mails'] = 'checked';
        }
        
        else
        {
              $ad['allow_mails'] = '';
        }
    
    
       }
    
        $citys = array(
    '641780'=>'Новосибирск',
    '641490'=>'Барабинск',
    '641510'=>'Бердск',
    '641600'=>'Искитим',
    '641630'=>'Колывань',
    '641680'=>'Краснообск',
    '641710'=>'Куйбышев',
    '641760'=>'Мошково',
    '641790'=>'Обь',
    '641800'=>'Ордынское',
    '641970'=>'Черепаново');
    
        $stations = array(
    '2028'=>'Берёзовая роща',
    '2018'=>'Гагаринская',
    '2017'=>'Заельцовская',
    '2029'=>'Золотая Нива',
    '2019'=>'Красный проспект',
    '2027'=>'Маршала Покрышкина',
    '2021'=>'Октябрьская',
    '2025'=>'Площадь Гарина-Михайловского',
    '2020'=>'Площадь Ленина',
    '2024'=>'Площадь Маркса',
    '2022'=>'Речной вокзал',
    '2026'=>'Сибирская',
    '2023'=>'Студенческая');         

          
         $labels_1 = array(
    '9'=>'Автомобили с пробегом',
    '109'=>'Новые автомобили',
    '14'=>'Мотоциклы и мототехника',
    '81'=>'Грузовики и спецтехника',
    '11'=>'Водный транспорт',
    '10'=>'Запчасти и аксессуары');
             
             
        $labels_2 = array(
    '24'=>'Квартиры',
    '23'=>'Комнаты',
    '25'=>'Дома, дачи, коттеджи',
    '26'=>'Земельные участки',
    '85'=>'Гаражи и машиноместа',
    '42'=>'Коммерческая недвижимость',
    '86'=>'Недвижимость за рубежом');   
             
              
?>
    
    <form  method="post">
    
    
    <div class="form-row-indented"> 
        <label class="form-label-radio">
            <input type="radio" <?=$ad['private1']?> value="1" name="private">Частное лицо</label> 
        <label class="form-label-radio">
            <input type="radio" <?=$ad['private2']?>  value="2" name="private">Компания</label> 
    </div>
    <br>
    <div class="form-row"> 
        <label for="fld_seller_name" class="form-label">
            <b id="your-name">Ваше имя</b></label>
        <input type="text" maxlength="40" class="form-input-text" value="<?=$ad['seller_name']?>" name="seller_name" id="fld_seller_name">
    </div>

    <br>
    <div class="form-row"> 
        <label for="fld_email" class="form-label">Электронная почта</label>
        <input type="text" class="form-input-text" value="<?=$ad['email']?>" name="email" id="fld_email">
    </div>
    <br>
    <div class="form-row-indented"> 
        <label class="form-label-checkbox" for="allow_mails"> 
            <input type="checkbox" value="1" <?=$ad['allow_mails']?> name="allow_mails" id="allow_mails" class="form-input-checkbox">
            <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> 
        </label> 
    </div>
    <br>
    <div class="form-row"> 
        <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> 
        <input type="text" class="form-input-text" value="<?=$ad['phone']?>" name="phone" id="fld_phone">
    </div>
    <br>
    
   <div id="f_location_id" class="form-row form-row-required"> 
   <label for="region" class="form-label">Город</label> 
   <select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
   <option value="">-- Выберите город --</option>
            <option class="opt-group" disabled="disabled">-- Города --</option>
<?php
                
                    foreach($citys as $number=>$city)
                    {
                        $selected_c = ($number==$gorod) ? 'selected=""' : ''; //если мы передали в функцию город который нужно выставить в списке то мы ставим специальную метку в селектор
                        echo '<option data-coords=",," '.$selected_c.' value="'.$number.'">'.$city.'</option>';
                    }
?>


  </select>
    </div>
       
        <div id="f_metro_id"> 
            <select title="Выберите станцию метро" name="metro_id" id="fld_metro_id" class="form-input-select"> 
                <option value="">-- Выберите станцию метро --</option>
<?php
                
                    foreach($stations as $number=>$station)
                    {
                        $selected = ($number==$stanciya) ? 'selected=""' : ''; //если мы передали в функцию город который нужно выставить в списке то мы ставим специальную метку в селектор
                        echo '<option data-coords=",," '.$selected.' value="'.$number.'">'.$station.'</option>';
                    }
                  
?>                
                
            
            
            </select> 
        </div> 
         
    <br>
    <div class="form-row"> 
        <label for="fld_category_id" class="form-label">Категория</label> 
        <select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-input-select"> 
            <option value="">-- Выберите категорию --</option>
            <optgroup label="Транспорт">
<?php
                
                    foreach($labels_1 as $number=>$lable)
                    {
                        $selected = ($number==$metka) ? 'selected=""' : ''; //если мы передали в функцию город который нужно выставить в списке то мы ставим специальную метку в селектор
                        echo '<option data-coords=",," '.$selected.' value="'.$number.'">'.$lable.'</option>';
                    }
                  
?> 
            
            </optgroup>
            <optgroup label="Недвижимость">

<?php
                
                    foreach($labels_2 as $number=>$lable)
                    {
                        $selected = ($number==$metka) ? 'selected=""' : ''; //если мы передали в функцию город который нужно выставить в списке то мы ставим специальную метку в селектор
                        echo '<option data-coords=",," '.$selected.' value="'.$number.'">'.$lable.'</option>';
                    }
                  
?> 
       

            </optgroup>
            
            
            
        </select> 
    </div>
    
<br>

    <div style="display: none;" id="params" class="form-row form-row-required"> 
        <label class="form-label ">
            Выберите параметры
        </label> 
        <div class="form-params params" id="filters">
        </div> 
    </div>
    <br>
    <div id="f_title" class="form-row f_title"> 
        <label for="fld_title" class="form-label">Название объявления</label> 
        <input type="text" maxlength="50" class="form-input-text-long" value="<?=$ad['title']?>" name="title" id="fld_title"> 
    </div>
    <br>
    <div class="form-row"> 
        <label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label> 
        <textarea maxlength="3000" name="description" id="fld_description" class="form-input-textarea"><?=$ad['description']?></textarea> 
    </div>
    <div id="price_rw" class="form-row rl"> 
        <label id="price_lbl" for="fld_price" class="form-label">Цена</label> 
        <input type="text" maxlength="9" class="form-input-text-short" value="<?=$ad['price']?>" name="price" id="fld_price">&nbsp;
        <span id="fld_price_title">руб.</span> 
        
    </div>


    <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
        <div class="vas-submit-button pull-left"> 
                 <input type="submit" value="<?=$ad['main_form_submit']?>" id="form_submit" name="main_form_submit" class="vas-submit-input"> 
        </div>
    </div>
</form>
<pre>
    
<?php
}

if(isset($_POST['main_form_submit']) && $_POST['main_form_submit']=="Отправить")

{
    foreach ($_POST as $id=>$val)
    {
        if(empty($val) && $val != 'allow_mails') 
        {
                exit ('Введите значение '.$id.' в форму!!!');
                
        }
        
        
    }
    
    
$_SESSION['ads'][]=$_POST;


}


if(isset($_POST['main_form_submit']) && $_POST['main_form_submit']=="Сохранить")

{
    foreach ($_POST as $par=>$val)
    {
        if(empty($val) && $val != 'allow_mails') 
        {
                exit ('Введите значение '.$par.' в форму!!!');
                
        }
    }
    
$id_red = $_GET['id'];
$_SESSION['ads'][$id_red]=$_POST;
}


if (!empty($_SESSION))
getFullList();



?>



