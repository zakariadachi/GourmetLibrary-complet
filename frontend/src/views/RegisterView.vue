<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const loading = ref(false)
const errorMsg = ref('')

const handleRegister = async () => {
  if (password.value !== password_confirmation.value) {
    errorMsg.value = 'Les mots de passe ne correspondent pas.'
    return
  }

  loading.value = true
  errorMsg.value = ''
  
  try {
    const response = await fetch('http://127.0.0.1:8000/api/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
      })
    })

    const data = await response.json()

    if (response.ok) {
      // Automatic login after register, store token
      if(data.token || data.access_token) {
         localStorage.setItem('auth_token', data.token || data.access_token)
      }
      router.push('/')
    } else {
      errorMsg.value = data.message || "Erreur lors de l'inscription."
    }
  } catch (error) {
    errorMsg.value = 'Erreur de connexion au serveur.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="auth-layout">
    <div class="auth-form-container">
      <div class="form-wrapper">
        <h1 class="auth-title">Inscription</h1>
        <p class="auth-subtitle">Rejoignez notre librairie culinaire.</p>

        <form @submit.prevent="handleRegister" class="auth-form">
          <div v-if="errorMsg" class="error-alert">{{ errorMsg }}</div>
          
          <div class="input-group">
            <label for="name">Nom Complet</label>
            <input type="text" id="name" v-model="name" placeholder="Marie Dubois" required />
          </div>

          <div class="input-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" v-model="email" placeholder="marie@exemple.com" required />
          </div>
          
          <div class="input-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" v-model="password" placeholder="••••••••" required minlength="8" />
          </div>

          <div class="input-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" v-model="password_confirmation" placeholder="••••••••" required />
          </div>

          <button type="submit" class="btn-submit" :disabled="loading">
            {{ loading ? 'Inscription...' : 'Créer mon compte' }}
          </button>
        </form>
        
        <p class="auth-footer">
          Déjà un compte ? 
          <RouterLink to="/login" class="auth-link">Se connecter</RouterLink>
        </p>
      </div>
    </div>
    
    <div class="auth-illustration">
      <div class="glass-overlay">
        <h2>Commencez l'aventure</h2>
        <p>Plus de 1000 ouvrages culinaires à votre disposition.</p>
      </div>
      <img src="https://images.unsplash.com/photo-1466637574441-749b8f19452f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Cooking ingredients" />
    </div>
  </div>
</template>

<style scoped>
.auth-layout {
  display: flex;
  min-height: calc(100vh - 70px);
  background: var(--bg-color);
}

.auth-illustration {
  flex: 1;
  display: none;
  position: relative;
  overflow: hidden;
}

@media (min-width: 900px) {
  .auth-illustration {
    display: block;
  }
}

.auth-illustration img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.glass-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  padding: 40px;
  border-radius: 20px;
  text-align: center;
  color: white;
  border: 1px solid rgba(255,255,255,0.3);
  width: 80%;
  max-width: 400px;
}

.glass-overlay h2 {
  font-size: 2.5rem;
  margin-bottom: 10px;
  text-shadow: 0 2px 4px rgba(0,0,0,0.5);
}

.glass-overlay p {
  font-size: 1.2rem;
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
}

.auth-form-container {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 40px;
}

.form-wrapper {
  width: 100%;
  max-width: 450px;
  background: white;
  padding: 40px;
  border-radius: 24px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.04);
}

.auth-title {
  font-size: 2.5rem;
  color: #2d3436;
  margin-bottom: 5px;
}

.auth-subtitle {
  color: #636e72;
  margin-bottom: 25px;
  font-size: 1.1rem;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.input-group label {
  font-weight: 600;
  color: #2d3436;
  font-size: 0.95rem;
}

.input-group input {
  padding: 14px;
  border: 1px solid #dfe6e9;
  border-radius: 12px;
  font-size: 1rem;
  transition: border-color 0.3s, box-shadow 0.3s;
  outline: none;
  background: #fdfbf7;
}

.input-group input:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.15);
  background: white;
}

.btn-submit {
  margin-top: 10px;
  background: linear-gradient(135deg, var(--primary-color), #ff4757);
  color: white;
  border: none;
  padding: 16px;
  font-size: 1.1rem;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 8px 15px rgba(255, 107, 107, 0.25);
}

.btn-submit:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 12px 20px rgba(255, 107, 107, 0.35);
}

.btn-submit:disabled {
  background: #bdc3c7;
  cursor: not-allowed;
  box-shadow: none;
}

.error-alert {
  background: #fee2e2;
  color: #ef4444;
  padding: 15px;
  border-radius: 10px;
  font-weight: 500;
  font-size: 0.95rem;
  text-align: center;
}

.auth-footer {
  margin-top: 25px;
  text-align: center;
  color: #636e72;
}

.auth-link {
  color: var(--primary-color);
  font-weight: 700;
  text-decoration: none;
}

.auth-link:hover {
  text-decoration: underline;
}
</style>
