</main>

</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const spinner = document.querySelector('.spinner-wrapper');

    window.addEventListener('load', () => {
        setTimeout(() => {
            spinner.style.display = 'none';
        }, 1000);
    });

    // Routing functionality
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const url = link.getAttribute('href');

                // Show spinner during load
                spinner.style.display = 'flex';

                loadPage(url);
            });
        });
    });

    async function loadPage(url) {
        try {
            const response = await fetch(url);
            const html = await response.text();

            // Extract just the body content from the loaded page
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Get the main content from the fetched page
            const newContent = doc.querySelector('main') || doc.querySelector('#content');

            // Replace current main content
            if (newContent) {
                document.querySelector('#content').innerHTML = newContent.innerHTML;
                window.scrollTo(0, 0); // Scroll to top after loading
            }

            // Update URL
            history.pushState({
                page: url
            }, '', url);

            // Hide spinner
            setTimeout(() => {
                spinner.style.display = 'none';
            }, 500);

        } catch (error) {
            console.error('Error loading page:', error);
            spinner.style.display = 'none';
        }
    }

    // Handle browser back/forward buttons
    window.addEventListener('popstate', (e) => {
        if (e.state && e.state.page) {
            spinner.style.display = 'flex';
            loadPage(e.state.page);
        }
    });
</script>

</html>