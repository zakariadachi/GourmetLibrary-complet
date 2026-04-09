<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const book = ref(null)
const loading = ref(true)

const fetchBookDetail = async () => {
  try {
    const { categoryId, bookId } = route.params
    // Assuming backend returns book detailed info including copies
    const response = await fetch(`http://127.0.0.1:8000/api/categories/${categoryId}/books/${bookId}`)
    if (!response.ok) throw new Error('Book not found')
    
    const data = await response.json()
    book.value = data.data || data
  } catch (error) {
    console.error('Error fetching book:', error)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchBookDetail()
})
</script>

<template>
  <div class="page-container">
    <div v-if="loading" class="loader">
      <div class="spinner"></div>
      <p>Consultation de l'ouvrage...</p>
    </div>

    <div v-else-if="!book" class="error-state">
      <h1>Livre introuvable.</h1>
      <button @click="router.back()" class="btn-back">Retour</button>
    </div>

    <div v-else class="book-detail">
      <button @click="router.back()" class="btn-back">&larr; Retour</button>
      
      <div class="detail-content">
        <div class="book-cover-large">
          <img src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cover" />
        </div>
        
        <div class="book-info-large">
          <div class="tag" v-if="book.category">{{ book.category.name || 'Général' }}</div>
          <h1 class="title">{{ book.title }}</h1>
          <p class="author">Par <strong>{{ book.author }}</strong></p>
          
          <div class="divider"></div>
          
          <div class="description">
            <h3>À propos de cet ouvrage</h3>
            <p>{{ book.summary || book.description || 'Aucune description fournie pour ce livre magnifique.' }}</p>
          </div>
          
          <div class="stock-info">
            <div class="stat-box">
              <span class="stat-number">{{ book.copies_count || book.copies?.length || 0 }}</span>
              <span class="stat-label">Exemplaire(s) Total</span>
            </div>
            <div class="stat-box highlight-box">
               <span class="stat-number">{{ book.available_copies || (book.copies || []).filter(c => c.status === 'available').length || 0 }}</span>
               <span class="stat-label">Disponible(s)</span>
            </div>
          </div>
          
          <button class="btn-borrow" :disabled="(book.available_copies === 0)">Emprunter cet ouvrage</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-container {
  padding: 40px 10%;
  min-height: calc(100vh - 70px);
}

.btn-back {
  background: none;
  border: none;
  color: #636e72;
  font-size: 1rem;
  cursor: pointer;
  margin-bottom: 30px;
  font-weight: 600;
  transition: color 0.2s;
}

.btn-back:hover {
  color: var(--text-color);
}

.detail-content {
  display: flex;
  gap: 60px;
  background: white;
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.05);
}

.book-cover-large {
  flex: 0 0 350px;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.book-cover-large img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.book-info-large {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.tag {
  align-self: flex-start;
  padding: 6px 16px;
  background: rgba(254, 202, 87, 0.2);
  color: #e1b12c;
  border-radius: 20px;
  font-weight: 700;
  font-size: 0.9rem;
  margin-bottom: 20px;
}

.title {
  font-size: 3rem;
  line-height: 1.1;
  color: #2d3436;
  margin: 0 0 10px 0;
}

.author {
  font-size: 1.2rem;
  color: #636e72;
  margin: 0;
}

.divider {
  height: 1px;
  background: #eee;
  margin: 30px 0;
}

.description h3 {
  margin-top: 0;
  color: #2d3436;
}

.description p {
  color: #636e72;
  line-height: 1.7;
}

.stock-info {
  display: flex;
  gap: 20px;
  margin-top: 40px;
  margin-bottom: 40px;
}

.stat-box {
  background: #fdfbf7;
  padding: 20px;
  border-radius: 12px;
  text-align: center;
  flex: 1;
  border: 1px solid #eee;
}

.stat-box.highlight-box {
  background: rgba(46, 204, 113, 0.1);
  border-color: rgba(46, 204, 113, 0.3);
}

.highlight-box .stat-number {
  color: #27ae60;
}

.stat-number {
  display: block;
  font-size: 2.5rem;
  font-weight: 800;
  color: #2d3436;
  margin-bottom: 5px;
}

.stat-label {
  color: #636e72;
  font-size: 0.9rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.btn-borrow {
  background: linear-gradient(135deg, var(--primary-color), #ff4757);
  color: white;
  border: none;
  padding: 18px;
  font-size: 1.1rem;
  font-weight: 700;
  border-radius: 12px;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 10px 20px rgba(255, 107, 107, 0.3);
}

.btn-borrow:disabled {
  background: #bdc3c7;
  box-shadow: none;
  cursor: not-allowed;
  transform: none;
}

.btn-borrow:not(:disabled):hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 25px rgba(255, 107, 107, 0.4);
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

.loader, .error-state {
  text-align: center;
  padding: 80px;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

@media (max-width: 900px) {
  .detail-content {
    flex-direction: column;
  }
  .book-cover-large {
    flex: none;
    height: 400px;
  }
}
</style>
