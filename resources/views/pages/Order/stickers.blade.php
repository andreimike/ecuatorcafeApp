<style>
    .page-break {
        page-break-after: always;
    }
</style>

@foreach($completeStickersArray as $orderInfos)
    @foreach($orderInfos as $orderInfo)
        <table border="0" cellpadding="10" cellspacing="10" valign="top" align="center"
               style="vertical-align: top; margin: 0 auto;">
            <tr style="border: none;" border="0">
                <td align="center" style="padding: 0px; vertical-align: top; width: 100%; max-width: 595px !important;">
                    <table border="0" cellpadding="10" cellspacing="10" align="center" style="border: none;">
                        <tbody>
                        <tr style="border: none;" border="0">
                            <td align="center" border="0"
                                style="border: none; margin-top: 10px !important; margin-bottom: 10px !important; height: 15%;">
                                <img src="https://ecuatorcafe.ro/wp-content/uploads/2018/10/Logo-EcuatorCafeEdited.jpg"
                                     style="width: 150px; height: auto !important; margin: 10px;" width="150"/>
                            </td>
                        </tr>
                        <tr style="border: none;" border="0">
                            <td align="center" border="0"
                                style="border: none; margin-top: 10px !important; margin-bottom: 10px !important; height: 15%;">
                                <img src="https://ecuatorcafe.ro/wp-content/uploads/2019/01/ecuator_barcode.jpg"
                                     style="width: 220px; height: auto !important; margin: 10px;" width="220"/>
                            </td>
                        </tr>
                        <tr style="border: none" border="0">
                            <td align="center" border="0"
                                style="border: none; margin-top: 1px !important; margin-bottom: 40px !important; text-align: center; height: 14%;">
                                <p>Nume Produs: <b>{{$orderInfo['product_name']}}</b></p>
                                <p>
                                    Data Prajire: <b>{{$orderInfo['frying_date']}}</b>
                                </p>
                            </td>
                        </tr>
                        <tr style="border: none" border="0">
                            <td align="center" border="0"
                                style="border: none; margin-top: 10px !important; margin-bottom: 10px !important; text-align: center; height: 3%;">
                                &nbsp;
                            </td>
                        </tr>
                        <tr style="border: none;" border="0">
                            <td align="center" border="0"
                                style="border: none; margin-top: 30px !important; margin-bottom: 1px !important; height: 25%; vertical-align: center;">
                                <img src="https://ecuatorcafe.ro/wp-content/uploads/2019/01/ecuator_barcode.jpg"
                                     style="width: 220px; height: auto !important; margin: 10px;" width="220"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <div class="page-break"></div>
        @if($orderInfo['number_of_pages'] > 1)
            @for($i = 1; $i < $orderInfo['number_of_pages']; $i++)
                <table border="0" cellpadding="0" cellspacing="0" align="center"
                       style="border: none; width: 100%;margin: 0 auto;">
                    <tr style="border: none;" border="0">
                        <td align="center" border="0" style="border: none; padding: 5px; width: 100%;">
                            <table border="0" cellpadding="10" cellspacing="10" align="center" style="border: none;">
                                <tbody>
                                <tr style="border: none;" border="0">
                                    <td align="center" border="0"
                                        style="border: none; margin-top: 10px !important; margin-bottom: 10px !important;">
                                        <img src="https://ecuatorcafe.ro/wp-content/uploads/2018/10/Logo-EcuatorCafeEdited.jpg"
                                             style="width: 150px; height: auto !important; margin: 10px;" width="150"/>
                                    </td>
                                </tr>
                                <tr style="border: none;" border="0">
                                    <td align="center" border="0"
                                        style="border: none; margin-top: 10px !important; margin-bottom: 10px !important;">
                                        <img src="https://ecuatorcafe.ro/wp-content/uploads/2019/01/ecuator_barcode.jpg"
                                             style="width: 220px; height: auto !important; margin: 10px;" width="220"/>
                                    </td>
                                </tr>
                                <tr style="border: none" border="0">
                                    <td align="center" border="0"
                                        style="border: none; margin-top: 1px !important; margin-bottom: 1px !important; text-align: center">
                                        <p>Nume Produs: <b>{{$orderInfo['product_name']}}</b></p>
                                    </td>
                                </tr>
                                <tr style="border: none" border="0">
                                    <td align="center" border="0"
                                        style="border: none; margin-top: 1px !important; margin-bottom: 1px !important; text-align: center;">
                                        <p>
                                            Data Prajire: <b>{{$orderInfo['frying_date']}}</b>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="page-break"></div>
            @endfor
        @endif

    @endforeach
@endforeach
