<script>
    function myFunction() {
  var element = document.body;
  element.classList.toggle("dark-mode");
}
</script>

<style>

.dark-mode {
  background-color: black;
  color: white;
}

button {
    background-color:black;
    color: white;
    border-radius: 7px;
    height: 30px;
    width: 100px;
}
</style>

<button onclick="myFunction()">Toggle dark mode</button>


