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
            <div class="w3-row w3-margin-top w3-margin-bottom">
                <table id="offers" class="display">
                    <thead>
                        <tr>
                            <th>Hotel</th>
                            <th>Ország</th>
                            <th>Város</th>
                            <th>Ár</th>
                            <th>Kép</th>
                            <th>Csillag</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($offers as $offer) {
                            $star = $offer['star'] == 0 ? 'N/A' : $offer['star'];
                            $rounded_price = ceil($offer['price']);

                            echo '<tr>';
                            echo "<td>{$offer['hotel_name']}</td>";
                            echo "<td>{$offer['country']}</td>";
                            echo "<td>{$offer['city']}</td>";
                            echo "<td>{$rounded_price}</td>";
                            echo "<td><img width=\"50px\" src=\"{$offer['image']}\" alt=\"Hotel image\" /></td>";
                            echo "<td>{$star}</td>";
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
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
        },
        pageLength: 21
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