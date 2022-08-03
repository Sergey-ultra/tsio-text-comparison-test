<?php
$layout = 'master';
$title = 'Результат';



foreach($result as $element){
    if (!isset($element['color'])){
        echo '<div>' . ' '. $element['text'] . '</div>';
    } else if($element['color'] === 'yellow') {
        echo '<div class="tooltip" style="background:' . $element['color'] . '">' . ' '. $element['text'] .
             '<span class="tooltiptext">' .  $element['prev'] . '</span></div>';
    } else {
        echo '<div style="background:' . $element['color'] .'">' . ' '. $element['text'] . '</div>';
    }
}
?>




