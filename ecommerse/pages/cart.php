<?php foreach ($cart_items as $item): ?>
<tr>
    <td><?= htmlspecialchars($item['name']); ?></td>
    <td>$<?= number_format($item['price'], 2); ?></td>
    <td><?= $item['quantity']; ?></td>
    <td>$<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="product_id" value="<?= $item['cart_id']; ?>">
            <button type="submit" name="remove_from_cart">Remove</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>


<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// Fetch the user's cart items
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT cart.id AS cart_id, products.name, products.price, cart.quantity 
                        FROM cart 
                        JOIN products ON cart.product_id = products.id 
                        WHERE cart.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_cost = 0;
?>