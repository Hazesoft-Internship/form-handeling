
<?php
require("../../../vendor/autoload.php");
use App\config\Database;
use App\model\Product;
use App\session\Session;

$db = Database::getInstance();
$conn = $db->getConnection();
$myProducts = new Product($conn);
$session = new Session();
$user_id = $session->getSession("user_id");
$storeProduct = $myProducts->getMyProducts($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>My Products</h1>
    <?php if (!empty($storeProduct)): ?>
        <div>
            <?php foreach ($storeProduct as $product): ?>
                <div>
                    <strong>Name:</strong> <?php echo $product['name']; ?>
                    <strong>Quantity:</strong> <?php echo $product['quantity']; ?>
                    <strong>Price:</strong> $<?php echo $product['price']; ?>
                    <?php if ($session->getSession("user_id") === $product["user_id"]): ?>
                        <form onsubmit="onSubmit(event)" action="../controller/ProductDelete.php" method="post">
                            <input name="id" type="hidden" value="<?php echo $product["id"] ?>" />
                            <button id="delete" type="submit">delete</button>
                        </form>
                            
                            <a href="./UpdateProduct.php?id=<?php echo $product["id"] ?>"><button>update</button></a>
                        
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
    <a href="./AddProduct.html"> <button>add product</button> </a>

    <script>
    const onSubmit=(e)=>{
        if(!confirm("do you really want to delete")) {
            e.preventDefault();
        }
    }
    </script>
    
    
</body>
</html>