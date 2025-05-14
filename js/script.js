const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarLinks = document.querySelectorAll('.sidebar-links a');

        // Toggle the sidebar's expanded/collapsed state
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            sidebar.classList.toggle('expanded');
        });

        // Ensure sidebar expands on link click
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('collapsed');
                sidebar.classList.add('expanded');
            });
        });

        // Close sidebar when clicking outside of it
        window.addEventListener('click', (event) => {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.add('collapsed');
                sidebar.classList.remove('expanded');
            }
        });