<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        body
        {
            background-color: black;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        .container
        {
            position:absolute;
            left:2rem;
            top:2rem;
        }
        button
        {
            position: relative;
            left: 0;
        }     
    </style>
</head>
<body>
    <div class="container">
        <?php
            if($data)
            {
                foreach($data as $row)
                {
                    echo "Product Name: ". $row["productName"] ."<br><br>";
                    echo "Product Price: " .$row["price"] ."<br><br>";
                    echo "Product Quantity: " .$row["quantity"] ."<br><br>";
                }
            }
        ?>
        <form action='/uploadCart?id=<?php echo $id;?>' method="POST">
            <input type="int" name="quantity" required placeholder="No of items needed"><br>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
