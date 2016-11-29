<html>
 <head>
  <title>Calculator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
 </head>
 <body>
   <div class="container">
     <h1>Tip Calculator</h1>

     <?php
        $subtotal = $tip = $custom = $split = "";
        $subtotalError = $customTipError = $splitError = "";
        $tips = [0.10, 0.15, 0.20];

        if (isset($_POST['submit'])) {
          //Error checking
          if(!$_POST['subtotal']) {
            //   echo "<p>Please enter your subtotal.</p>\n";
            $subtotal = "";
            $subtotalError = "Subtotal required.";
          }  else {
            $subtotal = $_POST['subtotal'];

            if ($subtotal <= 0) {
              $subtotalError = "Please enter a valid subtotal";
            }
          }

          if (!$_POST['tip']) {
            $tip = "";
          } else {
            $tip = $_POST['tip'];
          }

          if (!$_POST['custom']) {
            $custom = "";
          } else {
            $custom = $_POST['custom'];
          }

          if (!$_POST['split']) {
            $split = "";
          } else {
            $split = $_POST['split'];

            if ($split <= 1) {
              $splitError = "Please enter more than 2 people to split.";
            }
          }

          if ($tip == 'custom') {
            $tip = $custom / 100;

            if ($tip <= 0) {
              $customTipError = "Please enter a valid tip.";
            }
          } else {
            $custom = "";
          }

        }
     ?>

     <form method="post" onsubmit="formSubmit()" action="<?=$_SERVER['PHP_SELF']?>">
       <label for="subtotal">Subtotal: $</label>
       <input type="text" name="subtotal" value="<?php echo $subtotal; ?>" size="10">
       <?php
          if (!empty($subtotalError)) {
            echo '<br class="hide-on-large">';
            echo '<span class="error">' . $subtotalError . '</span>';
          }
       ?>
       <br>
       Tip percentage: <br>
       <?php
          for ($i=0; $i < count($tips); $i++) {
            echo '<label><input type="radio" name="tip" value="' . $tips[$i] . '"';

            if (empty($custom) && empty($customTipError)) {

              if (empty($tip) && $i == 0)
                echo ' checked';
              else if (!empty($tip) && $tips[$i] == $tip)
                echo 'checked';

            }

            echo '>' . ($tips[$i] * 100) . '%</label>';
            echo '<br class="hide-on-large">';
          }
        ?>
        <label>
          <input type="radio" id="other" name="tip" value="custom" <?php if (!empty($custom) || !empty($customTipError)) { echo 'checked'; } ?>>Other:
          <input type="text" name="custom" value="<?php echo $custom; ?>" size="4" onfocus="focusOther()">
          <?php
            if (!empty($customTipError)) {
              echo '<br class="hide-on-large">';
              echo '<span class="error">' . $customTipError . '</span>';
            }
          ?>
        </label>
        <br>
        <label for="split">
          Split:
          <input type="text" name="split" value="<?php echo $split; ?>" size="5">
          person(s)
          <?php
            if (!empty($splitError)) {
              echo '<br class="hide-on-large">';
              echo '<span class="error">' . $splitError . '</span>';
            }
          ?>
        </label>

       <br>
       <input type="submit" name="submit" value="submit">
     </form>
     <?php

        // validate subtotal and tip
        if (empty($subtotalError)) {

          if (empty($customTipError)) {

            $tip *= $subtotal;
            $subtotal += $tip;

            echo '<div class="total">';
            echo 'Tip: $'. number_format($tip, 2) . '<br>';
            echo 'Total: $' . number_format($subtotal, 2);
            echo "</div>";

            // check if split is valid
            if (!empty($split) && $split > 1) {

              $tip = $tip / $split;
              $subtotal = $subtotal / $split;

              echo '<div class="total">';
              echo 'Tip: $'. number_format($tip, 2) . '<br>';
              echo 'Total: $' . number_format($subtotal, 2);
              echo "</div>";

            } else {
              echo "bad split";
            }

          } else {
            echo "bad tip";
          }

        } else {
          echo "bad subtotal";
        }

      ?>
   </div>
   <script src="script.js" charset="utf-8"></script>
 </body>
</html>
