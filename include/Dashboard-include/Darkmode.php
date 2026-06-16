<button id="theme-toggle">Donkere modus</button>

<script>
    const toggleButton = document.getElementById('theme-toggle');
const body = document.body;

toggleButton.addEventListener('click', () => {
  body.classList.toggle('dark-mode');
  
  if (body.classList.contains('dark-mode')) {
    localStorage.setItem('theme', 'dark');
  } else {
    localStorage.setItem('theme', 'light');
  }
});

// Laad opgeslagen thema bij het opstarten
if (localStorage.getItem('theme') === 'dark') {
  body.classList.add('dark-mode');
}
</script>