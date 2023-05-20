<?php

include 'scripts/connect.php';

// Receive data from the API and convert them into arrays

$header = [];
$header[] = "Authorization: Bearer f1b6bcacb702b84328ab88db9811df8d025c38c5";

$ch = curl_init();

$url = "https://api.freelancehunt.com/v2/projects";

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

$cd = curl_exec($ch);

$response_data = json_decode($cd, true);


// Going through each element of project arrays

$project_array = [];
$projects_arrays_data = $response_data['data'];

foreach ($projects_arrays_data as $projects_arrays_elements) {
    $project_array['id'] = $projects_arrays_elements['id'];
    $project_array['name'] = $projects_arrays_elements['attributes']['name'];
    $project_array['url'] = $projects_arrays_elements['links']['self']['web'];
    $project_array['status'] = $projects_arrays_elements['attributes']['status']['name'];
    $project_array['budget_amount'] = $projects_arrays_elements['attributes']['budget']['amount'];
//    todo is_null()
        if ($project_array['budget_amount'] == null) {
            $project_array['budget_amount'] = 0;
        }
    $project_array['budget_currency'] = $projects_arrays_elements['attributes']['budget']['currency'];
        if ($project_array['budget_currency'] == null) {
            $project_array['budget_currency'] = 'Відсутній';
        }
    $project_array['employer_login'] = $projects_arrays_elements['attributes']['employer']['login'];
    $project_array['employer_name'] = $projects_arrays_elements['attributes']['employer']['first_name'];

    $skills = $projects_arrays_elements['attributes']['skills'];

    $project_skills = [];
    foreach ($skills as $arrays_skill_elements) {
        $project_skills[] = $arrays_skill_elements['name'];
    }
    $project_skills_string = implode(",", $project_skills);

    $check_project_id = $project_array['id'];


    // Turn to the database, check for uniqueness and enter it into the database

    $result = mysqli_query($connect,"SELECT * FROM `api` WHERE `project_id` = '$check_project_id' ");
    $project_exists = $result->fetch_assoc();
    if ($project_exists) {
        continue;
    } else {
        mysqli_query($connect,"INSERT INTO `api` (
                   `project_id`, `name`, `url`,`skills`,`status`,`budget_amount`,`budget_currency`,`employer_login`,`employer_name`
                   ) VALUES (
                             '{$project_array['id']}','{$project_array['name']}','{$project_array['url']}','$project_skills_string','{$project_array['status']}','{$project_array['budget_amount']}','{$project_array['budget_currency']}','{$project_array['employer_login']}','{$project_array['employer_name']}')");
        $project_array = [];
        $project_skills = [];
    }

}

$db = mysqli_query($connect, "SELECT * FROM `api`");

$project_table = $db->fetch_all(MYSQLI_ASSOC);

?>


<style>
    table,th,td {
        border: 1px solid black;
        padding: 5px;
    }
</style>

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
    <?php foreach ($project_table as $table_row) : ?>
    <tr>
        <td><?=$table_row['name']?></td>
        <td><?=$table_row['url']?></td>
        <td><?=$table_row['status']?></td>
        <td><?=$table_row['skills']?></td>
        <td><?=$table_row['budget_amount']?></td>
        <td><?=$table_row['budget_currency']?></td>
        <td><?=$table_row['employer_login']?></td>
        <td><?=$table_row['employer_name']?></td>
    </tr>
    <?php endforeach; ?>
</table>
