<script setup>
defineProps({
  book: {
    type: Object,
    required: true
  }
})
</script>

<template>
  <div class="book-card">
    <div class="book-cover">
      <!-- Fallback image -->
      <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cover" />
      <div class="book-tag" v-if="book.category">{{ book.category.name || 'Livre' }}</div>
    </div>
    <div class="book-info">
      <h3>{{ book.title || 'Titre inconnu' }}</h3>
      <p class="author">Par {{ book.author || 'Auteur inconnu' }}</p>
      
      <div class="book-meta">
        <span class="status available">Disponible</span>
        <RouterLink :to="{ name: 'book.show', params: { categoryId: book.category_id || 1, bookId: book.id } }" class="btn-detail">
          Détails &rarr;
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<style scoped>
.book-card {
  background: white;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0,0,0,0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid rgba(0,0,0,0.03);
  display: flex;
  flex-direction: column;
}

.book-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.book-cover {
  position: relative;
  height: 200px;
  overflow: hidden;
}

.book-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.book-card:hover .book-cover img {
  transform: scale(1.05);
}

.book-tag {
  position: absolute;
  top: 15px;
  right: 15px;
  background: var(--secondary-color);
  color: #fff;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
}

.book-info {
  padding: 20px;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.book-info h3 {
  margin: 0 0 5px 0;
  font-size: 1.25rem;
  color: #2d3436;
}

.author {
  color: #636e72;
  font-size: 0.9rem;
  margin-bottom: 20px;
}

.book-meta {
  margin-top: auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.status {
  font-size: 0.85rem;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 6px;
  background: #e8f8f5;
  color: #1abc9c;
}

.btn-detail {
  text-decoration: none;
  font-weight: 600;
  color: var(--primary-color);
  font-size: 0.95rem;
  transition: opacity 0.2s;
}

.btn-detail:hover {
  opacity: 0.7;
}
</style>
