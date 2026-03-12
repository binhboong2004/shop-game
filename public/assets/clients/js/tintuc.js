document.addEventListener('DOMContentLoaded', function () {
    // Logic for Tabs in News page
    const newsTabs = document.querySelectorAll('.news-tab');

    newsTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            // Remove active class from all tabs
            newsTabs.forEach(t => {
                t.classList.remove('active', 'bg-primary/10', 'text-primary', 'border-primary');
                t.classList.add('text-slate-400', 'border-transparent');
            });

            // Add active class to the clicked tab
            this.classList.add('active', 'bg-primary/10', 'text-primary', 'border-primary');
            this.classList.remove('text-slate-400', 'border-transparent');

            // Optionally, implement filtering logic here based on the selected tab text
            // e.g. const category = this.textContent.trim();
            // filterNews(category);
        });
    });

    // Optional function to filter news
    function filterNews(category) {
        console.log("Filtering news by:", category);
        // Implement filter logic...
    }
});
