<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('.', false);}
?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</li>";
         endforeach;
      } else {

        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'Not found';
        $html .= "</li>";

      }

      echo json_encode($html);
   }
 ?>
 <?php
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
        foreach ($results as $result) {

          $html .= "<tr>";

          $html .= "<td id=\"s_name\">".$result['name']."</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" id=\"price\" name=\"price\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" id=\"quantity\" name=\"quantity\" value=\"1\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"{$result['sale_price']}\" readonly>";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Add sale</button>";
          $html  .= "</td>";
          $html  .= "</tr>";

        }
    } else {
        $html ='<tr><td>product name not resgister in database</td></tr>';
    }

    echo json_encode($html);
  }
 ?>

<script>
  document.getElementById('price').addEventListener('input', function () {
    var price = this.value.trim();

    var dangerousCharsPattern = /[<>\"']/;
    var numericPattern = /^[0-9]*$/;  // Only allows numbers

    if (price === "") {
        this.setCustomValidity('Price cannot be empty or just spaces.');
    } else if (this.value !== price) {
        this.setCustomValidity('Price cannot start with a space.');
    } else if (dangerousCharsPattern.test(price)) {
        this.setCustomValidity('Price cannot contain HTML special characters like <, >, ", \'.');
    } else if (!numericPattern.test(price)) {
        this.setCustomValidity('Please enter only numbers.');
    } else {
        this.setCustomValidity('');
    }

    var isValid = price !== "" && this.value === price && !dangerousCharsPattern.test(price) && numericPattern.test(price);
    this.classList.toggle('is-invalid', !isValid);
    this.classList.toggle('is-valid', isValid); // Optional for positive feedback
  });

  document.getElementById('quantity').addEventListener('input', function () {
      var quantity = this.value.trim();

      var dangerousCharsPattern = /[<>\"']/;
      var numericPattern = /^[0-9]*$/;  // Only allows numbers

      if (quantity === "") {
          this.setCustomValidity('Quantity cannot be empty or just spaces.');
      } else if (this.value !== quantity) {
          this.setCustomValidity('Quantity cannot start with a space.');
      } else if (dangerousCharsPattern.test(quantity)) {
          this.setCustomValidity('Quantity cannot contain HTML special characters like <, >, ", \'.');
      } else if (!numericPattern.test(quantity)) {
          this.setCustomValidity('Please enter only numbers.');
      } else {
          this.setCustomValidity('');
      }

      var isValid = quantity !== "" && this.value === quantity && !dangerousCharsPattern.test(quantity) && numericPattern.test(quantity);
      this.classList.toggle('is-invalid', !isValid);
      this.classList.toggle('is-valid', isValid); // Optional for positive feedback
  });
</script>