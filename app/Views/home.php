<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>app/Libraries/w3.css" />
    <!-- DataTables style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>app/Libraries/datatables/datatables.min.css" />
    <title>Swiss Haley</title>
    <style>
    #table_container {
        width: 80%;
        margin: 50px auto 0 auto
    }
    </style>
</head>

<body>
    <div class="w3-container" id="wrapper">
        <span id="base_url" class="w3-hide"><?php echo base_url(); ?></span>
        <div class="w3-container" id="table_container">
            <div class="w3-panel w3-blue w3-padding w3-xlarge w3-round w3-card-4">Ajánlatok</div>
            <div class="w3-row w3-margin-top">
                <table id="offers" class="display">
                    <thead>
                        <tr>
                            <th>Hotel</th>
                            <th>Ország</th>
                            <th>Város</th>
                            <th>Ár</th>
                            <th>Kép</th>
                            <th>Osztályozás</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot></tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>app/Libraries/jquery.js"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>app/Libraries/datatables/datatables.min.js"></script>
    <script>
    $("#offers").DataTable({
        language: {
            url: $("span#base_url").text() + 'app/Libraries/datatables/HU_hu.json'
        }
    });
    </script>
    <script>
        $(document).ready(function() {
            $("select[name='offers_length']").children("option[value='10']").hide();
            $("select[name='offers_length']").children("option[value='25']").prop('selected', true);
        });
    </script>
</body>

</html>