<?php
    include "../db.php";
    session_start();

    if (!isset($_SESSION['id_usuario'])) {
        header("Location: login.php");
        exit;
    }
?>
<?php include "header.php"; ?>

  <main>
    <div id="trem3D"></div>
  </main>
  <script type="importmap">
    {
        "imports": {
            "three": "https://cdn.jsdelivr.net/npm/three@0.177.0/build/three.module.js",
  "jsm/": "https://cdn.jsdelivr.net/npm/three@0.177.0/examples/jsm/"
}
    }
</script>
  <script type="module" src="../script/loadModel-final.js"></script>



</body>
</html>
