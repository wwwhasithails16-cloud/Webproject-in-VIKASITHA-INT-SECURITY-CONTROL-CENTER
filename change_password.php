<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Heritage Barbell Tee</title>
    <style>
        body{
            font-family: Arial, sans-serif;
            margin:0;
            padding:20px;
            background:#f5f5f5;
        }
        .container{
            max-width:1000px;
            margin:auto;
            background:#fff;
            padding:20px;
            display:flex;
            gap:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        .image img{
            width:400px;
            border-radius:10px;
        }
        .details{
            flex:1;
        }
        h1{
            margin-top:0;
        }
        .price{
            color:#d32f2f;
            font-size:28px;
            font-weight:bold;
        }
        select, button{
            width:100%;
            padding:10px;
            margin-top:10px;
        }
        button{
            background:black;
            color:white;
            border:none;
            cursor:pointer;
        }
        button:hover{
            background:#333;
        }
        ul{
            padding-left:20px;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="image">
        <img src="heritage-barbell-tee.jpg" alt="Heritage Barbell Tee">
    </div>

    <div class="details">
        <h1>Heritage Barbell Tee</h1>

        <p class="price">LKR 4,850.00</p>

        <p>
            A premium oversized gym t-shirt designed for comfort and style.
            Perfect for workouts and casual wear.
        </p>

        <label><strong>Color:</strong></label>
        <p>Charcoal Grey</p>

        <label><strong>Select Size:</strong></label>
        <select>
            <option>XS</option>
            <option>S</option>
            <option>M</option>
            <option>L</option>
            <option>XL</option>
            <option>XXL</option>
        </select>

        <button>Add to Cart</button>

        <h3>Product Details</h3>
        <ul>
            <li>100% Cotton</li>
            <li>260 GSM Fabric</li>
            <li>Oversized Unisex Fit</li>
            <li>Premium Screen Print</li>
        </ul>

        <h3>Care Instructions</h3>
        <ul>
            <li>Machine wash cold.</li>
            <li>Wash inside out.</li>
            <li>Do not bleach.</li>
            <li>Line dry in shade.</li>
        </ul>

    </div>

</div>

</body>
</html>