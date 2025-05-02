<div id="pagination-bar" class="flex center">
    <!-- Previous Button -->
    <?php if ($current_page > 1): ?>
        <a href="?page_num=<?= $current_page - 1 ?>&title=<?= urlencode($title) ?>&sort_by=<?= urlencode($sort_by) ?>" id="prev">&lt;</a>
    <?php endif; ?>

    <!-- Page Number Buttons -->
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page_num=<?= $i ?>&title=<?= urlencode($title) ?>&sort_by=<?= urlencode($sort_by) ?>"
           class="<?= $current_page == $i ? 'btn-active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <!-- Next Button -->
    <?php if ($current_page < $total_pages): ?>
        <a href="?page_num=<?= $current_page + 1 ?>&title=<?= urlencode($title) ?>&sort_by=<?= urlencode($sort_by) ?>" id="next">&gt;</a>
    <?php endif; ?>
</div>
