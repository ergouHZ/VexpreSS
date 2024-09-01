<?php
function get_points()
{
    global $db;
    $query = 'SELECT * FROM accesspoint
              ORDER BY Id';
    $statement = $db->prepare($query);
    $statement->execute();
    $points = $statement->fetchAll();
    $statement->closeCursor();
    return $points;
}

function get_category_name($category_id)
{
    global $db;
    $query = 'SELECT * FROM categories
              WHERE categoryID = :category_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->execute();
    $category = $statement->fetch();
    $statement->closeCursor();
    $category_name = $category['categoryName'];
    return $category_name;
}
?>