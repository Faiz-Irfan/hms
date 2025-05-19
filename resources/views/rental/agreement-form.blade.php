<!DOCTYPE html>
<html>

<head>
    <title>Hasta - Rental Agreement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 5px;
        }

        .terms p {
            font-size: 14px;
            text-align: justify;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            /* border: 1px solid #ccc; */
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        /* .company-info {
            margin-bottom: 20px;
        } */

        .company-info img {
            width: 40%;
        }

        .company-details table {
            border: hidden;
        }

        .company-details td {
            border: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        table .table-borderless {
            border: hidden;

        }

        .table-borderless td {
            border: hidden;
        }

        .main-table {
            border: hidden;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: left;
        }

        p {
            font-size: 10px;
        }

        .page_break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <div>
        <div style="font-size: 10px;">
            <table class="main-table" style="width: 700px;">
                <tr>
                    <td style="width: 330px;">
                        <div style="text-align: center; font-style:bold;">RENTAL AGREEMENT</div>
                        <div style="text-align: center;">HASTA TRAVEL & TOURS SDN. BHD. (1359376T)</div>
                        {{-- <div style="text-align: center">202001003057 (1359376T) KPK/LN 10181</div> --}}
                        <div>Invoice No. : {{ $rental->payment->invoice_id }} </div>
                        <div>Model & Plate No. : {{ $rental->fleet->model }} {{ $rental->fleet->license_plate }}</div>
                        <div>Rental Date & Time : {{ $rental->pickup_date }} {{ $rental->pickup_time }} to
                            {{ $rental->return_date }} {{ $rental->return_time }}</div>

                        <div style="font-style: bold; text-align:just">Rates</div>
                        <div style="text-align:justify">
                            Rental rates are charged for a minimum of 1-hour RM30. Rental with more than 12
                            hours will be considered as 1-day rental. Extended hours will be calculated at a fixed
                            rate based on Table 1. Rates include maximum mileage of 100 km for 1-day rental,
                            200 km for 2-day rental, and unlimited mileage for rentals exceeding 3 days and
                            replace car breakdown (if car got problem on road because of car maintenance only).
                            Rates are in Ringgit Malaysia (RM).
                        </div>

                        {{-- <table>
                            <div style="text-align: right">Table 1: Price List Hasta</div>
                            <tr>
                                <th>HOUR</th>
                                <th>1</th>
                                <th>3</th>
                                <th>5</th>
                                <th>7</th>
                                <th>9</th>
                                <th>12</th>
                                <th>24</th>
                            </tr>
                            <tr>
                                <th>RATE (RM)</th>
                                <td>30</td>
                                <td>50</td>
                                <td>60</td>
                                <td>65</td>
                                <td>70</td>
                                <td>80</td>
                                <td>110</td>
                            </tr>
                        </table> --}}

                        <div style="font-style: bold">Driver's Age and License Requirements</div>
                        <div style="text-align:justify">
                            The driver must be between 19 to 55 years old for all car category vehicles and in
                            possession of a valid national or International Driving License. Probational license
                            holders will not be accepted.
                        </div>

                        <div style="font-style: bold">Terms of Payment & Deposit</div>
                        <div style="text-align:justify">
                            All rentals are subjected to a compulsory deposit of RM50.00 per car with maximum
                            rental of 5 days. For weekly rental deposit will be RM150.00 and for one month is
                            equal to one month rental. Our company only accepts the online payment for
                            deposits and rental. Cash is accepted as mode of payment at the counter. Refundable
                            deposit depends on return car condition (fuel, late return, extend and accident).
                        </div>
                        <div style="text-align:justify">
                            <div style="font-style: bold">Cancellation Policy</div>
                            Cancellation can be made 24 hours before the rental. After 24 hours, all paid rental
                            and deposit cannot be cancelled, and payments made are non-refundable.
                        </div>
                        <div style="text-align:justify">

                            <div style="font-style: bold">Excess Fee for Car Damages </div>
                            The renter shall be held responsible for accidental damage to third party property
                            and bodily injuries. However, the renter is always responsible for an amount
                            equivalent to the excess fee based on Table 2. A full responsible will be on the renter
                            for damage as a result of illegal, negligence, careless actions, tyre punctures, bust
                            tyre, scratches and dent, lack of battery power because of forgotten turned off car
                            electrical devices, loss or damage to the vehicle and vehicle accessories and
                            damages of windows, mirror and undercarriage. In the event of any accident, the
                            renter must agree to accept the Excess Fee and inform our company first before
                            taking any action and make a police report within 24 hours from the time of the
                            accident or theft. Our company shall be entitled to charge the renter a maximum
                            amount of excess fee which is in accordance with the following Table 2. Upon the
                            renter's acceptance and subject to the terms and conditions stipulated in the Rental
                            Agreement, the renter's liability is limited to the Excess Fee. Excess Fee is used to
                            cover loss of company sales for that particular car while repairing. Any extra charge
                            of the repairing cost will be added if needed by the company. Receipt of any
                            additional cost will be given to the customer.
                        </div>

                        <table>
                            <div style="text-align: right">Table 2: Car Damages Excess Fee</div>
                            <tr>
                                <th>Types Of Car</th>
                                <th>Excess Fee (RM)</th>
                            </tr>
                            <tr>
                                <td>PERODUA AXIA, MYVI, SAGA, BEZZA</td>
                                <td>3,000</td>
                            </tr>
                            <tr>
                                <td>PERODUA ALZA/ MPV</td>
                                <td>3,500</td>
                            </tr>
                        </table>
                        <table>
                            <div style="text-align: right">Table 3: Total Loss Excess Fee</div>
                            <tr>
                                <th>Types Of Car</th>
                                <th>Excess Fee (RM)</th>
                            </tr>
                            <tr>
                                <td>PERODUA AXIA, MYVI, SAGA, BEZZA</td>
                                <td>5,000</td>
                            </tr>
                            <tr>
                                <td>PERODUA ALZA/ MPV</td>
                                <td>7,000</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 300px;">
                        <div style="font-style: bold">Fuel</div>
                        <div style="text-align:justify">
                            Our company does not provide a full tank unless requested by the renter and must
                            be returned the same fuel level. Otherwise, the renter will be charged based on 1 bar
                            RM10.
                        </div>
                        <div style="font-style: bold">Late Return Penalty</div>
                        <div style="text-align:justify">
                            The car needs to be returned on or before the agreed time as stated in the agreement
                            form. A grace period of up to 10 minutes is allowed. For returns exceeding this
                            period, a charge of RM30 per hour will apply.
                        </div>
                        <div style="font-style: bold">Parking Fees and Traffic Fines</div>
                        <div style="text-align:justify">
                            The renter is liable for all parking and traffic fines incurred for the duration of the
                            rental. An additional RM20 administration fee will be charged to the renter over and
                            above any fine and penalty cost for any violation arising from the renter's use of
                            vehicle. Our company retains the right to charge against the renter's charge if and
                            when payment is due for traffic fines committed by the renter, upon receiving
                            notification from the government authorities.
                        </div>
                        <div style="font-style: bold">Vehicle Condition & Cleanliness </div>
                        <div style="text-align:justify">
                            Upon return, the car must be in the same condition as when it was rented. Failing
                            which, the renter will be liable for the cost of restoring the vehicle to its original
                            condition and loss of company sales for that particular car.
                        </div>

                        <div style="font-style: bold">Surcharge</div>
                        If customers car delivery to their preferred location (subject to staff availability) or
                        want to make reservations after operating hours, the applicable fees are detailed in
                        Table 4 and must be paid directly to the staff in charge.
                        <table style="font-size: 8px">
                            <div style="text-align: right">Table 4: Surcharge Fee</div>
                            <tr>
                                <th>Time</th>
                                <th>Fee (RM)</th>
                            </tr>
                            <tr>
                                <td>5.01pm - 8.00pm</td>
                                <td>7</td>
                            </tr>
                            <tr>
                                <td>8.01pm - 12.00am</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <td>12.01am - 7.59am</td>
                                <td>15</td>
                            </tr>
                        </table>

                        <div style="font-style: bold">Restricted Entry</div>
                        The vehicles cannot be driven into Singapore, Thailand, Brunei and Indonesia.
                        Subsequently the vehicles are prohibited from being loaded onto other modes of
                        transportation via sea, river and air for usage from mainland to Langkawi, Tioman,
                        Redang, Pangkor island etc.
                        <div style="font-style: bold">Prohibited Odors</div>
                        All items and goods discharging unpleasant odors are strictly forbidden from being
                        carried in the vehicle (e.g. Durians, salted fish etc). The renter will be liable to
                        reimburse on demand for all costs of eliminating such odors, including the servicing
                        of the whole air conditioner system and the loss of rental days. Please be advised
                        that smoking in vehicles is strictly prohibited.
                        <div style="font-style: bold">Limitation Destination</div>
                        For rentals of less than 1 day, customers are restricted to Johor Bahru area only. For
                        1-day rentals, usage is limited to within the state of Johor. Rentals outside the state
                        of Johor require a minimum rental period of 2 days. Failure to comply with these
                        restrictions will result in a penalty of an additional 1-day rental fee, and the security
                        deposit will be forfeited.

                        <div>
                            <p style="font-size: 10px">I have read Terms & Conditions of this agreement and agree here
                                to
                            </p>
                            <br><br>
                            <h4>__________________________</h4>
                            ({{ $rental->customer->name }})

                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
