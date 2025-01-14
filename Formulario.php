<?php
header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header("Access-Control-Allow-Headers: X-Requested-With");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Receba os detalhes do cliente do formulário
  $name = $_POST['name'];
  $email = $_POST['email'];
  $cep = $_POST['cep'];
  $rua = $_POST['rua'];
  $numero = $_POST['numero'];

  // Receba os detalhes do carrinho de compras enviados pelo JavaScript
  $cartItems = json_decode(file_get_contents('php://input'), true);

  // Construa a mensagem de e-mail incluindo os itens do carrinho de compras e os detalhes do cliente
  $to = "seu_email@example.com"; // Substitua pelo seu e-mail
  $subject = "Novo Pedido de Compra";
  $message = "Detalhes do Cliente:\n";
  $message .= "Nome: " . $name . "\n";
  $message .= "E-mail: " . $email . "\n";
  $message .= "CEP: " . $cep . "\n";
  $message .= "Rua: " . $rua . "\n";
  $message .= "Número de Telefone: " . $numero . "\n\n";
  $message .= "Detalhes do Carrinho:\n";
  foreach  ($cartItems as $item) {
    $message .= "Produto: " . $item['name'] . ", Preço: R$" . $item['price'] . "\n";
  }

  // Envie o e-mail
  $headers = "From: $email"; // Use o e-mail do cliente como remetente
  if (mail($to, $subject, $message, $headers)) {
    http_response_code(200);
  } else {
    http_response_code(500);
  }
} else {
  http_response_code(403);
}
?>
