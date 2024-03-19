const headings = document.querySelectorAll('h2');
headings.forEach(heading => {
    heading.addEventListener('click', () => {
        const section = heading.nextElementSibling;
        if (section.style.display === 'none') {
            section.style.display = 'block';
        } else {
            section.style.display = 'none';
        }
    });
});