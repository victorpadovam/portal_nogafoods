<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noga Foods Delivery</title>
</head>
<body>

<script>
        var appDeepLink = "{{ $appDeepLink }}";  // Link para abrir o app
        var storeUrl = "{{ $storeUrl }}";   

        if (window.Android && window.Android.isAppInstalled()) {
        // O app está instalado, pode abrir o app
        alert('O app está instalado, pode abrir o app');
    } else {
        // O app não está instalado, pode redirecionar para a Play Store
                alert('O app nao está instalado, pode abrir o app');

    }
</script>

</body>
</html>
