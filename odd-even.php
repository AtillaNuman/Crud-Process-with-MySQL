<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="odd-even.css">
	<title> Odd-even number finder application</title>
	<style>
		#inp {
			width: 100px;
		  margin: 8px 0;
		  box-sizing: border-box;
		  border: 2px solid green;
		  border-radius: 4px;
		}
	</style>
	<script>
		function resetForm() {
			// Clear the result message on the server side
			var form = document.createElement("form");
			form.method = "post";
			form.action = "";

			var resetInput = document.createElement("input");
			resetInput.type = "hidden";
			resetInput.name = "reset";
			resetInput.value = "true";
			form.appendChild(resetInput);

			document.body.appendChild(form);
			form.submit();
		}
	</script>
</head>
<body>

<?php
session_start();

$resultMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_POST['reset'])) {
		// Reset the variables
		$resultMessage = "";

		$_SESSION['resultMessage'] = $resultMessage;
		$_SESSION['sonuc_mesaj'] = $sonuc_mesaj;

		// Redirect to avoid form resubmission
		header("Location: " . $_SERVER['PHP_SELF']);
		exit;
	} elseif (isset($_POST['sonuc'])) {
		$secilen = $_POST['secilen'];

		// Now convert to integer for calculations
		$secilen = (int)$secilen; // Cast to integer


		if ($secilen % 2 == 0) {
			$resultMessage = "The number you select is even." . " ($secilen)";
		} else {
			$resultMessage = "The number you select is odd." . " ($secilen)";
		}

		// Store messages in session variables
		$_SESSION['resultMessage'] = $resultMessage;

		// Redirect to the same page to clear POST data
		header("Location: " . $_SERVER['PHP_SELF']);
		exit;
	}
} else {
	// Check for session messages
	if (isset($_SESSION['resultMessage'])) {
		$resultMessage = $_SESSION['resultMessage'];

		// Clear session messages
		unset($_SESSION['resultMessage']);
	}
}
?>

<form action="" method="post">
	Lutfen Sayi Seciniz: <input type="number" max="" min="0" name="secilen" 
	placeholder="Sayi Seciniz" id="inp" value="<?php echo isset($_POST['secilen']) ? htmlspecialchars($_POST['secilen']) : ''; ?>">

	<button type="submit" name="sonuc">Sonuclandır</button>
	<button type="button" onclick="resetForm()">Reset</button>
</form>

<div id="snackbar">

</div>

<?php if ($resultMessage !== ""): ?>
<script>
	// Get the snackbar DIV
	var x = document.getElementById("snackbar");

	// Add the "show" class to DIV
	x.className = "show";
	x.style.visibility = "visible";
	x.innerHTML = "<?php echo htmlspecialchars($resultMessage); ?>";

	// After 3 seconds, remove the show class from DIV
	setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
</script>
<?php endif; ?>

</body>
</html>