<?php
require_once 'backend/db.php';
require_once 'backend/commonFunctions.php';

$whole_perticipante_data = getAllParticipationInformation();
?>
<!DOCTYPE html>
<html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="assets/css/main.css" media="all">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <title>Test-project</title>
    </head>
    <body>
        <div  class="main-wrapper" id="main-wrapper">

            <div class="action-wrapper">
                <input type="text" id="searchKewoard"  placeholder="Search for employee name , event name or event date" title="Type in a name">
                <input type="button" class="deleteAllData entryDataButton" id="deleteAllData" value="Delete all data "/>
                <input type="button" class="insertAllData entryDataButton" id="insertAllData" value="Json import data" />
            </div>
            <table id="eventDataTable">

                <thead>
                    <tr>
                        <th>Participation id</th>
                        <th>Event date</th>
                        <th>Event name</th>
                        <th>Employee name</th>
                        <th>Employee mail</th>
                        <th>Participation fee</th>
                    </tr>
                </thead>
                <tbody id="eventDataTableTbody">
                    <?php
                    $total_amount = 0;
                    if (!empty($whole_perticipante_data)) {
                        foreach ($whole_perticipante_data as $key => $obj) {
                            $total_amount = $total_amount + $obj['participation_fee'];
                            ?>
                            <tr>
                                <td><?= $obj['participation_id'] ?></td>
                                <td><?= $obj['event_date'] ?></td>
                                <td><?= $obj['event_name'] ?></td>
                                <td><?= $obj['employee_name'] ?></td>
                                <td><?= $obj['employee_mail'] ?></td>
                                <td><?= $obj['participation_fee'] ?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="tfoot-total-amt-text"> Total fee </td>
                        <td id="total_perticipent_fee"> <?= $total_amount ?> </td> 
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div id="loaderModal" class="modal">
            <div class="modal-content"></div>
        </div>

        <script language="javascript" type="text/javascript" src="assets/js/backend.js">
        </script>
        <script language="javascript" type="text/javascript" src="assets/js/interface.js">
        </script>
        <script language="javascript" type="text/javascript" src="assets/js/events.js">
        </script>
    </body>

</html>