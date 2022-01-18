<?php
    $numero=$_POST['numero'];

    echo '<table border="1">';
    for($i=1;$i<=$numero;$i++)
    {
        echo "<tr><td>$i</td></tr>";
    }
    echo '</table>';
?>