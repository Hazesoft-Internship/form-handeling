<html>

<head>
    <title>Form handling</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php require_once "formvalidation.php" ?>

    <form action="" method="POST" class="form">
        <div class="input">
            <label for="fname">
                FirstName:
            </label>

            <input type="text" name="fname" required> <span>
                <?php
                echo $fnameErr;
                ?>
            </span>
        </div>
        <div class="input">
            <label for="mname">
                MiddleName:
            </label>

            <input type="text" name="mname"> <span>
                <?php
                echo $mnameErr;
                ?>
            </span>
        </div>
        <div class="input">
            <label for="lname">
                LastName:
            </label>

            <input type="text" name="lname" required> <span>
                <?php
                echo $lnameErr;
                ?>
            </span>
        </div>
        <div class="input">
            <label for="address">
                Address:
            </label>

            <input type="text" name="address" required> <span>
                <?php
                echo $addressErr;
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
                echo $emailErr;
                ?>
            </span>
        </div>
        <div class="input">
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
</body>

</html>