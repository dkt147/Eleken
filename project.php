<?php
session_start();
if($_SESSION['email'] == ''){
header("Location:index.php");
}

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    body {
        font-size: 140%;
    }

    h2 {
        text-align: center;
        padding: 20px 0;
    }

    table caption {
        padding: .5em 0;
    }

    table.dataTable th,
    table.dataTable td {
        white-space: nowrap;
    }

    .p {
        text-align: center;
        padding-top: 140px;
        font-size: 14px;
    }
</style>
<body>

<br>
<div id="exTab1" class="container">
    <ul  class="nav nav-pills">
        <li class="active">
            <a  href="#1a" data-toggle="tab">Projects</a>
        </li>
        <li><a href="#2a" data-toggle="tab">Receiving</a>
        </li>
        <li><a href="#3a" data-toggle="tab">Groups</a>
        </li>
        <li><a href="#4a" data-toggle="tab">Categories</a>
        </li>
        <li><a href="#5a" data-toggle="tab">Expenses</a>
        </li>
        <li><a href="#6a" data-toggle="tab">Summary</a>
        </li>
    </ul>

    <div class="tab-content clearfix">
        <div class="tab-pane active" id="1a">
            <br>

            <h2>All Projects List <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#projectModal" data-whatever="@mdo">Add new</button></h2>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="paginationFull" class="table" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Id
                                </th>
                                <th class="th-sm">Project
                                </th>
                                <th class="th-sm">Category
                                </th>
                                <th class="th-sm">Group
                                </th>
                                <th class="th-sm">Current Status
                                </th>
                                <th class="th-sm">Total Amount Received
                                </th>
                                <th class="th-sm">Created
                                </th>
                                <th class="th-sm">Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            include 'connection.php';
                            $query = "SELECT * FROM a_project";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                            <tr>
                                <td><?php echo $row['id']?></td>
                                <td><?php echo $row['name']?></td>

                                <td><?php
                                    $id = $row['category_id'];
                                    $query1 = "SELECT * FROM a_project_category where id = $id";
                                    $result1 = mysqli_query($con,$query1);
                                    $row1 = mysqli_fetch_assoc($result1);
                                    echo $row1['name'];
                                    ?>
                                </td>
                                <td><?php
                                    $id = $row['id'];
                                    $query1 = "SELECT * FROM a_project_assign where project_id = $id";
                                    $result1 = mysqli_query($con,$query1);
                                    if(mysqli_num_rows($result1) > 0) {
                                    $row1 = mysqli_fetch_assoc($result1);
                                    $id1 = $row1['group_id'];
                                    $query1 = "SELECT * FROM a_group where id = $id1";
                                    $result1 = mysqli_query($con,$query1);

                                        $row1 = mysqli_fetch_assoc($result1);
                                        echo $row1['name'];
                                    }else{
                                        echo "Not Assigned";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['status']?></td>
                                <td><?php
                                    $id = $row['id'];
                                    $query1 = "SELECT SUM(cash_amount)+SUM(amount) as total FROM a_receivings where project_id = $id";
                                    $result1 = mysqli_query($con,$query1);
                                    if(mysqli_num_rows($result1) > 0){
                                        $row1 = mysqli_fetch_assoc($result1);
                                        echo $row1['total'];
                                    }else{
                                        echo "Not yet received";
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row['created_at']?></td>
                                <td>
                                    <select id="status" class="form-control changeStatus">
                                        <option selected disabled>Change Status</option>
                                        <option value="Running<?php echo ",".$row['id']?>">Running</option>
                                        <option value="Completed<?php echo ",".$row['id']?>">Completed</option>
                                        <option value="Failed<?php echo ",".$row['id']?>">Failed</option>
                                    </select>

                                    <?php
                                    $id = $row['id'];
                                    $query1 = "SELECT * FROM a_project_assign where project_id = $id";
                                    $result1 = mysqli_query($con,$query1);
                                    if(mysqli_num_rows($result1) > 0) {
                                        $row1 = mysqli_fetch_assoc($result1);
                                        $id1 = $row1['group_id'];
                                        $query1 = "SELECT * FROM a_group where id = $id1";
                                        $result1 = mysqli_query($con,$query1);

                                        $row1 = mysqli_fetch_assoc($result1);
                                    }else{?>
                                        <select id="assign" class="form-control assign">

                                            <?php
                                            $queryw = "SELECT * FROM a_group";
                                            $resultw = mysqli_query($con,$queryw);

                                            while($roww = mysqli_fetch_assoc($resultw)){?>
                                                <option value="<?php echo $roww['id'].",".$row['id'];?>"><?php echo $roww['name'];?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    <?php
                                    }
                                    ?>

                                    <i class="fa fa-trash-o" style="font-size:30px;color:red" onclick="deleteProject(<?php echo $row['id']?>)"></i>
                                    <i class="fa fa-pencil" style="font-size:30px;color:navy"></i>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </table> </div>
                </div>
            </div>


        </div>
        <div class="tab-pane" id="2a">
            <br>

            <h2>All Receivings <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#receiveModal" data-whatever="@mdo">Add new</button></h2>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="paginationFull1" class="table" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Id
                                </th>
                                <th class="th-sm">Project
                                </th>
                                <th class="th-sm">Mode
                                </th>
                                <th class="th-sm">Bank
                                </th>
                                <th class="th-sm">Amount
                                </th>
                                <th class="th-sm">Cheque #
                                </th>
                                <th class="th-sm">Created
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            include 'connection.php';
                            $query = "SELECT * FROM a_receivings";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>

                                    <td><?php
                                        $id = $row['project_id'];
                                        $query1 = "SELECT * FROM a_project where id = $id";
                                        $result1 = mysqli_query($con,$query1);
                                        $row1 = mysqli_fetch_assoc($result1);
                                        echo $row1['name'];
                                        ?>
                                    </td>
                                    <td><?php echo $row['mode']?></td>
                                    <td><?php echo $row['bank_name']?></td>
                                    <td><?php echo ($row['mode'] == 'cash') ?$row['cash_amount'] : $row['amount'];?></td>
                                    <td><?php echo $row['cheque_no']?></td>
                                    <td><?php echo $row['created_at']?></td>


                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table> </div>
                </div>
            </div>

        </div>
        <div class="tab-pane" id="3a">
            <br>

            <h2>All Groups</h2>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="paginationFull2" class="table" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Id
                                </th>
                                <th class="th-sm">Group Name
                                </th>
                                <th class="th-sm">Created
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            include 'connection.php';
                            $query = "SELECT * FROM a_group";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['name']?></td>
                                    <td><?php echo $row['created_at']?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table> </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="4a">
            <br>

            <h2>All Categories</h2>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="paginationFull3" class="table" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Id
                                </th>
                                <th class="th-sm">Category Name
                                </th>
                                <th class="th-sm">Created
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            include 'connection.php';
                            $query = "SELECT * FROM a_project_category";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['name']?></td>
                                    <td><?php echo $row['created_at']?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table> </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="5a">
            <br>

            <h2>Expenses <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#expenseModal" data-whatever="@mdo">Add new</button></h2>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="paginationFull4" class="table" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Id
                                </th>
                                <th class="th-sm">Project
                                </th>
                                <th class="th-sm">Group
                                </th>
                                <th class="th-sm">Event
                                </th>
                                <th class="th-sm">Amount
                                </th>
                                <th class="th-sm">Date
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            include 'connection.php';
                            $query = "SELECT  a_project.*,a_project.name as p_name,a_group.*,a_group.name as g_name,a_expenses.* FROM a_expenses JOIN a_project ON a_project.id = a_expenses.project_id JOIN a_group ON a_group.id = a_expenses.group_id";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['p_name']?></td>
                                    <td><?php echo $row['g_name']?></td>
                                    <td><?php echo $row['event']?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><?php echo $row['created_at']?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table> </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="6a">
            <br>

            <h2>Summary<br>
                <select class="form-control" name="sp_name" id="sp_name" style="width: 230px;display: inline">
                    <option selected disabled>Project</option>
                    <?php
                    $query = "SELECT * FROM a_project";
                    $result = mysqli_query($con,$query);
                    while($row = mysqli_fetch_assoc($result)){?>
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php
                    }
                    ?>
                </select>
                <select class="form-control" name="sp_name" id="sp_name" style="width: 100px;display: inline">
                    <option selected disabled>Group</option>
                    <?php
                    $query = "SELECT * FROM a_group";
                    $result = mysqli_query($con,$query);
                    while($row = mysqli_fetch_assoc($result)){?>
                        ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                        <?php
                    }
                    ?>
                </select>

                <input type="date" name="date" id="date" class="form-control" style="width: 130px;display: inline">
                <input type="month" name="month" id="month" class="form-control" style="width: 130px;display: inline">
<!--                <input name="year" id="year" class="date-own form-control" style="width: 130px;display: inline" type="number" min="1900" max="2099" step="1" value="2016">-->


            </h2>

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table id="paginationFull4" class="table" width="100%">
                            <thead>
                            <tr>
                                <th class="th-sm">Id
                                </th>
                                <th class="th-sm">Project
                                </th>
                                <th class="th-sm">Group
                                </th>
                                <th class="th-sm">Event
                                </th>
                                <th class="th-sm">Amount
                                </th>
                                <th class="th-sm">Date
                                </th>
                            </tr>
                            </thead>
                            <tbody id="onchangeTable">

                            <?php
                            include 'connection.php';
                            $query = "SELECT  a_project.*,a_project.name as p_name,a_group.*,a_group.name as g_name,a_expenses.* FROM a_expenses JOIN a_project ON a_project.id = a_expenses.project_id JOIN a_group ON a_group.id = a_expenses.group_id";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                <tr>
                                    <td><?php echo $row['id']?></td>
                                    <td><?php echo $row['p_name']?></td>
                                    <td><?php echo $row['g_name']?></td>
                                    <td><?php echo $row['event']?></td>
                                    <td><?php echo $row['amount']?></td>
                                    <td><?php echo $row['created_at']?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table> </div>
                </div>
            </div>

            <?php

            $dataPoints = array(
                array("label"=> "Jan", "y"=> 60.0),
                array("label"=> "Feb", "y"=> 6.5),
                array("label"=> "Mar", "y"=> 4.6),
                array("label"=> "Apr", "y"=> 2.4),
                array("label"=> "May", "y"=> 1.9),
                array("label"=> "Jun", "y"=> 1.8),
                array("label"=> "Jul", "y"=> 1.5),
                array("label"=> "Aug", "y"=> 1.5),
                array("label"=> "Sep", "y"=> 1.3),
                array("label"=> "Aug", "y"=> 0.9),
                array("label"=> "Nov", "y"=> 0.8),
                array("label"=> "Dec", "y"=> 0.8)
            );

            ?>

            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
        </div>
    </div>
</div>


<!--Add new Project Modal Form-->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Category:</label>
                        <select class="form-control" name="project_category" id="project_category">
                            <?php
                            $query = "SELECT * FROM a_project_category";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                            ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Name:</label>
                        <input type="text" name="name" class="form-control" id="project_name">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Status:</label>
                        <select class="form-control" name="status" id="project_status">
                                <option value="Running">Running</option>
                            <option value="Completed">Completed</option>
                            <option value="Failed">Failed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Assign to:</label>
                        <select class="form-control" id="project_assign">
                            <?php
                            $query = "SELECT * FROM a_group";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNewProject">Create</button>
            </div>
        </div>
    </div>
</div>

<!--Add new Receiving Modal Form-->
<div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Category:</label>
                        <select class="form-control" name="project_category" id="rp_name">
                            <?php
                            $query = "SELECT * FROM a_project";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Mode:</label>
                        <select class="form-control clickCheque" name="mode" id="mode" required>
                                <option selected disabled> Select Payment Mode</option>
                            <option value="cash">Cash</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Bank:</label>
                        <select class="form-control" name="bank" id="bank" required>
                            <option selected disabled> Select Bank</option>
                            <option value="HBL">Habib Bank Limited (HBL)</option>
                            <option value="BAHL">Bank Al Habib (BAHL)</option>
                            <option value="ABL">Allied Bank Limited (ABL)</option>
                            <option value="AKBL">Askari Bank Limited (AKBL)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Amount</label>
                        <input type="number" name="cash" class="form-control" id="cash">
                    </div>

                    <div class="form-group" style="display:none;" id="click_div">
                        <label for="recipient-name" class="col-form-label">Cheque #</label>
                        <input type="text" name="cash" class="form-control" id="cheque" minlength="10" maxlength="10">
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNewPayment">Create</button>
            </div>
        </div>
    </div>
</div>

<!--Add new Expense Modal Form-->
<div class="modal fade" id="expenseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Category:</label>
                        <select class="form-control" name="project_category" id="ep_name">
                            <?php
                            $query = "SELECT * FROM a_project";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Category:</label>
                        <select class="form-control" name="project_category" id="eg_name">
                            <?php
                            $query = "SELECT * FROM a_group";
                            $result = mysqli_query($con,$query);
                            while($row = mysqli_fetch_assoc($result)){?>
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Event</label>
                        <input type="text" name="e_event" class="form-control" id="e_event">
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Amount</label>
                        <input type="number" name="e_amount" class="form-control" id="e_amount">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary addNewExpense">Add</button>
            </div>
        </div>
    </div>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</body>

<script>

    $("#sp_name").on('change',function(event) {

        document.getElementById('onchangeTable').innerHTML = ""

        var project = $(this).val()
        console.log("Change Project ",project)

        $.ajax({
            url : "_project_list.php",
            type : "POST",
            data:{p_id:project},
            success : function(data){
                console.log(data)

                document.getElementById('onchangeTable').innerHTML = data
            }
        });


        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "CMS Market Share - 2017"
            },
            axisY: {
                suffix: "%",
                scaleBreaks: {
                    autoCalculate: true
                }
            },
            data: [{
                type: "column",
                yValueFormatString: "#,##0\"%\"",
                indexLabel: "{y}",
                indexLabelPlacement: "inside",
                indexLabelFontColor: "white",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    });

    $(document).ready(function () {
        //Pagination full
        $('#paginationFull').DataTable({
            "pagingType": "full"
        });
        $('#paginationFull1').DataTable({
            "pagingType": "full"
        });
        $('#paginationFull2').DataTable({
            "pagingType": "full"
        });
        $('#paginationFull3').DataTable({
            "pagingType": "full"
        });
        $('#paginationFull4').DataTable({
            "pagingType": "full"
        });

        $(".addNewProject").click(function(event) {
            var project_category = document.getElementById("project_category").value
            var name = document.getElementById("project_name").value
            var status = document.getElementById("project_status").value
            var project_assign = document.getElementById("project_assign").value

            console.log(project_category,name,status,project_assign)

            $.ajax({
                url : "_add_project.php",
                type : "POST",
                data:{name:name,category:project_category,status:status,project_assign:project_assign},
                success : function(data){
                   if(data == 1){
                       alert("Successfully Added!")
                       window.location.href = 'project.php'
                   }
                }
        });
        });


        $(".changeStatus").on('change',function(event) {

            var status = $(this).val()
            status = status.split(",")
            console.log("Change Status",status[0],status[1])

            $.ajax({
                url : "_update_status.php",
                type : "POST",
                data:{id:status[1],status:status[0]},
                success : function(data){
                    if(data == 1){
                        alert("Successfully Updated!")
                        window.location.href = 'project.php'
                    }
                }
            });
        });


        $(".assign").on('change',function(event) {

            var id = $(this).val()
            id = id.split(",")
            console.log("Assing Group",id[0],id[1])

            $.ajax({
                url : "_assign_project.php",
                type : "POST",
                data:{group:id[0],p_id:id[1]},
                success : function(data){
                    if(data == 1){
                        alert("Successfully Assigned!")
                        window.location.href = 'project.php'
                    }else{
                        alert("Request Failed!")
                    }
                }
            });

        });

        $(".addNewPayment").on('click',function(event) {

            var rp_name = document.getElementById("rp_name").value
            var mode = document.getElementById("mode").value
            var bank = document.getElementById("bank").value
            var cash = document.getElementById("cash").value
            var cheque = document.getElementById("cheque").value

            $.ajax({
                url : "_add_payment.php",
                type : "POST",
                data:{rp_name:rp_name,mode:mode,bank:bank,cash:cash,cheque:cheque},
                success : function(data){
                    if(data == 1){
                        alert("Successfully Received!")
                        window.location.href = 'project.php'
                    }else{
                        alert("Request Failed!")
                    }
                }
            });

        });
        
        function deleteProject(id) {
            alert(id)
        }


        $(".clickCheque").on('change',function(event) {
            var mode = $(this).val()
            if(mode == 'cheque'){

            }
            $("#click_div").css("display", "block");
        });

        $(".addNewExpense").click(function(event) {
            var ep_name = document.getElementById("ep_name").value
            var eg_name = document.getElementById("eg_name").value
            var e_event = document.getElementById("e_event").value
            var e_amount = document.getElementById("e_amount").value



            if(ep_name != '' && eg_name != '' && e_event != '' && e_amount != ''){
                console.log(ep_name,eg_name,e_event,e_amount);

                $.ajax({
                    url : "_add_expense.php",
                    type : "POST",
                    data:{ep_name:ep_name,eg_name:eg_name,e_event:e_event,e_amount:e_amount},
                    success : function(data){
                        if(data == 1){
                            alert("Expense Added!")
                            window.location.href = 'project.php'
                        }
                    }
                });

                }else{
                alert('Some Fields are empty!')
            }
        });


    });
</script>
</html>