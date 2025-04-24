<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
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
    </style>
</head>
<body>
    <h1>Product List</h1>
    <table>
        <tr>
            <th>
                Product Name
            </th>
            <th>
                Product Price
            </th>
            <th>
                Product Quantity
            </th>
            <th>
                Operations
            </th>
        </tr>
        <?php
        if ($data)
        {
            foreach($data as $row)
            {
                $productID = $row['id'];
                echo
                    "<tr>
                        <td>"
                            .$row["productName"]."
                        </td>
                        <td>
                            Rs. ".$row["price"]."
                        </td>
                        <td>
                            ".$row["quantity"]."
                        </td>
                        <td>
                            <div class = 'container'>
                                <form method = 'POST' action = '/createCart?id=$productID'>
                                    <button type='submit' name = 'addToCart'>Add to cart</button>
                                </form>
                            </div>
                        </td>
                    </tr>";
            }
        }
        else
        {
            echo
                "<tr>
                    <td colspan='3'>
                        No products found
                    </td>
                </tr>";
        }
        ?>
    </table>
</body>
</html>

