<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>SQL Injection Demo</title>
	</head>
	<body>
		<form action="index.php" method="POST">
			<input type="text" name="username">
			<input type="submit" value="search">
		</form>
		<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				try {
					$dsn = "mysql:dbname=sql_injection_demo;host=localhost;charset=utf8mb4";
					$username = "kamy";
					$password = "kamy";

					$pdo = new PDO($dsn, $username, $password);
					$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

					$stmt = $pdo->prepare("SELECT * FROM users WHERE username='" . $_POST["username"] . "';");
					$stmt->execute();

					header("Content-Type: text/html; charset=utf-8");
					while ($row = $stmt->fetch()) {
						printf("<p>username: %s<br>memo: %s</p>\n", $row["username"], $row["memo"]);
					}
				} catch (PDOException $e) {
					header("Content-Type: text/plain; charset=UTF-8", true, 500);
					exit($e->getMessage());
				} finally {
					$stmt = null;
					$pdo = null;
				}
			}
		?>
	</body>
</html>
