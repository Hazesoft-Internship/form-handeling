<html>

<head>
    <title>Form handling</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php require_once "formvalidation.php";
    use Validation\Formvalidation;

    $formData = new Formvalidation('mysql', 'user', 'password', 'mydb');
                        require_once "connection.php";

                        use Database\Connection;

                        $connection = new Connection('mysql', 'user', 'password', 'mydb');

                        $conn = $connection->connect();
    ?>



    <div class="form">
        <div>
            <form action="" method="POST">
                <div class="input">
                    <label for="fname">
                        FirstName:
                    </label>

                    <input type="text" name="fname" required> <span>
                        <?php
                        echo $formData->fnameErr;
                        ?>
                    </span>
                </div>
                <div class="input">
                    <label for="mname">
                        MiddleName:
                    </label>

                    <input type="text" name="mname"> <span>
                        <?php
                        echo $formData->mnameErr;
                        ?>
                    </span>
                </div>
                <div class="input">
                    <label for="lname">
                        LastName:
                    </label>

                    <input type="text" name="lname" required> <span>
                        <?php
                        echo $formData->lnameErr;
                        ?>
                    </span>
                </div>
                <div class="input">
                    <label for="address">
                        Address:
                    </label>

                    <input type="text" name="address" required> <span>
                        <?php
                        echo $formData->addressErr;
                        ?>
                    </span>
                </div>
                <div class="input">
                    <label for="email">
                        Email:
                    </label>
                    <input type="text" name="email" required>
                    <span>
                        <?php
                        echo $formData->emailErr;
                        ?>
                    </span>
                </div>
                <div class="input">
                    <input type="submit" name="submit" value="Submit">
                </div>
            </form>
        </div>
        <div>
            <!-- form for inserting 10k users -->

            <form action="insertuser.php" method="POST" class="">
                <label for="upload">Upload 10k Data</label>
                <input type="submit" name="submit" value="Upload">
            </form>
        </div>
    </div>
</body>

</html>