<?php
function query($query, $connection)
{
    $result = $connection->query($query);
    return $result;
}
?>