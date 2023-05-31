<?php

include 'scripts/connect.php';
error_reporting(E_ALL & ~E_NOTICE);
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


// Going through each element of project arrays and check for uniqueness of skills

$project_array = [];
$projects_arrays_data = $response_data['data'];

foreach ($projects_arrays_data as $projects_arrays_elements) {
    $project_array['id'] = $projects_arrays_elements['id'];
    $project_array['name'] = $projects_arrays_elements['attributes']['name'];
    $project_array['url'] = $projects_arrays_elements['links']['self']['web'];
    $project_array['status'] = $projects_arrays_elements['attributes']['status']['name'];
    $project_array['budget_amount'] = $projects_arrays_elements['attributes']['budget']['amount'];
//    todo is_null()
        if (is_null($project_array['budget_amount'])) {
            $project_array['budget_amount'] = 0;
        }
    $project_array['budget_currency'] = $projects_arrays_elements['attributes']['budget']['currency'];
        if (is_null($project_array['budget_currency'])) {
            $project_array['budget_currency'] = 'Відсутній';
        }
    $project_array['employer_login'] = $projects_arrays_elements['attributes']['employer']['login'];
    $project_array['employer_name'] = $projects_arrays_elements['attributes']['employer']['first_name'];

    $skills = $projects_arrays_elements['attributes']['skills'];

    $project_skills_name = [];
    $project_skills_id = [];
    foreach ($skills as $arrays_skill_elements) {
        $project_skills_name[] = $arrays_skill_elements['name'];
        $project_skills_id[] = $arrays_skill_elements['id'];
        $skills_id = $arrays_skill_elements['id'];
        $skills_name = $arrays_skill_elements['name'];
        $connect->real_escape_string($skills_id);
        $connect->real_escape_string($skills_name);

        $select_skills_table = mysqli_query($connect, "SELECT * FROM `skills` WHERE `skills_id` = '$skills_id'");
        $skills_id_exists = $select_skills_table->fetch_assoc();
        if (empty($skills_id_exists)) {
            mysqli_query($connect, "INSERT INTO `skills` (`skills_id`,`skills_name`) VALUES ('$skills_id','$skills_name')");
        }
        unset($skills_id);
        unset($skills_name);
    }

    $project_skills_name_string = implode(",", $project_skills_name);
    $project_skills_id_string = implode(",", $project_skills_id);



    $check_project_id = $project_array['id'];


    // Turn to the database, check for uniqueness of project and enter it into the database

    $result = mysqli_query($connect,"SELECT * FROM `api` WHERE `project_id` = '$check_project_id' ");
    $project_exists = $result->fetch_assoc();
    $project_array['id'] = $connect->real_escape_string($project_array['id']);
    $project_array['name'] = $connect->real_escape_string($project_array['name']);
    $project_array['url'] = $connect->real_escape_string($project_array['url']);
    $project_array['status'] = $connect->real_escape_string($project_array['status']);
    $project_array['budget_amount'] = $connect->real_escape_string($project_array['budget_amount']);
    $project_array['budget_currency'] = $connect->real_escape_string($project_array['budget_currency']);
    $project_array['employer_login'] = $connect->real_escape_string($project_array['employer_login']);
    $project_array['employer_name'] = $connect->real_escape_string($project_array['employer_name']);
    $project_skills_name_string = $connect->real_escape_string($project_skills_name_string);
    if ($project_exists) {
        continue;
    } else {
        mysqli_query($connect,"INSERT INTO `api` (
                   `project_id`, `name`, `url`,`skills`,`status`,`budget_amount`,`budget_currency`,`employer_login`,`employer_name`
                   ) VALUES (
                             '{$project_array['id']}','{$project_array['name']}','{$project_array['url']}','$project_skills_name_string','{$project_array['status']}','{$project_array['budget_amount']}','{$project_array['budget_currency']}','{$project_array['employer_login']}','{$project_array['employer_name']}')");

    }

    foreach ($project_skills_id as $project_skill_id) {
        $check_skills_per_api_table = mysqli_query($connect, "SELECT * FROM `skills_per_api` WHERE `api_id` = '$check_project_id' AND `skills_id` = '$project_skill_id'");
        $skills_per_api_exists = $check_skills_per_api_table->fetch_assoc();
        $connect->real_escape_string($project_array['id']);
        $connect->real_escape_string($project_skill_id);
        if (empty($skills_per_api_exists)) {
            mysqli_query($connect, "INSERT INTO `skills_per_api` (`api_id`,`skills_id`) VALUES ('{$project_array['id']}', '$project_skill_id')");
        }
    }

    $project_array = [];
    $project_skills_name = [];
}

$db = mysqli_query($connect, "SELECT * FROM `api`");

$project_table = $db->fetch_all(MYSQLI_ASSOC);

$skills_db = mysqli_query($connect, "SELECT * FROM `skills`");

$select_table = $skills_db->fetch_all(MYSQLI_ASSOC);



?>


<style>
    table,th,td {
        border: 1px solid black;
        padding: 5px;
    }
    div {
        padding: 10px;
    }
</style>

<div>

    <form action="selected_table.php" method="post">
        <select name="selected_option[]" multiple>
            <?php foreach ($select_table as $select_row) : ?>
                <option value="<?=$select_row['skills_id']?>"><?=$select_row['skills_name']?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Відфільтрувати">
    </form>
</div>

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
</div>

