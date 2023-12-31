<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
   <!-- <link rel="stylesheet" href="calc.css">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body class="d-flex flex-column justify-content-center align-items-center vh-100 bg-light">
    <div class="mb-3 bg-white rounded border text-center">
        <h1 class="m-3 p-3">Calculator</h1>
        <form class="text-center" action="calc.php" method="get">
            <div class="mx-4 mb-4">
                <label for="num1"></label>
                <input class="px-2 py-1 rounded border border-info" id="num1" name="num1" type="text">
                <label for="operator"></label>
                <select class="py-2 px-2 rounded bg-white border border-info" id="operator" name="operator">
                    <option value="add">+</option>
                    <option value="sub">-</option>
                    <option value="mult">*</option>
                    <option value="div">/</option>
                </select>
                <label for="num2"></label>
                <input class="px-2 py-1 rounded border border-info" id="num2" name="num2" type="text">
            </div>
            <button class="mb-4 p-3 bg-info rounded border-0 text-white" type="submit">Calculate</button>
            <div>
                <input class="mb-4 px-3 py-3 h3 rounded border border" type="text" name="Result" value="<?= $result ?? 0 ?>" disabled>
            </div>
        </form>
    </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>