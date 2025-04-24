<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart List</title>
    <style>
        body {
            background-color: black;
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid white;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: grey;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
        }

        button {
            margin: .2em;
        }
    </style>
</head>
<body>
    <h1>Cart List</h1>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Total Price</th>
            <th>Operations</th>
        </tr>
        <?php
        if ($data)
        {
            foreach($data as $row)
            {
                $cartID = $row['id'];
                $productID = $row['productID'];
                $totalPrice = $row["price"] * $row["quantity"];
                echo "
            <tr>
                <td>"
                    .$row["productName"] ."
                </td>
                <td> Rs. "
                    .$row["price"] ."
                </td>
                <td>"
                    .$row["quantity"] ."
                </td>
                <td> Rs. "
                    .$totalPrice ."
                </td>
                <td> 
                    <div class = 'container'>
                        <form method = 'POST' action = '/readCartUpdate?cartid=$cartID&productID=$productID'> 
                            <button type='submit' name = 'deleteButton'>Update</button>
                        </form>
                
                        <form method='POST' action='/deleteCart?id=$cartID'>
                            <button type='submit' onclick =" ."pop()" ." id = 'deleteButton'>Delete</button>
                        </form>
                    </div>
                </td>
        </tr>";
            }
        }
        else
        {
            echo "
                <tr>
                    <td colspan='5'>
                        No carts found
                    </td>
                </tr>";
        }
        ?>
    </table>
    <script>
        function pop()
        {
            var reply = confirm("you want to delete ?");
            if(!reply)
            {
                event.preventDefault();
            }
        }
    </script>
</body>
</html>


