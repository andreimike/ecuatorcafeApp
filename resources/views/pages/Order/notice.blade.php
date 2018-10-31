<table border="0" cellpadding="0" cellspacing="0" valign="top" align="center"
       style="vertical-align: top; margin: 0 auto;">
    <tr style="border: none">
        <td align="center" style="padding: 5px; vertical-align: top; width: 100%; max-width: 595px !important;">
            <table border="0" align="center"
                   style="vertical-align: top; width: 100%; border-bottom: 2px solid #000000;">
                <tr>
                    <td align="left"
                        style="border: none; padding: 5px; vertical-align: middle;">
                        <img src="https://ecuatorcafe.ro/wp-content/uploads/2018/10/Logo-EcuatorCafeEdited.jpg"
                             width="111px" style="width: 111px"/>
                    </td>
                    <td align="right" style="vertical-align: middle;">
                        <h3 style="text-align: right;">AVIZ DE INSOTIRE A MARFII</h3>
                        <hr style="border: 1px solid #000;"/>
                        <p style="text-align: right; padding: 0px !important; margin: 0px !important;">Seria
                            ATSNP nr. {{$order->serial_number}}
                        </p>
                        <p style="text-align: right; padding: 0px !important; margin: 0px !important;">Data
                            (zi/luna/an):
                            {{date('d/m/Y')}}</p>
                        <p style="text-align: right; padding: 0px !important; margin: 0px !important;">Cota
                            TVA: 9%</p>
                    </td>
                </tr>
            </table>
            <table border="0" align="center"
                   style="vertical-align: top; width: 100%; margin-top: 5px; margin-bottom: 5px;">
                <tr>
                    <td align="left"
                        style="border: none; vertical-align: top;">
                        <p style="text-align: left; padding: 0; margin: 0;">
                            <b>TOP STAR NEWPROD</b></p>
                        <p style="text-align: left; padding: 0; margin: 0;">Reg. com.: J03/825/2013</p>
                        <p style="text-align: left; padding: 0; margin: 0;">CIF:RO31883947</p>
                        <p style="text-align: left; padding: 0; margin: 0;">Adresa: COL. D. GIURESCU P22, MIOVENI, Jud.
                            ARGES</p>
                        <p style="text-align: left; padding: 0; margin: 0;">IBAN: RO08INGB0000999904051778</p>
                        <p style="text-align: left; padding: 0; margin: 0;">Banca: ING BANK NV</p>
                        <p style="text-align: left; padding: 0; margin: 0;">Acciza pentu cafea a fost achitata</p>
                    </td>
                    <td align="right" style="vertical-align: top;">
                        <p style="text-align: left; padding: 0; margin: 0;">Client: AUCHAN Romania SA</p>
                        <p style="text-align: left; padding: 0; margin: 0;">Reg. com.: J40/2731/2005</p>
                        <p style="text-align: left; padding: 0; margin: 0;">CIF: RO17233051</p>
                        <p style="text-align: left; padding: 0; margin: 0;">
                            @foreach($orderCustomer as $customerInfo)
                                Adresa: {{$customerInfo->customer->nume}}
                            @endforeach
                        </p>
                        <p style="text-align: left; padding: 0; margin: 0;">Judet: Bucuresti</p>
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" align="center"
                   style="vertical-align: top;">
                <tr>
                    <td align="center">
                        <table border="1" cellspacing="0" cellpadding="1"
                               style="vertical-align: top;">
                            <thead style="vertical-align: middle;">
                            <tr>
                                <th>
                                    <p style="text-align: center;"><b>Nr. crt</b></p>
                                </th>
                                <th>
                                    <p style="text-align: center;"><b>Denumirea produselor sau a serviciilor</b></p>
                                </th>
                                <th>
                                    <p style="text-align: center;"><b>U.M.</b></p>
                                </th>
                                <th>
                                    <p style="text-align: center;"><b>Cant.</b></p>
                                </th>
                                <th>
                                    <p style="text-align: center;"><b>Pret unitar (fara TVA) -Lei-</b></p>
                                </th>
                                <th>
                                    <p style="text-align: center;"><b>Valoarea -Lei-</b></p>
                                </th>
                                <th>
                                    <p style="text-align: center;"><b>Valoarea TVA -Lei-</b></p>
                                </th>
                            </tr>
                            </thead>
                            <tbody style="vertical-align: top;">
                            <tr>
                                <th scope="row" style="text-align: center;">0</th>
                                <td>
                                    <p style="text-align: center; margin: 0px; padding: 0px;">1</p>
                                </td>
                                <td>
                                    <p style="text-align: center; margin: 0px; padding: 0px;">2</p>
                                </td>
                                <td>
                                    <p style="text-align: center; margin: 0px; padding: 0px;">3</p>
                                </td>
                                <td>
                                    <p style="text-align: center; margin: 0px; padding: 0px;">4</p>
                                </td>
                                <td>
                                    <p style="text-align: center; margin: 0px; padding: 0px;">5(3x4)</p>
                                </td>
                                <td>
                                    <p style="text-align: center; margin: 0px; padding: 0px;">6</p>
                                </td>
                            </tr>

                            <?php $productInfosArray = json_decode($order['product'], true); ?>
                            <!-- Order Index Deckaration -->
                            <?php $index = (int)0; ?>
                            <!-- Price Sum Declaration -->
                            <?php $s = (float)0; ?>
                            <!-- Vat Total Sum Declartion -->
                            <?php $sVat = (float)0; ?>
                            @foreach($productInfosArray as $orderInfos)
                                <tr style="border-top: none; border-bottom: none; padding-top: 2px !important; padding-bottom: 2px !important;">
                                    <th scope="row" style="border-top: none; border-bottom: none; text-align: center;">
                                        <?php
                                        $index = $index + 1;
                                        ?>
                                        <p style="text-align: center;">{{$index}}</p>
                                    </th>
                                    <td style="border-top: none; border-bottom: none;">

                                        <p style="text-align: left; text-transform: uppercase;">
                                            {{$orderInfos['product_name']}} {{$orderInfos['product_ean']}}
                                        </p>
                                    </td>
                                    <td style="border-top: none; border-bottom: none;">
                                        <p style="text-align: right; text-transform: uppercase;">BUC</p>
                                    </td>
                                    <td style="border-top: none; border-bottom: none;">
                                        <p style="text-align: right; text-transform: uppercase;">
                                            {{$orderInfos['product_qty']}}
                                        </p>
                                    </td>
                                    <td style="border-top: none; border-bottom: none;">
                                        <p style="text-align: right; text-transform: uppercase;">
                                            <?php $productPrice = (float)$orderInfos['product_price']; ?>
                                            <?php $prodPriceWithoutVat = $productPrice / 1.09; ?>
                                            <?php $truncateProdPriceWithoutVat = round($prodPriceWithoutVat, 2); ?>
                                            {{$truncateProdPriceWithoutVat}}
                                        </p>
                                    </td>
                                    <td style="border-top: none; border-bottom: none;">
                                        <p style="text-align: right; text-transform: uppercase;">
                                            <?php $productQty = (float)$orderInfos['product_qty']; ?>
                                            <?php $productTotalPrice = $productQty * $truncateProdPriceWithoutVat; ?>
                                            <?php $orderArraySize = count($productInfosArray); ?>
                                            <?php $productEan = $orderInfos['product_ean']; ?>
                                            <?php $s = $s + $productTotalPrice; ?>
                                            {{$productTotalPrice}}
                                        </p>
                                    </td>
                                    <td style="border-top: none; border-bottom: none;">
                                        <p style="text-align: right; text-transform: uppercase;">
                                            <?php $vatTotal = $productTotalPrice * 0.09; ?>
                                            <?php $sVat = $sVat + $vatTotal; ?>
                                            {{$vatTotal}}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                            <tr style="border-top: none; border-bottom: none;">
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                                <td style="border-top: none; border-bottom: none;">
                                    &nbsp;
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <table border="1" cellspacing="0" cellpadding="0"
                               style="vertical-align: top; width: 100%;">
                            <tr>
                                <td align="left"
                                    style="width: 100%; border-top: none; border-right: 1px solid #111; border-bottom: none; border-left: 1px solid #111;">
                                    <p style="text-align: left; margin-bottom: 0px; padding-bottom: 0px; padding-left: 2px;">
                                        Cod Furnizor 04195</p>
                                    <p style="text-align: left; padding-top: 0px; margin-top: 0px; padding-left: 2px;">
                                        Numar comanda {{$order->order_number}}</p>
                                </td>
                            </tr>
                        </table>
                        <table border="1" cellspacing="0" cellpadding="0"
                               style="vertical-align: top; width: 100%;">
                            <tr>
                                <td align="left" style="border-top: none; vertical-align: top;">
                                    <img src="https://ecuatorcafe.ro/wp-content/uploads/2018/10/PastedGraphic-2.jpg"
                                         align="Stampila si Semnatura"
                                         style="width: 79px; height: auto; margin-top: 3px;"/>
                                    <small>Semnatura<br>si stampila<br>furnizorului</small>
                                </td>
                                <td align="center" style="border-top: none;">
                                    <p style="text-align: left; margin: 1px; padding: 1px;">Intocmit de: -</p>
                                    <p style="text-align: left; margin: 1px; padding: 1px;">CNP: -</p>
                                    <p style="text-align: left; margin: 1px; padding: 1px;">Numele delegatului:
                                        -</p>
                                    <p style="text-align: left; margin: 1px; padding: 1px;">B.I/C.I: -</p>
                                    <p style="text-align: left; margin: 1px; padding: 1px;">Mijloc transport: -</p>
                                    <p style="text-align: left; margin: 1px; padding: 1px;">Expedierea s-a efectuat
                                        in
                                        prezenta noastra la data de .................... ora.........</p>
                                    <p style="text-align: left; margin: 1px; padding: 1px;">Semnaturile:</p>
                                </td>
                                <td align="right" style="border-top: none;">
                                    <table cellpadding="1" cellspacing="0" border="1"
                                           style="vertical-align: top; width: 100%; border-top: none; border-right: none; border-bottom: none; border-left: none;">
                                        <tr>
                                            <td align="left" style="text-align: left; width: 33.3%;">
                                                Total
                                            </td>
                                            <td align="center" style="text-align: right; width: 33.3%">
                                                {{$s}}
                                            </td>
                                            <td align="right" style="text-align: right; width: 33.3%;">
                                                {{$sVat}}
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellpadding="1" cellspacing="0" border="1"
                                           style="vertical-align: top; width: 100%; border-right: none; border-bottom: none; border-left: none;">
                                        <tr>
                                            <td align="left" style="text-align: left; width: 50%;">
                                                Total plata
                                            </td>
                                            <td align="center" style="text-align: right; width: 50%;">
                                                <?php $orderTotalSum = $s + $sVat ?>
                                                {{$orderTotalSum}}
                                            </td>
                                        </tr>
                                    </table>
                                    <table cellpadding="1" cellspacing="0" border="1"
                                           style="vertical-align: top; width: 100%; border-right: none; border-bottom: none; border-left: none;">
                                        <tr>
                                            <td align="center" style="text-align: left;">
                                                <p>Data primirii in gestiune si semnatura</p>
                                                <br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="text-align: left;">
                                                <p>Semnatura de primire:</p>
                                                <br>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>