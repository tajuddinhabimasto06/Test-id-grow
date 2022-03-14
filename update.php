<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nama_lengkap = isset($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '';
        $no_hp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
        
        // Update the record
        $stmt = $pdo->prepare('UPDATE kontak SET id = ?, nama_lengkap = ?, no_hp = ?, email = ?, alamat = ? WHERE id = ?');
        $stmt->execute([$id, $nama_lengkap, $no_hp, $email, $alamat, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM kontak WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $contact = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$contact) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>



<?=template_header('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$contact['id']?></h2>
    <form action="update.php?id=<?=$contact['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nama_lengkap">Nama Lengkap</label>
        <input type="text" name="id" value="<?=$contact['id']?>" id="id">
        <input type="text" name="nama_lengkap" value="<?=$contact['nama_lengkap']?>" id="nama_lengkap">
        <label for="no_hp">No. Hp</label>
        <label for="email">Email</label>
        <input type="text" name="no_hp" value="<?=$contact['no_hp']?>" id="no_hp">
        <input type="text" name="email" value="<?=$contact['email']?>" id="email">
        <label for="alama">alamat</label>
        <input type="text" name="alamat" value="<?=$contact['alamat']?>" id="alamat">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>