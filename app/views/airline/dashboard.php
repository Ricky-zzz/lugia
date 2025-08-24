<?php include __DIR__ . '/../admin/partials/head.php'; ?>
<body>
    <div class="d-flex flex-column min-vh-100 w-100">
        <header class="w-100">
            <?php include __DIR__ . '/../airline/partials/header.php'; ?>
        </header>

        <div class="d-flex flex-grow-1 w-100">
            <aside class="bg-light border-end p-3" style="width: 280px; flex-shrink: 0;">

            </aside>

            <main class="flex-grow-1 p-4 w-100" style="min-width:0;">
                <h2>Welcome to Airline Dashboard</h2>
                <p>This is a placeholder. Later you can add stats, charts, or shortcuts here.</p>
            </main>
        </div>

        <footer class="mt-auto">
            <?php include __DIR__ . '/../admin/partials/footer.php'; ?>
        </footer>
    </div>
</body>
<?php include __DIR__ . '/../admin/partials/foot.php'; ?>
