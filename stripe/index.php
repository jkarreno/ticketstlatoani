<?php require_once('./config.php'); ?>

<form action="charge.php" method="post">
  <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
          data-key="<?php echo $stripe['publishable_key']; ?>"
          data-description="Compra Cupón"
          data-amount="35000"
          data-currency="mxn"
          data-label="Paga con Tarjeta, Debito o Credito"
          data-locale="auto"></script>
</form>