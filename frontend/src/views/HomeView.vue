<script setup>
import { ref, onMounted } from 'vue'

const categories = ref([])
const loading = ref(true)

const fetchCategories = async () => {
  try {
    // Calling the local Laravel backend
    const response = await fetch('http://127.0.0.1:8000/api/categories')
    const data = await response.json()
    if (data && data.data) {
      categories.value = data.data
    } else {
      categories.value = data // Fallback depending on Laravel response structure
    }
  } catch (error) {
    console.error('Error fetching categories:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCategories()
})
</script>

<template>
  <div class="home-container">
    <section class="hero">
      <div class="hero-content">
        <h1 class="bounce-in">Découvrez la magie de la <span class="highlight">Cuisine</span></h1>
        <p class="fade-in">Votre bibliothèque culinaire personnelle. Explorez, apprenez et dégustez.</p>
        <button class="cta-button pulse">Explorer la Librairie</button>
      </div>
      <div class="hero-image-container">
         <div class="blob"></div>
         <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Culinary art" class="hero-image" />
      </div>
    </section>

    <section class="categories-section">
      <h2 class="section-title">Nos Catégories</h2>
      
      <div v-if="loading" class="loader">
        <div class="spinner"></div>
        <p>Chargement des délices...</p>
      </div>
      
      <div v-else class="categories-grid">
        <div v-for="category in categories" :key="category.id" class="category-card">
          <div class="card-icon">🍲</div>
          <h3>{{ category.name || category.title || 'Catégorie' }}</h3>
          <p>{{ category.description || 'Découvrez nos meilleures sélections.' }}</p>
          <RouterLink :to="{ name: 'category.books', params: { categoryId: category.id } }" class="read-more">
            Voir les livres &rarr;
          </RouterLink>
        </div>
        
        <!-- Dummy data if nothing from backend yet for beautiful UI -->
        <div v-if="categories.length === 0" class="category-card">
          <div class="card-icon">🍰</div>
          <h3>Pâtisserie</h3>
          <p>L'art de réaliser des desserts sucrés et élégants.</p>
          <RouterLink to="/books" class="read-more">Voir les livres &rarr;</RouterLink>
        </div>
        <div v-if="categories.length === 0" class="category-card">
          <div class="card-icon">🥗</div>
          <h3>Cuisine Saine</h3>
          <p>Des repas équilibrés pour nourrir votre corps et votre esprit.</p>
          <RouterLink to="/books" class="read-more">Voir les livres &rarr;</RouterLink>
        </div>
        <div v-if="categories.length === 0" class="category-card">
          <div class="card-icon">🔥</div>
          <h3>Grillades</h3>
          <p>Maîtrisez le feu et les viandes avec ces guides incontournables.</p>
          <RouterLink to="/books" class="read-more">Voir les livres &rarr;</RouterLink>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
.home-container {
  display: flex;
  flex-direction: column;
  gap: 60px;
  padding-bottom: 60px;
}

/* HERO SECTION */
.hero {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 40px 10%;
  min-height: 70vh;
  position: relative;
  overflow: hidden;
}

.hero-content {
  flex: 1;
  max-width: 600px;
  z-index: 2;
}

.hero-content h1 {
  font-size: 4rem;
  line-height: 1.1;
  margin-bottom: 20px;
  color: #2d3436;
}

.highlight {
  color: var(--primary-color);
  position: relative;
  display: inline-block;
}

.highlight::after {
  content: '';
  position: absolute;
  bottom: 8px;
  left: 0;
  width: 100%;
  height: 12px;
  background-color: var(--secondary-color);
  opacity: 0.5;
  z-index: -1;
  transform: skewX(-15deg);
}

.hero-content p {
  font-size: 1.2rem;
  color: #636e72;
  margin-bottom: 30px;
}

.cta-button {
  background: var(--primary-color);
  color: white;
  border: none;
  padding: 16px 36px;
  font-size: 1.2rem;
  border-radius: 50px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
  transition: all 0.3s ease;
}

.cta-button:hover {
  transform: translateY(-3px) scale(1.05);
  box-shadow: 0 15px 25px rgba(255, 107, 107, 0.4);
}

.hero-image-container {
  flex: 1;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

.blob {
  position: absolute;
  width: 450px;
  height: 450px;
  background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
  border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
  animation: morph 8s ease-in-out infinite both alternate;
  z-index: 0;
  opacity: 0.7;
  filter: blur(20px);
}

.hero-image {
  position: relative;
  z-index: 1;
  width: 400px;
  height: 500px;
  object-fit: cover;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
  transform: rotate(3deg);
  transition: transform 0.5s ease;
}

.hero-image:hover {
  transform: rotate(0deg) scale(1.02);
}

/* CATEGORIES SECTION */
.categories-section {
  padding: 0 10%;
}

.section-title {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 40px;
  position: relative;
}

.categories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}

.category-card {
  background: white;
  border-radius: 20px;
  padding: 30px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  border: 1px solid rgba(0,0,0,0.02);
  display: flex;
  flex-direction: column;
}

.category-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0,0,0,0.08);
}

.card-icon {
  font-size: 3rem;
  margin-bottom: 15px;
}

.category-card h3 {
  font-size: 1.5rem;
  margin: 0 0 10px 0;
  color: #2d3436;
}

.category-card p {
  color: #636e72;
  line-height: 1.6;
  flex: 1;
}

.read-more {
  margin-top: 20px;
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 700;
  display: flex;
  align-items: center;
  transition: gap 0.2s;
  gap: 5px;
}

.category-card:hover .read-more {
  gap: 10px;
}

/* ANIMATIONS */
@keyframes morph {
  0% { border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%; }
  100% { border-radius: 60% 40% 20% 80% / 60% 30% 70% 50%; }
}

.bounce-in {
  animation: bounceIn 1s cubic-bezier(0.215, 0.61, 0.355, 1) forwards;
}

.fade-in {
  animation: fadeIn 1.5s ease-out forwards;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(255, 107, 107, 0.2);
  border-top-color: var(--primary-color);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 0 auto;
}

.loader {
  text-align: center;
  padding: 40px;
  color: #a4b0be;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes bounceIn {
  0% { opacity: 0; transform: scale3d(.3, .3, .3); }
  20% { transform: scale3d(1.1, 1.1, 1.1); }
  40% { transform: scale3d(.9, .9, .9); }
  60% { opacity: 1; transform: scale3d(1.03, 1.03, 1.03); }
  80% { transform: scale3d(.97, .97, .97); }
  100% { opacity: 1; transform: scale3d(1, 1, 1); }
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Responsive */
@media (max-width: 768px) {
  .hero {
    flex-direction: column;
    text-align: center;
    padding-top: 60px;
  }
  
  .hero-content h1 {
    font-size: 3rem;
  }
  
  .hero-image-container {
    margin-top: 40px;
  }
  
  .hero-image {
    width: 300px;
    height: 350px;
  }
}
</style>
