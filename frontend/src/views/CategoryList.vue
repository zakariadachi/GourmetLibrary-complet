<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute } from 'vue-router'
import Card from '../components/Card.vue'

const route = useRoute()
const books = ref([])
const category = ref(null)
const loading = ref(true)

const fetchCategoryBooks = async (categoryId) => {
  loading.value = true
  try {
    // 1. Fetch category details
    const catResponse = await fetch(`http://127.0.0.1:8000/api/categories/${categoryId}`)
    if (catResponse.ok) {
      const catData = await catResponse.json()
      category.value = catData.data || catData
    }

    // 2. Fetch books for this category
    const res = await fetch(`http://127.0.0.1:8000/api/categories/${categoryId}/books`)
    const data = await res.json()
    books.value = data.data || data || []
  } catch (error) {
    console.error('Error fetching category books:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchCategoryBooks(route.params.categoryId)
})

watch(() => route.params.categoryId, (newId) => {
  if (newId) fetchCategoryBooks(newId)
})
</script>

<template>
  <div class="page-container">
    <div class="category-header">
      <RouterLink to="/" class="back-link">&larr; Retour aux catégories</RouterLink>
      <h1 class="page-title">{{ category?.name || category?.title || 'Catégorie...' }}</h1>
      <p class="page-subtitle">{{ category?.description || 'Découvrez tous les ouvrages de cette belle collection.' }}</p>
    </div>

    <div v-if="loading" class="loader">
      <div class="spinner"></div>
    </div>

    <div v-else-if="books.length === 0" class="empty-state">
      <div class="empty-icon">📂</div>
      <h3>Aucun livre d'appétit ici.</h3>
      <p>Cette catégorie ne contient actuellement aucun livre.</p>
    </div>

    <div v-else class="books-grid">
      <Card v-for="book in books" :key="book.id" :book="{ ...book, category_id: route.params.categoryId }" />
    </div>
  </div>
</template>

<style scoped>
.page-container {
  padding: 40px 10%;
  min-height: calc(100vh - 70px);
}

.category-header {
  margin-bottom: 50px;
}

.back-link {
  display: inline-block;
  margin-bottom: 20px;
  color: var(--primary-color);
  text-decoration: none;
  font-weight: 600;
}

.page-title {
  font-size: 3rem;
  color: #2d3436;
  margin-bottom: 10px;
}

.page-subtitle {
  color: #636e72;
  font-size: 1.2rem;
  max-width: 600px;
}

.books-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 30px;
}

.empty-state {
  text-align: center;
  padding: 80px 20px;
  background: white;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}

.empty-icon {
  font-size: 4rem;
  margin-bottom: 20px;
  opacity: 0.5;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(255, 107, 107, 0.2);
  border-top-color: var(--primary-color);
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin: 60px auto;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
