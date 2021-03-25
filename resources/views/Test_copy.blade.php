<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multi-Level Dropdown Menu with Pure CSS - W3jar.Com</title>
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            margin: 0;
            padding: 10px;
        }

        .dropdown {
            margin: 0;
            padding: 0;
            list-style: none;
            width: 100px;
            background-color: #0abf53;
        }

        .dropdown li {
            position: relative;
        }

        .dropdown li a {
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            display: block;
            padding: 10px;
        }

        .dropdown li ul {
            position: absolute;
            top: 100%;
            margin: 0;
            padding: 0;
            list-style: none;
            display: none;
            line-height: normal;
            background-color: #333;
        }

        .dropdown li ul li a {
            text-align: left;
            color: #cccccc;
            font-size: 14px;
            padding: 10px;
            display: block;
            white-space: nowrap;
        }

        .dropdown li ul li a:hover {
            background-color: #0abf53;
            color: #ffffff;
        }

        .dropdown li ul li ul {
            left: 100%;
            top: 0;
        }

        ul li:hover>a {
            background-color: #0abf53;
            color: #ffffff !important;
        }

        ul li:hover>ul {
            display: block;
        }
    </style>
</head>

<body>
    <ul class="dropdown">
        <li><a href="#">Menu</a>
        <li><a href="#">Menu</a>
        <li><a href="#">Menu</a>
        <li><a href="#">Menu</a>
        <li><a href="#">Menu</a>

            <ul>
                <li><a href="">Nice Dropdown Menu</a></li>
                <li><a href="">Submenu - 1</a></li>
                <li><a href="#">Dropdown</a>
                    <ul>
                        <li><a href="">Submenu - 1</a></li>
                        <li><a href="">Submenu - 2</a></li>
                        <li><a href="#">Dropdown</a>
                            <ul>
                                <li><a href="">Submenu - 1</a></li>
                                <li><a href="">Submenu - 2</a></li>
                                <li><a href="">Submenu - 3</a></li>
                            </ul>
                        </li>
                        <li><a href="">Submenu - 3</a></li>
                    </ul>
                </li>
                <li><a href="">Submenu - 2</a></li>
            </ul>
        </li>
    </ul>
</body>

</html>