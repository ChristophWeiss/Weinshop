<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
        <
        script
        src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity = "sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin = "anonymous" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</head>
<body>
<script>
    var arrHead = new Array();
    var arrBestellung = new Array();
    var bestellung = new Array();
    arrHead = ['', 'Anzahl', 'ID', 'name', 'Preis'];

    function addWeintoCard(arr) {
        var js_array = arr;
        console.log(js_array)
        console.log(arr)
        addRow(js_array);
    }

    function addRow(array) {

        console.log(arrBestellung)
        counter = 0;
        var empTab = document.getElementById('shopping_cart');

        if (arrBestellung.includes(array.id) == false) {
            var anzahl = 1;
            arrBestellung.push(array.id)
            var rowCnt = empTab.rows.length;
            var tr = empTab.insertRow(rowCnt);
            tr = empTab.insertRow(rowCnt);

            for (var c = 0; c < arrHead.length; c++) {
                var td = document.createElement('td');          // TABLE DEFINITION.
                td = tr.insertCell(c);

                if (c == 0) {

                    var button = document.createElement('input');

                    // SET INPUT ATTRIBUTE.
                    button.setAttribute('type', 'button');
                    button.setAttribute('value', 'Remove');

                    // ADD THE BUTTON's 'onclick' EVENT.
                    button.setAttribute('onclick', 'removeRow(this)');

                    td.appendChild(button);
                } else {
                    if (counter == 0) {
                        counter++;
                        var p = document.createElement('p');
                        p.setAttribute("id", array.id);
                        p.innerHTML = anzahl;
                    } else if (counter == 1) {
                        counter++;
                        var p = document.createElement('p');
                        p.innerHTML = array.id;
                    } else if (counter == 2) {
                        counter++;
                        var p = document.createElement('p');
                        p.innerHTML = array.name;
                    } else if (counter == 3) {
                        counter++;
                        var p = document.createElement('p');
                        p.innerHTML = array.preis;
                    }

                    td.appendChild(p);
                }
            }
        } else {
            var td = document.getElementById(array.id);


            let anzahl = td.innerHTML;
            anzahl++;
            td.innerHTML = anzahl;
            td = document.getElementById(array.id);


        }
        let id = array.id;
        var td = document.getElementById(array.id);


        bestellung[id] = td.innerHTML


    }

    function sendBestellung() {
        console.log(bestellung)
        var keys = Object.keys(bestellung);
        var strong = "";
        console.log(keys.length, "keys length")
        console.log(keys, "keys")
        console.log(bestellung.length, "bestellung length")
        console.log(bestellung, "bestellung")
        for (var i = 0; i < keys.length; i++) {
            var z = i;
            if (z++ < keys.length - 1) {
                strong += keys[i] + "," + bestellung[i + 1] + ",";

            } else {
                strong += keys[i] + "," + bestellung[i + 1];
            }
        }

        var postData = strong;
        console.log(postData)
        $.ajax({
            type: "POST",
            url: "?action=BestellungAnlegen",
            data: {bestellung: postData},
            success: function (response) {
                alert(response);
            }
        });
    }
</script>
<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Preis</th>
    </tr>
    </thead>
    <?php foreach ($weine as $wein) { ?>

        <tr onclick='addWeintoCard(<?php echo json_encode($wein); ?>)'>
            <th scope="row"><?php echo $wein->getId() ?></th>
            <td><?php echo $wein->getName() ?></td>
            <td><?php echo $wein->getPreis() ?></td>
        </tr>
    <?php } ?>
</table>
<div id="shopping-cart">
    <table id="shopping_cart" class="table">
        <thead>
        <th scope="col"></th>
        <th scope="col">Anzahl</th>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Preis</th>
        </thead>

    </table>
    <button onclick="sendBestellung()">Bestellung abschicken</button>
</div>


</body>
</html>
