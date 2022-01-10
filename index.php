<?php
$j = file_get_contents('people.json');
$peoples = json_decode($j,true);
$messages = explode("\n", file_get_contents('messages.txt'));
$msg = "سوال خود را بپرس!"; 
$en_name = array_rand($peoples);

if(!empty($_POST["person"])){
	$en_name = $_POST["person"];
}
$fa_name = $peoples[$en_name];
$question = "";
if(!empty($_POST["question"])){
    $question = $_POST["question"];
}
if(isset($_POST["question"])){
    $msg = $messages[intval(hash('gost', $question.$en_name))%16]; 
    $qlen = strlen($question);
    if(substr($question, 0, 6) != "آیا" || (substr($question, $qlen-2, $qlen) != "؟" && substr($question, $qlen-1, $qlen) != "?")){
        $msg="سوال درستی پرسیده نشده";
    } 
}	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label">پرسش:</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p><?php echo $msg ?></p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
                    $j = file_get_contents('people.json');
                    $peoples = json_decode($j,true);
                    foreach($peoples as $id => $fname) { 
                        if($id==$en_name) 
                            echo '<option value="' , $id , '" selected="selected">' , $fname , '</option>';
                        else 
                            echo '<option value="' , $id , '">' , $fname , '</option>';
                    }
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>