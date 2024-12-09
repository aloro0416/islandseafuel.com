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
 // find all products
if (isset($_POST['p_name']) && strlen($_POST['p_name'])) {
  $product_title = remove_junk($db->escape($_POST['p_name']));
  if ($results = find_all_product_info_by_title($product_title)) {
      foreach ($results as $result) {

          // Get the price and quantity values from the form (or set defaults)
          $price = isset($_POST['price']) ? $_POST['price'] : $result['sale_price'];
          $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

          // Validate price (ensure it is a positive number)
          if (!is_numeric($price) || $price <= 0) {
              $html .= "<tr><td colspan='6' class='text-danger'>Invalid price entered for product: {$result['name']}. Please enter a valid number greater than zero.</td></tr>";
              continue; // Skip this product and continue with the next
          }

          // Validate quantity (ensure it is a positive integer)
          if (!is_numeric($quantity) || $quantity <= 0 || (int)$quantity != $quantity) {
              $html .= "<tr><td colspan='6' class='text-danger'>Invalid quantity entered for product: {$result['name']}. Please enter a valid integer greater than zero.</td></tr>";
              continue; // Skip this product and continue with the next
          }

          // If both price and quantity are valid, continue to generate the table row
          $html .= "<tr>";

          $html .= "<td id=\"s_name\">" . $result['name'] . "</td>";
          $html .= "<input type=\"hidden\" name=\"s_id\" value=\"{$result['id']}\">";
          $html .= "<td>";
          $html .= "<input type=\"text\" class=\"form-control\" id=\"price\" name=\"price\" value=\"{$price}\">"; // Editable price
          $html .= "</td>";
          $html .= "<td id=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" id=\"quantity\" name=\"quantity\" value=\"{$quantity}\">"; // Editable quantity
          $html .= "</td>";
          $html .= "<td>";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"total\" value=\"" . ($price * $quantity) . "\" readonly>"; // Calculate total
          $html .= "</td>";
          $html .= "<td>";
          $html .= "<input type=\"date\" class=\"form-control datePicker\" name=\"date\" data-date data-date-format=\"yyyy-mm-dd\">";
          $html .= "</td>";
          $html .= "<td>";
          $html .= "<button type=\"submit\" name=\"add_sale\" class=\"btn btn-primary\">Add sale</button>";
          $html .= "</td>";
          $html .= "</tr>";
      }
  } else {
      $html = '<tr><td>Product name not registered in the database.</td></tr>';
  }

  echo json_encode($html);
}

 ?>