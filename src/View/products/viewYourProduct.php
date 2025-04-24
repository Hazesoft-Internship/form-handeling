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
    <h1>Product List</h1>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Product Quantity</th>
            <th>Operations</th>
        </tr>
        <?php
        if ($data)
        {
            foreach($data as $row)
            {
                $productID = $row['id'];
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
                <td>
                    <div class = 'container'>
                        <form method = 'POST' action = '/readProduct?id=$productID'>
                            <button type='submit' name = 'deleteButton'>Update</button>
                        </form>
                
                        <form method='POST' action='/deleteProduct?id=$productID'>
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
                    <td colspan='4'>
                        No products found
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

