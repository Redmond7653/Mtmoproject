<?php

include "scripts/connect.php";

$selected_table = [];
$selected_project_arrays_in_arrays = [];
foreach ($_REQUEST['selected_option'] as $array_element_of_request) {
    $selected_table = mysqli_query($connect, "SELECT * FROM `skills_per_api` WHERE `skills_id` = '$array_element_of_request'");
    $selected_project_arrays_in_arrays[] = $selected_table->fetch_all(MYSQLI_ASSOC);
}

$all_project_ids = [];
foreach ($selected_project_arrays_in_arrays as $selected_project_arrays) {
    foreach ($selected_project_arrays as $selected_project_array) {
        $all_project_ids[] = $selected_project_array['api_id'];
    }
}
$selected_project_in_array = mysqli_query($connect, "SELECT * FROM `api` WHERE `project_id` IN (".implode(',', $all_project_ids).")");
$result = $selected_project_in_array->fetch_all(MYSQLI_ASSOC);
//function get_selected_project_array ($selected_project_arrays_in_arrays)
//{
//    foreach ($selected_project_arrays_in_arrays as $selected_project_array) {
//        $project_id = $selected_project_array['api_id'];
//        $selected_array = mysqli_query($connect, "SELECT * FROM `api` WHERE `project_id` = '$project_id'");
//        $result = $selected_array->fetch_all(MYSQLI_ASSOC);
//        return $result;
//    }
//
//}
$test = [];
foreach ($_REQUEST['selected_option'] as $list_of_skills){
    $test[] = $list_of_skills;
}

$selected_skills = mysqli_query($connect,"SELECT skills_name FROM `skills` WHERE `skills_id` IN (".implode(',', $test).")");
$rows = $selected_skills->fetch_all(MYSQLI_ASSOC);





?>

<style>
    table, th,td {
        border: 1px solid black;
        padding: 5px;
    }
    div {
        padding: 5px;
    }
</style>

<h1>Перелік проектів з вибраними навичками:<?php echo implode(', ', array_column($rows, 'skills_name'))?>
</h1>

<div>
    <table>
        <tr>
            <th>Назва проекту</th>
            <th>URL</th>
            <th>Статус</th>
            <th>Навички</th>
            <th>Бюджет</th>
            <th>Валюта</th>
            <th>Логін замовника</th>
            <th>Ім'я замовника</th>
        </tr>
        <?php foreach ($result as $project_array) : ?>
        <tr>
            <td><?=$project_array['name']?></td>
            <td><?=$project_array['url']?></td>
            <td><?=$project_array['status']?></td>
            <td><?=$project_array['skills']?></td>
            <td><?=$project_array['budget_amount']?></td>
            <td><?=$project_array['budget_currency']?></td>
            <td><?=$project_array['employer_login']?></td>
            <td><?=$project_array['employer_name']?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div>
    <form action="Final_phpcource_hometask.php" method="post">
        <input type="submit" value="На головну">
    </form>
</div>