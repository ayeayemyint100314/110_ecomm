<?php
if(!isset($_SESSION))
{
    session_start();
}
require_once "../admin/dbconnect.php";
try {
    $sql = "SELECT  p.productID, p.productName, 
		p.price, p.description, p.qty,
        p.imgPath, c.catName as category
        from products p, category c 
        where p.category = c.catID";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(); // just naming variable for multiple products

} catch (PDOException $e) {
    echo $e->getMessage();
}

// category extract
try {
    $sql = "select * from category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}

// for searching category
if(isset($_GET['cSearch']) && $_SERVER['REQUEST_METHOD']=='GET')
{      $cid = $_GET['category']; // 1, 2, 3, 4, 5

     try {
        $sql = "SELECT  p.productID, p.productName, 
		        p.price, p.description, p.qty,
                 p.imgPath, c.catName as category
                from products p, category c 
                where p.category = c.catID and
                c.catID=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$cid]);
        $products = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
// end for searching category
// for radio search
else if(isset($_POST['radioBtn'])) // for radio search
{
    $price = $_POST['price'];
    if($price=="first")
    {
        $lower = 200;
        $upper = 300;
    }
    else if($price=="second")
    {
        $lower = 301;
        $upper = 500;
    }
    else if ($price=='third')
    {
         $lower = 501;
        $upper = 800;
    }
    try{
        $sql = "select p.productID, p.productName,
		        p.price, p.description,
                 p.qty, p.imgPath, 
                c.catName as category
                from products p, category c 
                 where p.price BETWEEN ? and ? and 
                c.catID= p.category" ;
        $stmt = $conn->prepare($sql);
        $stmt->execute([$lower, $upper]);
        $products = $stmt->fetchAll();

    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navi.php";  ?>
        </div>
        <div class="row">
            <div class="col-md-2 py-3">
                <div class="card">
                    <form action="customerView.php" class="form" method="get">
                        <select name="category" id="" class="form-select">
                            <option value="">Choose Category</option>
                            <?php
                            foreach ($categories as $category) {
                                echo "<option value=$category[catID]>$category[catName]</option>";
                            }

                            ?>
                        </select>
                        <button name='cSearch' class="btn btn-outline-primary btn-sm rounded-pill">Search</button>
                    </form>
                </div>
                 <div class="card my-3"> <!-- .card.mb-3 -->
                    <form class="form" action="customerView.php" method="post">
                        <div class="form-check">
                                <input type="radio" name="price" value="first" class="form-check-input">
                                <label for="" class="form-check-label">
                                    $200-$300</label>
                        </div>
                         <div class="form-check mb-2">
                                <input type="radio" name="price" value="second" class="form-check-input">
                                <label for="" class="form-check-label">
                                    $301-$500</label>
                        </div>
                        <div class="form-check mb-2">
                                <input type="radio" name="price" value="third" class="form-check-input">
                                <label for="" class="form-check-label">
                                    $501-$800</label>
                        </div>
                        <div class="mb-2">
                            <button name="radioBtn" class="btn btn-outline-primary rounded-pill">Search</button>
                        </div>
                    </form>
                </div>

            </div>
            <div class="col-md-10 py-3">
                <?php if (isset($_SESSION['loginSuccess'])) {  ?>
                    <p class="alert alert-success"><?php echo $_SESSION['loginSuccess'] ?></p>
                <?php
                    unset($_SESSION['loginSuccess']);
                }  ?>

                <?php  // to arrange products in card view
                if (isset($products)) {
                    echo "<div class='row'>";
                    foreach ($products as $product) {
                        $desc = substr($product['description'], 0, 20);
                        $pname = substr($product['productName'], 0, 15);
                        echo "<div class='col-md-3 mb-3'>
                                    <div class='card shadow-lg h-100'>
                                        <div class='card-title'> 
                                            $pname
                                        </div>
                                        <div class='card-body'> 
                                            <div> $product[category]   </div>
                                            <div> $$product[price]   </div>
                                            <div> $desc <a href=detail.php>detail</a>  </div>
                                            <div class='card-img-top'><img src=../admin/$product[imgPath] style=width:75px;height:70px>  </div>
                                            <div><form class='d-flex align-items-center' method=post action=addCart.php>
                                            <input type=hidden name=id value=$product[productID]> 
                                            qty<input type=number name=qty min=1 class='form-control' style=width:40%; height:0.6rem>
                                            <button class='btn btn-warning btn-sm' name=add_cart style=font-size:0.6rem>Add cart</button> </div>
                                            </form>
                                            </div>                      
                                    </div>
                                 </div> ";
                    } // end for each
                    echo "</div>";
                } // end if            



                ?>

            </div>



        </div>






    </div>


</body>

</html>