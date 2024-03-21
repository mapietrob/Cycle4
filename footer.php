</main>

<footer>
    <div id="footer-content">
        <!-- Footer content, such as copyright notice and year -->
        <p>&copy; <?php echo date("Y"); ?> To-Do List App</p>

        <!-- link back to home if not on the homepage -->
        <?php if ($currentFile != "index.php"): ?>
            <p><a href="index.php">Home</a></p>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>