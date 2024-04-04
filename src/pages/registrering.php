<?php
require_once "../../server/config.php";


$fornavn = $etternavn = $epost = $passord = $confirm_password = "";
$navn_err = $username_err = $password_err = $confirm_password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["epost"]))) {
        $username_err = "skriv in et navn.";
    } else {
     
        $sql = "SELECT kundeid FROM kunde WHERE epost = ?";

        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("s", $param_epost);
            $param_epost = trim($_POST["epost"]);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $navn_err = "Dette navnet er alerede i bruk.";
                } else {
                    $epost = trim($_POST["epost"]);
                }
            } else {
                echo "Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

  
    if (empty(trim($_POST["passord"]))) {
        $password_err = "skriv in et passord.";
    } elseif (strlen(trim($_POST["passord"])) < 6) {
        $password_err = "Passordet må ha i hvert fall 6 tegn.";
    } else {
        $password = trim($_POST["passord"]);
    }

    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "skriv in passordet igjen.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($password != $confirm_password) {
            $confirm_password_err = "Passordet du skrev in var ikke likt";
        }
    }

   
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
      
        $sql = "INSERT INTO Kunde (epost, passord, fornavn, etternavn) VALUES (?, ?, ?, ?)";

        if ($stmt = $link->prepare($sql)) {
            $stmt->bind_param("ssss", $param_epost, $param_password, $_POST['fornavn'], $_POST['etternavn']);
            $param_navn = $navn;
            $param_username = $username;
            $param_password = $password;

            if ($stmt->execute()) {
               
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }

            $stmt->close();
        }
    }

   
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="icon" type="image/x-icon" href="assets/jpg/linje5.jpg">
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="registrer-form">
        <div class="imgcontainer">
          <img src="assets/jpg/Linje5.jpg" alt="linje5" class="avatar">
        </div>
          <h2>Register</h2>
          <div>
                <label>Fornavn</label>
                <input type="text" name="fornavn" placeholder="Skriv in navnet ditt"
                    class="form-control <?php echo (!empty($navn_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $fornavn; ?>">
                <span class="invalid-feedback">
                    <?php echo $username_err; ?>
                </span>

                <label>Etternavn</label>
                <input type="text" name="etternavn" placeholder="Skriv in navnet ditt"
                    class="form-control <?php echo (!empty($navn_err)) ? 'is-invalid' : ''; ?>"
                    value="<?php echo $etternavn; ?>">
                <span class="invalid-feedback">
                    <?php echo $username_err; ?>
                </span>
          
                <label>Epost</label>
                <input type="text" name="epost" placeholder="Skriv in eposten din"
                    class="form-control <?php echo (!empty($username_err)) ? 'er feil' : ''; ?>"
                    value="<?php echo $epost; ?>">
                <span class="invalid-feedback">
                    <?php echo $username_err; ?>
                </span>
            
                <label>Passord</label>
                <input type="password" name="passord" placeholder="Lag et Passord"
                    class="form-control <?php echo (!empty($password_err)) ? 'er feil' : ''; ?>"
                    value="<?php echo $passord; ?>">
                <span class="invalid-feedback">
                    <?php echo $password_err; ?>
                </span>
           
                <label>Verifiser Passord</label>
                <input type="password" name="confirm_password" placeholder="Skriv in passordet på nytt"
                    class="form-control <?php echo (!empty($confirm_password_err)) ? 'er feil' : ''; ?>"
                    value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback">
                    <?php echo $confirm_password_err; ?>
                </span>
            </div>
            <div class="regbtn">
                <input type="submit" class="Registrerbtn" value="Registrer">
                <input type="reset" class="Cancel" value="Cancel">
            </div>
            <p>Har du en bruker? <a href="login.php">Login her</a>.</p>
        </form>
</body>

</html>