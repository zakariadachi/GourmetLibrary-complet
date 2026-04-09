<script setup>
import { ref, onMounted, computed } from 'vue'
import Card from '../components/Card.vue'

const books = ref([])
const loading = ref(true)
const searchQuery = ref('')

const fetchBooks = async () => {
  try {
    const response = await fetch('http://127.0.0.1:8000/api/books')
    const data = await response.json()
    books.value = data.data || data
  } catch (error) {
    console.error('Error fetching books:', error)
  } finally {
    loading.value = false
  }
}

const filteredBooks = computed(() => {
  if (!searchQuery.value) return books.value
  const q = searchQuery.value.toLowerCase()
  return books.value.filter(b => 
    (b.title && b.title.toLowerCase().includes(q)) || 
    (b.author && b.author.toLowerCase().includes(q)) ||
    (b.category && b.category.name && b.category.name.toLowerCase().includes(q))
  )
})

onMounted(() => {
  fetchBooks()
})
</script>

<template>
  <div class="page-container">
    <div class="header-section">
      <h1 class="page-title">Notre Bibliothèque</h1>
      <p class="page-subtitle">Découvrez notre collection complète de livres de cuisine.</p>
      
      <div class="search-bar">
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="Rechercher par titre, auteur, ou catégorie..." 
          class="search-input"
        />
      </div>
    </div>

    <div v-if="loading" class="loader">
      <div class="spinner"></div>
      <p>Chargement du catalogue...</p>
    </div>

    <div v-else-if="filteredBooks.length === 0" class="empty-state">
      <h3>Aucun livre trouvé.</h3>
      <p v-if="searchQuery">Aucun résultat ne correspond à votre recherche "{{ searchQuery }}".</p>
      <p v-else>Notre bibliothèque est en cours de réapprovisionnement.</p>
    </div>

    <div v-else class="books-grid">
      <Card v-for="book in filteredBooks" :key="book.id" :book="book" />
    </div>
  </div>
</template>

<style scoped>
.page-container {
  padding: 40px 10%;
  min-height: calc(100vh - 70px);
}

.header-section {
  text-align: center;
  margin-bottom: 50px;
  padding: 40px;
  background: white;
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}

.search-bar {
  margin-top: 25px;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.search-input {
  width: 100%;
  padding: 16px 24px;
  border-radius: 30px;
  border: 1px solid #dfe6e9;
  font-size: 1.05rem;
  font-family: inherit;
  outline: none;
  transition: all 0.3s;
  box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
}

.search-input:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
}

.page-title {
  font-size: 2.5rem;
  color: #2d3436;
  margin-bottom: 15px;
}

.page-subtitle {
  color: #636e72;
  font-size: 1.1rem;
}

.books-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 30px;
}

.empty-state {
  text-align: center;
  padding: 60px;
  color: #a4b0be;
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

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>
