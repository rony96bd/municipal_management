<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('developers.png') }}" type="image/x-icon">
    <title>Developers Doc (CSS) - Forayeji Creative Agency</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Parkinsans:wght@300..800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Tiro+Bangla:ital@0;1&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            border-radius: 0;
            outline: none;
            box-sizing: border-box;
            border: none;
            box-shadow: none;
            text-decoration: none;
            text-transform: none;
        }

        :root {
            --black: #000000;
            --white: #ffffff;
            --gray: #dddddd6b;
        }

        body {
            font-family: "Parkinsans", sans-serif;
            font-optical-sizing: auto;
            font-weight: <weight>;
            font-style: normal;
            background: var(--gray);
            color: var(--black);
            font-size: clamp(16px, 1.2vw, 20px);
        }

        h1 {
            font-size: clamp(32px, 4.1vw, 80px);
            width: 100%;
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .containner {
            width: 100%;
            max-width: 1280px;
            padding: 4%;
            background: var(--white);
            border-radius: 12px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        th,
        td {
            padding: 5px 12px;
            /* Removes extra padding */
            margin: 0;
            /* Removes extra margin */
            border: none;
            /* Removes borders */
            text-align: left;
        }

        thead tr {
            padding: 5px 10px;
            background: var(--black);
            color: var(--white);
        }

        th {
            text-align: left;
            font-weight: 400;
        }
        tbody{
            font-size: 16px;
        }
         th {
            background-color: #1e2a36;
            color: #ff9f00;
        }

        tr:nth-child(even) {
            background-color: #1f2a36;
        }

        tr:nth-child(odd) {
            background-color: #263441;
        }

        td {
            color: #d1d1d1;
        }

        td:first-child {
            color: #c5d7e0;
        }

        td:nth-child(02) {
            color: #ff79c6;
        }

        /* Add hover effect for rows */
        tr:hover {
            background-color: #3a4c5a;
        }
        button {
            width: 100%;
            padding: 5px;
            border-radius: 3px;
            background: #041204;
            color: white;
            cursor: pointer;
            transition: .2s all ease-in-out;
        }
        button:hover{
            background: red;
        }
        .css-group-name{
            font-size: 18px;
            color: var(--white)!important;
            font-style: italic;
            text-transform: uppercase;
            font-weight: 600;
            background: #041204;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="section">
        <div class="containner">
            <h1 class="heading1">Class List with Property</h1>
            <table>
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>CSS Property</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="3" class="css-group-name">Color Variables</td></tr>
                    <tr>
                        <td>--primary-color</td>
                        <td>#3498db;</td>
                        <td><button onclick="copyClass('var(--primary-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--secondary-color</td>
                        <td>#2ecc71;</td>
                        <td><button onclick="copyClass('var(--secondary-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--paragraph-color</td>
                        <td>#333333;</td>
                        <td><button onclick="copyClass('var(--paragraph-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--link-color</td>
                        <td>var(--primary-color);</td>
                        <td><button onclick="copyClass('var(--link-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--button-color</td>
                        <td>var(--primary-color);</td>
                        <td><button onclick="copyClass('var(--button-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--danger-color</td>
                        <td>#e74c3c;</td>
                        <td><button onclick="copyClass('var(--danger-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--alert-color</td>
                        <td>#f39c12;</td>
                        <td><button onclick="copyClass('var(--alert-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--success-color</td>
                        <td>#2ecc71;</td>
                        <td><button onclick="copyClass('var(--success-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--warning-color</td>
                        <td>#f39c12;</td>
                        <td><button onclick="copyClass('var(--warning-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--black-color</td>
                        <td>#000000;</td>
                        <td><button onclick="copyClass('var(--black-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>--white-color</td>
                        <td>#ffffff;</td>
                        <td><button onclick="copyClass('var(--white-color)')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.fs-base</td>
                        <td>font-size: 16px;</td>
                        <td><button onclick="copyClass('fs-base')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.fs-16-20</td>
                        <td>font-size: clamp(16px, 1.1vw, 20px);</td>
                        <td><button onclick="copyClass('fs-16-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.fs-24-32</td>
                        <td>font-size: clamp(24px, 1.7vw, 32px);</td>
                        <td><button onclick="copyClass('fs-24-32')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.fs-32-42</td>
                        <td>font-size: clamp(32px, 2.1875vw, 42px);</td>
                        <td><button onclick="copyClass('fs-32-42')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.fs-34-55</td>
                        <td>font-size: clamp(37px, 2.88vw, 55px);</td>
                        <td><button onclick="copyClass('fs-34-55')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.fs-40-60</td>
                        <td>font-size: clamp(40px, 3.125vw, 60px);</td>
                        <td><button onclick="copyClass('fs-40-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.fs-32-80</td>
                        <td>font-size: clamp(32px, 4.17vw, 80px);</td>
                        <td><button onclick="copyClass('fs-32-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.section</td>
                        <td>display: flex; flex-direction: column; justify-content: center; align-items: center;</td>
                        <td><button onclick="copyClass('section')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.containner</td>
                        <td>max-width: 1240px; width: 100%;</td>
                        <td><button onclick="copyClass('containner')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.flex</td>
                        <td>display: flex;</td>
                        <td><button onclick="copyClass('flex')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.row</td>
                        <td>flex-direction: row;</td>
                        <td><button onclick="copyClass('row')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.column</td>
                        <td>flex-direction: column;</td>
                        <td><button onclick="copyClass('column')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.wrap</td>
                        <td>flex-wrap: wrap;</td>
                        <td><button onclick="copyClass('wrap')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.center</td>
                        <td>justify-content: center; align-items: center;</td>
                        <td><button onclick="copyClass('center')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jcc-ais</td>
                        <td>justify-content: center; align-items: flex-start;</td>
                        <td><button onclick="copyClass('jcc-ais')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jcc-aie</td>
                        <td>justify-content: center; align-items: flex-end;</td>
                        <td><button onclick="copyClass('jcc-aie')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jcc-ace</td>
                        <td>justify-content: center; align-items: center;</td>
                        <td><button onclick="copyClass('jcc-ace')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jcc-ast</td>
                        <td>justify-content: center; align-items: stretch;</td>
                        <td><button onclick="copyClass('jcc-ast')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jsb-ais</td>
                        <td>justify-content: space-between; align-items: flex-start;</td>
                        <td><button onclick="copyClass('jsb-ais')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jsb-aie</td>
                        <td>justify-content: space-between; align-items: flex-end;</td>
                        <td><button onclick="copyClass('jsb-aie')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jsb-ace</td>
                        <td>justify-content: space-between; align-items: center;</td>
                        <td><button onclick="copyClass('jsb-ace')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jsb-ast</td>
                        <td>justify-content: space-between; align-items: stretch;</td>
                        <td><button onclick="copyClass('jsb-ast')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jst-ais</td>
                        <td>justify-content: stretch; align-items: flex-start;</td>
                        <td><button onclick="copyClass('jst-ais')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jst-aie</td>
                        <td>justify-content: stretch; align-items: flex-end;</td>
                        <td><button onclick="copyClass('jst-aie')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jst-ace</td>
                        <td>justify-content: stretch; align-items: center;</td>
                        <td><button onclick="copyClass('jst-ace')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.jst-ast</td>
                        <td>justify-content: stretch; align-items: stretch;</td>
                        <td><button onclick="copyClass('jst-ast')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.grid</td>
                        <td>display: grid;</td>
                        <td><button onclick="copyClass('grid')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-1</td>
                        <td>grid-template-columns: repeat(1, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-1')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-2</td>
                        <td>grid-template-columns: repeat(2, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-2')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-3</td>
                        <td>grid-template-columns: repeat(3, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-3')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-4</td>
                        <td>grid-template-columns: repeat(4, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-4')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-5</td>
                        <td>grid-template-columns: repeat(5, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-6</td>
                        <td>grid-template-columns: repeat(6, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-6')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-7</td>
                        <td>grid-template-columns: repeat(7, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-7')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-8</td>
                        <td>grid-template-columns: repeat(8, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-8')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-9</td>
                        <td>grid-template-columns: repeat(9, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-9')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.grid-col-10</td>
                        <td> grid-template-columns: repeat(10, minmax(100px, 1fr));</td>
                        <td><button onclick="copyClass('grid-col-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <!-- Row Gap Classes -->
                    <tr>
                        <td>.rg-5</td>
                        <td>row-gap: 5px;</td>
                        <td><button onclick="copyClass('rg-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-10</td>
                        <td>row-gap: 10px;</td>
                        <td><button onclick="copyClass('rg-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-20</td>
                        <td>row-gap: 20px;</td>
                        <td><button onclick="copyClass('rg-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-30</td>
                        <td>row-gap: 30px;</td>
                        <td><button onclick="copyClass('rg-30')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-40</td>
                        <td>row-gap: 40px;</td>
                        <td><button onclick="copyClass('rg-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-50</td>
                        <td>row-gap: 50px;</td>
                        <td><button onclick="copyClass('rg-50')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-60</td>
                        <td>row-gap: 60px;</td>
                        <td><button onclick="copyClass('rg-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-70</td>
                        <td>row-gap: 70px;</td>
                        <td><button onclick="copyClass('rg-70')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-80</td>
                        <td>row-gap: 80px;</td>
                        <td><button onclick="copyClass('rg-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-90</td>
                        <td>row-gap: 90px;</td>
                        <td><button onclick="copyClass('rg-90')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.rg-100</td>
                        <td>row-gap: 100px;</td>
                        <td><button onclick="copyClass('rg-100')">Copy</button></td>
                    </tr>
                    <!-- Column Gap Classes -->
                    <tr>
                        <td>.cg-5</td>
                        <td>column-gap: 5px;</td>
                        <td><button onclick="copyClass('cg-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-10</td>
                        <td>column-gap: 10px;</td>
                        <td><button onclick="copyClass('cg-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-20</td>
                        <td>column-gap: 20px;</td>
                        <td><button onclick="copyClass('cg-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-30</td>
                        <td>column-gap: 30px;</td>
                        <td><button onclick="copyClass('cg-30')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-40</td>
                        <td>column-gap: 40px;</td>
                        <td><button onclick="copyClass('cg-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-50</td>
                        <td>column-gap: 50px;</td>
                        <td><button onclick="copyClass('cg-50')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-60</td>
                        <td>column-gap: 60px;</td>
                        <td><button onclick="copyClass('cg-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-70</td>
                        <td>column-gap: 70px;</td>
                        <td><button onclick="copyClass('cg-70')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-80</td>
                        <td>column-gap: 80px;</td>
                        <td><button onclick="copyClass('cg-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-90</td>
                        <td>column-gap: 90px;</td>
                        <td><button onclick="copyClass('cg-90')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.cg-100</td>
                        <td>column-gap: 100px;</td>
                        <td><button onclick="copyClass('cg-100')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.container-1120px</td>
                        <td>max-width: 1120px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1120px')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.container-1240px</td>
                        <td>max-width: 1240px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1240px')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.container-1340px</td>
                        <td>max-width: 1340px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1340px')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.container-1440px</td>
                        <td>max-width: 1440px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1440px')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.container-1540px</td>
                        <td>max-width: 1540px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1540px')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.container-1640px</td>
                        <td>max-width: 1640px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1640px')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.container-1920px</td>
                        <td>max-width: 1920px; width: 100%;</td>
                        <td><button onclick="copyClass('container-1920px')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.pt-5</td>
                        <td>padding-top: 5px;</td>
                        <td><button onclick="copyClass('pt-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pb-5</td>
                        <td>padding-bottom: 5px;</td>
                        <td><button onclick="copyClass('pb-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pl-5</td>
                        <td>padding-left: 5px;</td>
                        <td><button onclick="copyClass('pl-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pr-5</td>
                        <td>padding-right: 5px;</td>
                        <td><button onclick="copyClass('pr-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.p-5</td>
                        <td>padding: 5px;</td>
                        <td><button onclick="copyClass('p-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pt-10</td>
                        <td>padding-top: 10px;</td>
                        <td><button onclick="copyClass('pt-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pb-10</td>
                        <td>padding-bottom: 10px;</td>
                        <td><button onclick="copyClass('pb-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pl-10</td>
                        <td>padding-left: 10px;</td>
                        <td><button onclick="copyClass('pl-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pr-10</td>
                        <td>padding-right: 10px;</td>
                        <td><button onclick="copyClass('pr-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.p-10</td>
                        <td>padding: 10px;</td>
                        <td><button onclick="copyClass('p-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pt-20</td>
                        <td>padding-top: 20px;</td>
                        <td><button onclick="copyClass('pt-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pb-20</td>
                        <td>padding-bottom: 20px;</td>
                        <td><button onclick="copyClass('pb-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pl-20</td>
                        <td>padding-left: 20px;</td>
                        <td><button onclick="copyClass('pl-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pr-20</td>
                        <td>padding-right: 20px;</td>
                        <td><button onclick="copyClass('pr-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.p-20</td>
                        <td>padding: 20px;</td>
                        <td><button onclick="copyClass('p-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pt-40</td>
                        <td>padding-top: 40px;</td>
                        <td><button onclick="copyClass('pt-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pb-40</td>
                        <td>padding-bottom: 40px;</td>
                        <td><button onclick="copyClass('pb-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pl-40</td>
                        <td>padding-left: 40px;</td>
                        <td><button onclick="copyClass('pl-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pr-40</td>
                        <td>padding-right: 40px;</td>
                        <td><button onclick="copyClass('pr-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.p-40</td>
                        <td>padding: 40px;</td>
                        <td><button onclick="copyClass('p-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pt-60</td>
                        <td>padding-top: 60px;</td>
                        <td><button onclick="copyClass('pt-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pb-60</td>
                        <td>padding-bottom: 60px;</td>
                        <td><button onclick="copyClass('pb-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pl-60</td>
                        <td>padding-left: 60px;</td>
                        <td><button onclick="copyClass('pl-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pr-60</td>
                        <td>padding-right: 60px;</td>
                        <td><button onclick="copyClass('pr-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.p-60</td>
                        <td>padding: 60px;</td>
                        <td><button onclick="copyClass('p-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pt-80</td>
                        <td>padding-top: 80px;</td>
                        <td><button onclick="copyClass('pt-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pb-80</td>
                        <td>padding-bottom: 80px;</td>
                        <td><button onclick="copyClass('pb-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pl-80</td>
                        <td>padding-left: 80px;</td>
                        <td><button onclick="copyClass('pl-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.pr-80</td>
                        <td>padding-right: 80px;</td>
                        <td><button onclick="copyClass('pr-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.p-80</td>
                        <td>padding: 80px;</td>
                        <td><button onclick="copyClass('p-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.mt-5</td>
                        <td>margin-top: 5px;</td>
                        <td><button onclick="copyClass('mt-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mb-5</td>
                        <td>margin-bottom: 5px;</td>
                        <td><button onclick="copyClass('mb-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.ml-5</td>
                        <td>margin-left: 5px;</td>
                        <td><button onclick="copyClass('ml-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mr-5</td>
                        <td>margin-right: 5px;</td>
                        <td><button onclick="copyClass('mr-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.m-5</td>
                        <td>margin: 5px;</td>
                        <td><button onclick="copyClass('m-5')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mt-10</td>
                        <td>margin-top: 10px;</td>
                        <td><button onclick="copyClass('mt-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mb-10</td>
                        <td>margin-bottom: 10px;</td>
                        <td><button onclick="copyClass('mb-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.ml-10</td>
                        <td>margin-left: 10px;</td>
                        <td><button onclick="copyClass('ml-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mr-10</td>
                        <td>margin-right: 10px;</td>
                        <td><button onclick="copyClass('mr-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.m-10</td>
                        <td>margin: 10px;</td>
                        <td><button onclick="copyClass('m-10')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mt-20</td>
                        <td>margin-top: 20px;</td>
                        <td><button onclick="copyClass('mt-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mb-20</td>
                        <td>margin-bottom: 20px;</td>
                        <td><button onclick="copyClass('mb-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.ml-20</td>
                        <td>margin-left: 20px;</td>
                        <td><button onclick="copyClass('ml-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mr-20</td>
                        <td>margin-right: 20px;</td>
                        <td><button onclick="copyClass('mr-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.m-20</td>
                        <td>margin: 20px;</td>
                        <td><button onclick="copyClass('m-20')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mt-40</td>
                        <td>margin-top: 40px;</td>
                        <td><button onclick="copyClass('mt-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mb-40</td>
                        <td>margin-bottom: 40px;</td>
                        <td><button onclick="copyClass('mb-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.ml-40</td>
                        <td>margin-left: 40px;</td>
                        <td><button onclick="copyClass('ml-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mr-40</td>
                        <td>margin-right: 40px;</td>
                        <td><button onclick="copyClass('mr-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.m-40</td>
                        <td>margin: 40px;</td>
                        <td><button onclick="copyClass('m-40')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mt-60</td>
                        <td>margin-top: 60px;</td>
                        <td><button onclick="copyClass('mt-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mb-60</td>
                        <td>margin-bottom: 60px;</td>
                        <td><button onclick="copyClass('mb-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.ml-60</td>
                        <td>margin-left: 60px;</td>
                        <td><button onclick="copyClass('ml-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mr-60</td>
                        <td>margin-right: 60px;</td>
                        <td><button onclick="copyClass('mr-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.m-60</td>
                        <td>margin: 60px;</td>
                        <td><button onclick="copyClass('m-60')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mt-80</td>
                        <td>margin-top: 80px;</td>
                        <td><button onclick="copyClass('mt-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mb-80</td>
                        <td>margin-bottom: 80px;</td>
                        <td><button onclick="copyClass('mb-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.ml-80</td>
                        <td>margin-left: 80px;</td>
                        <td><button onclick="copyClass('ml-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.mr-80</td>
                        <td>margin-right: 80px;</td>
                        <td><button onclick="copyClass('mr-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.m-80</td>
                        <td>margin: 80px;</td>
                        <td><button onclick="copyClass('m-80')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.color-primary</td>
                        <td>color: --primary-color;</td>
                        <td><button onclick="copyClass('color-primary')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-secondary</td>
                        <td>color: --secondary-color;</td>
                        <td><button onclick="copyClass('color-secondary')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-paragraph</td>
                        <td>color: --paragraph-color;</td>
                        <td><button onclick="copyClass('color-paragraph')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-link</td>
                        <td>color: --link-color;</td>
                        <td><button onclick="copyClass('color-link')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-button</td>
                        <td>color: --button-color;</td>
                        <td><button onclick="copyClass('color-button')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-danger</td>
                        <td>color: --danger-color;</td>
                        <td><button onclick="copyClass('color-danger')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-alert</td>
                        <td>color: --alert-color;</td>
                        <td><button onclick="copyClass('color-alert')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-success</td>
                        <td>color: --success-color;</td>
                        <td><button onclick="copyClass('color-success')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-warning</td>
                        <td>color: --warning-color;</td>
                        <td><button onclick="copyClass('color-warning')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-black</td>
                        <td>color: --black-color;</td>
                        <td><button onclick="copyClass('color-black')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.color-white</td>
                        <td>color: --white-color;</td>
                        <td><button onclick="copyClass('color-white')">Copy</button></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <th>Value</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td>.background-primary</td>
                        <td>background-color: --primary-color;</td>
                        <td><button onclick="copyClass('background-primary')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-secondary</td>
                        <td>background-color: --secondary-color;</td>
                        <td><button onclick="copyClass('background-secondary')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-paragraph</td>
                        <td>background-color: --paragraph-color;</td>
                        <td><button onclick="copyClass('background-paragraph')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-link</td>
                        <td>background-color: --link-color;</td>
                        <td><button onclick="copyClass('background-link')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-button</td>
                        <td>background-color: --button-color;</td>
                        <td><button onclick="copyClass('background-button')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-danger</td>
                        <td>background-color: --danger-color;</td>
                        <td><button onclick="copyClass('background-danger')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-alert</td>
                        <td>background-color: --alert-color;</td>
                        <td><button onclick="copyClass('background-alert')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-success</td>
                        <td>background-color: --success-color;</td>
                        <td><button onclick="copyClass('background-success')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-warning</td>
                        <td>background-color: --warning-color;</td>
                        <td><button onclick="copyClass('background-warning')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-black</td>
                        <td>background-color: --black-color;</td>
                        <td><button onclick="copyClass('background-black')">Copy</button></td>
                    </tr>
                    <tr>
                        <td>.background-white</td>
                        <td>background-color: --white-color;</td>
                        <td><button onclick="copyClass('background-white')">Copy</button></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </section>
    <script>
        function copyClass(className) {
            navigator.clipboard.writeText(className).then(() => {
                alert("Class copied to clipboard: " + className);
            });
        }
    </script>

</body>

</html>
