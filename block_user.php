<?php if (isset($_GET['msg'])): ?>
<script>
    Swal.fire({
        title: 'Success!',
        text: '<?php echo $_GET['msg']; ?>',
        icon: 'success',
        confirmButtonColor: '#1d4ed8'
    });
</script>
<?php endif; ?>