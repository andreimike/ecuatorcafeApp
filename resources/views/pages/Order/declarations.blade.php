<style>
    .page-break {
        page-break-after: always;
    }
</style>
@foreach($orders as $order)
    <?php $productInfosArray = json_decode($order['product'], true);?>
    <table border="0" cellpadding="0" cellspacing="0" align="center" style="border: none; width: 100%;">
        <tr style="border: none" border="0">
            <td align="center" border="0" style="border: none; padding: 5px; width: 100%;">
                <p style="text-align: left;">Declaratie de conformitate</p>
                <br>
                <br>
                <p style="text-align: left;">Sc. Top Star Newprod Srl cu sediul in Mioveni str. D.Giurescu Bl P22
                    Tronson
                    A, inregistrata la ORC Arges Cu nr J03/825/2013 CUI RO31883947
                    Declaram pe proprie raspunde ca produsele comerciaizate sunt conforme cu nomele in vigoare, respecta
                    legislatia aferenta produselor comercializate si nu pun in pericol sanatate consumatorului.</p>
                <br>
                <br>
                <table border="1" cellspacing="0" cellpadding="1" align="center">
                    <thead>
                    <tr>
                        <th style="text-align: center;">Produs</th>
                        <th style="text-align: center;">Data Fabricatie</th>
                        <th style="text-align: center;">Data Expirare</th>
                        <th style="text-align: center;">Termen de Valabilitate</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">
                            @foreach($productInfosArray as $productInfo)
                                <p style="text-align: center;">{{$productInfo['product_name']}}</p>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @foreach($productInfosArray as $productInfo)
                                <p style="text-align: center;">{{$productInfo['frying_date']}}</p>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @foreach($productInfosArray as $productInfo)
                                <?php
                                $strdate = $productInfo['frying_date'];
                                $date = DateTime::createFromFormat('Y-m-d', $strdate)->format('d-m-Y');
                                $expDate = date('Y-m-d', strtotime($date . ' + 12 months'));
                                ?>
                                <p style="text-align: center;">{{$expDate}}</p>
                            @endforeach
                        </td>
                        <td class="text-center">
                            <p style="text-align: center;">
                                12 Luni
                            </p>
                            <p style="text-align: center;">
                                12 Luni
                            </p>
                            <p style="text-align: center;">
                                12 Luni
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" align="center" style="border: none;">
                    <tbody>
                    <tr style="border: none" border="0">
                        <td align="center" border="0" style="border: none; padding-top: 30px; padding-bottom: 30px;">
                            <p style="text-align: center;">Referitor la Avizul cu nr.__{{$order->serial_number}}__ Seria RATSNP.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" align="left"
                       style="border: none; float: left; clear: right; height: 200px; vertical-align: top;">
                    <tbody>
                    <tr style="border: none" border="0">
                        <td align="left" border="0"
                            style="border: none; padding-top: 10px; padding-bottom: 10px; padding-left: 50px; width: 200px; height: 200px; vertical-align: top;">
                            <p style="text-align: left;">Data <br>
                                {{date('d-m-Y')}}
                            </p>
                        </td>
                        <td align="left" border="0"
                            style="border: none; padding-top: 10px; padding-bottom: 10px; padding-right: 50px; width: 200px; height: 200px; vertical-align: top;">
                            <p style="text-align: left;">Administrator, <br>
                                Mitran Alexandru</p>
                            <img src="https://ecuatorcafe.ro/wp-content/uploads/2018/10/PastedGraphic-2.jpg" align="Stampila si Semnatura"
                                 style="width: 100px; height: auto; display: block;"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <div class="page-break"></div>
@endforeach
