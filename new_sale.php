<?php
require_once 'classes/shops.php';
require_once 'classes/users.php';
require_once 'classes/events.php';
require_once 'classes/products.php';

$shops = new Shops();
$myShops = $shops->listShops();

$users = new Users();
$myUsers = $users->listUsers();

$events = new Events();
$myEvents = $events->listEvents();

$products = new Products();
$myProducts = $products->listProducts();
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Add Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
    <body>
        <header class="bg-primary text-white p-3">
            <div class="container">
                <h1>Vendas</h1>
            </div>
        </header>
        <div class="container mt-4">
            <h2>Nova Venda</h2>
            <form action="save_sale.php" method="post">
                <div class="form-group">
                    <label for="shop">Loja:</label>
                    <select id="shop" name="shop" class="form-control">
                        <?php
                            foreach($myShops as $shop) {
                                echo "<option value='{$shop['art_shop_id']}'>{$shop['art_shop_name']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="user">Vendedor:</label>
                    <select id="user" name="user" class="form-control">
                        <?php
                            foreach($myUsers as $user) {
                                echo "<option value='{$user['art_user_id']}'>{$user['art_user_name']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="event">Evento:</label>
                    <select id="event" name="event" class="form-control">
                        <?php
                            foreach($myEvents as $event) {
                                echo "<option value='{$event['art_event_id']}'>{$event['art_event_name']}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="mt-4">
                    <h3>Carrinho</h3>
                    <div id="products">
                        <!-- Products will be added here -->
                    </div>
                </div>
                <div class="form-group">
                    <label for="total">Total:</label>
                    <input type="text" id="total" name="total" class="form-control money" value="0,00">
                </div>
                <button type="button" id="add-product" class="btn btn-secondary mb-3">Adicionar Produto</button>
                <button type="button" id="add-new-product" class="btn btn-secondary mb-3">Adicionar Novo Produto</button>
                <button type="submit" class="btn btn-primary mb-3">Cadastrar</button>
            </form>
        </div>
        <script>
            $('.money').mask('000.000.000.000.000,00', {reverse: true});
            $('#add-product').click(function() {
                // Add a new product dropdown, category dropdown and price input side by side
                $('#products').append(`
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="product">Produto:</label>
                                <select name="product[]" class="form-control">
                                    <?php
                                        foreach($myProducts as $product)
                                            echo "<option value='{$event['art_product_id']}'>{$event['art_product_name']}</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="quantity">Qtd.:</label>
                                <input type="number" name="quantity[]" class="form-control" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="price">Preço:</label>
                                <input type="text" name="price[]" class="form-control money" placeholder="0,00" aria-label="Valor" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="form-control btn btn-danger delete-product text-center">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `);
                $('.money').mask('000.000.000.000.000,00', {reverse: true});
            });

            $('#add-new-product').click(function() {
                // Add a new product name input, new category input and price input side by side
                $('#products').append(`
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="new_product">Novo Produto:</label>
                                <input type="text" name="new_product[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="new_category">Nova Categoria:</label>
                                <input type="text" name="new_category[]" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label for="quantity">Qtd.:</label>
                                <input type="number" name="quantity[]" class="form-control" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="new_price">Preço:</label>
                                <input type="text" name="new_price[]" class="form-control money" placeholder="0,00" aria-label="Valor" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" class="form-control btn btn-danger delete-product text-center">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `);
                $('.money').mask('000.000.000.000.000,00', {reverse: true});
            });
        </script>
        <script>
            function updateTotal() {
                var total = 0;
                $('input[name="price[]"], input[name="new_price[]"]').each(function() {
                    var value = $(this).val();
                    value = value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                    total += Number(value);
                });
                $('#total').val(total.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'}));
            }

            $('#add-product, #add-new-product').click(function() {
                updateTotal();
            });

            $(document).on('change', 'input[name="price[]"], input[name="new_price[]"]', function() {
                updateTotal();
            });

            $('#total').on('input', function() {
                var value = $(this).val();
                value = value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
                value = parseFloat(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                $(this).val(value);
            });

            $(document).on('click', '.delete-product', function() {
                $(this).closest('.row').remove();
                updateTotal();
            });
        </script>
    </body>
</html>