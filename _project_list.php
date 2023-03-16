<?php
include 'connection.php';
$p_id = $_POST['p_id'];
$query = "SELECT  a_project.*,a_project.name as p_name,a_group.*,a_group.name as g_name,a_expenses.* FROM a_expenses JOIN a_project ON a_project.id = a_expenses.project_id JOIN a_group ON a_group.id = a_expenses.group_id where a_expenses.id = $p_id";
$result = mysqli_query($con, $query);
$html = '';
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;

    $html .= "<tr>
                <td>".$row['id']."</td>
                <td>".$row['p_name']."</td>
                <td>".$row['g_name']."</td>
                <td>".$row['event']."</td>
                <td>".$row['amount']."</td>
                <td>".$row['created_at']."</td>
                </tr>";

}

echo $html;
?>