<footer class="py-5 text-center text-body-secondary bg-body-tertiary">
    <p>IT blog for students</p>
    <p class="mb-0">
        <a href="#">Back to top</a>
    </p>
</footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function selectCategory(element) {
        const categoryText = element.textContent;
        const categoryId = element.getAttribute('data-id');
        document.getElementById('categoryDropdown').textContent = categoryText;
        document.getElementById('selectedCategory').value = categoryId;
    }

</script>


</body>
</html>