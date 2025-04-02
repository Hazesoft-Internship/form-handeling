<?php
require("../../../vendor/autoload.php");
use App\config\Database;
use App\controller\ProductController;
use App\validate\ProductValidation;

$productId = (int)$_GET["id"];
$db = Database::getInstance();
$conn = $db->getConnection();
$validate = new ProductValidation();
$singleProduct = new ProductController($conn,$validate);
$singleProduct1 = $singleProduct->getSingleProduct($productId);

if($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $singleProduct->updateProduct($_POST["id"],$_POST["name"],$_POST["quantity"],$_POST["price"]);

}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Product</h1>
    <form onsubmit="onSubmit(event)" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $productId ?>"/>
        <label>Product Name</label>
        <input name="name" value="<?php echo $singleProduct1["name"] ?>"/>
        <label>Product Quantity</label>
        <input name="quantity" value="<?php echo $singleProduct1["quantity"] ?>"/>
        <label>Product Price</label>
        <input name="price" value="<?php echo $singleProduct1["price"] ?>"/>
        <button type="submit">update</button>
    </form>
    <script>
        const onSubmit=(e)=>{
            if(!confirm("Do you really want to update?")) {
                e.preventDefault()
            }
        }
    </script>
</body>
</html>