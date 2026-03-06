<?php
// Simple script to generate password hash and update manager account

require_once 'config/database.php';

$pdo = getDBConnection();

// Set the new password
$newPassword = 'manager123';
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update the manager account
$sql = "UPDATE users SET password_hash = :password WHERE email = 'manager@traveleasy.nl'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['password' => $hashedPassword]);

echo "Password updated successfully!\n\n";
echo "You can now login with:\n";
echo "Email: manager@traveleasy.nl\n";
echo "Password: manager123\n";
?>
