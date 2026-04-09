<script setup>
import Navbar from './components/Navbar.vue'
</script>

<template>
  <div class="app-container">
    <Navbar />
    <main class="main-content">
      <router-view />
    </main>
  </div>
</template>

<style>
/* Base Reset and Aesthetics */
:root {
  --primary-color: #ff6b6b;
  --secondary-color: #feca57;
  --bg-color: #fdfbf7;
  --text-color: #2d3436;
  --nav-bg: rgba(255, 255, 255, 0.85);
}

body {
  margin: 0;
  font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: var(--bg-color);
  color: var(--text-color);
}

.app-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding-top: 80px; /* Space for fixed navbar */
}
</style>
