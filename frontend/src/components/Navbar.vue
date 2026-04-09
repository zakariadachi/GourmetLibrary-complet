<script setup>
import { RouterLink } from 'vue-router'
</script>

<template>
  <nav class="navbar">
    <div class="nav-brand">
      <RouterLink to="/" class="brand-link">
        <span class="logo-icon">🍽️</span>
        <span class="logo-text">Gourmet</span>Library
      </RouterLink>
    </div>
    <div class="nav-links">
      <RouterLink to="/" class="nav-item">Accueil</RouterLink>
      <RouterLink to="/books" class="nav-item">Tous les livres</RouterLink>
      <a href="#" class="nav-item">Mes Emprunts</a>
    </div>
    <div class="nav-auth">
      <RouterLink to="/login" class="btn-login" style="text-decoration: none; display: inline-block;">Connexion</RouterLink>
    </div>
  </nav>
</template>

<style scoped>
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  height: 70px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 40px;
  background: var(--nav-bg);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-bottom: 1px solid rgba(255, 255, 255, 0.3);
  z-index: 1000;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
}

.brand-link {
  text-decoration: none;
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--text-color);
  display: flex;
  align-items: center;
  gap: 10px;
}

.logo-text {
  color: var(--primary-color);
}

.nav-links {
  display: flex;
  gap: 30px;
}

.nav-item {
  text-decoration: none;
  color: #555;
  font-weight: 600;
  transition: color 0.3s ease;
}

.nav-item:hover, .nav-item.router-link-active {
  color: var(--primary-color);
}

.btn-login {
  background: linear-gradient(135deg, var(--primary-color), #ff4757);
  color: white;
  border: none;
  padding: 10px 24px;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
}

.btn-login:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
}
</style>
