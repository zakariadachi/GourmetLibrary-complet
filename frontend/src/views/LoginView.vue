<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')
const loading = ref(false)
const errorMsg = ref('')

const handleLogin = async () => {
  loading.value = true
  errorMsg.value = ''
  
  try {
    const response = await fetch('http://127.0.0.1:8000/api/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })

    const data = await response.json()

    if (response.ok) {
      // Store token (in a real app, use Pinia/Vuex and secure storage)
      localStorage.setItem('auth_token', data.token || data.access_token)
      router.push('/')
    } else {
      errorMsg.value = data.message || 'Identifiants incorrects.'
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
    <div class="auth-illustration">
      <div class="glass-overlay">
        <h2>Bon Retour !</h2>
        <p>Vos recettes préférées vous attendent.</p>
      </div>
      <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Kitchen" />
    </div>
    
    <div class="auth-form-container">
      <div class="form-wrapper">
        <h1 class="auth-title">Connexion</h1>
        <p class="auth-subtitle">Accédez à votre compte pour gérer vos emprunts.</p>

        <form @submit.prevent="handleLogin" class="auth-form">
          <div v-if="errorMsg" class="error-alert">{{ errorMsg }}</div>
          
          <div class="input-group">
            <label for="email">Adresse Email</label>
            <input type="email" id="email" v-model="email" placeholder="gourmand@exemple.com" required />
          </div>
          
          <div class="input-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" v-model="password" placeholder="••••••••" required />
          </div>

          <button type="submit" class="btn-submit" :disabled="loading">
            {{ loading ? 'Connexion en cours...' : 'Se Connecter' }}
          </button>
        </form>
        
        <p class="auth-footer">
          Pas encore de compte ? 
          <RouterLink to="/register" class="auth-link">Créer un compte</RouterLink>
        </p>
      </div>
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
  background: rgba(255, 255, 255, 0.2);
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
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.glass-overlay p {
  font-size: 1.2rem;
  text-shadow: 0 1px 2px rgba(0,0,0,0.3);
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
  padding: 50px;
  border-radius: 24px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.04);
}

.auth-title {
  font-size: 2.5rem;
  color: #2d3436;
  margin-bottom: 10px;
}

.auth-subtitle {
  color: #636e72;
  margin-bottom: 30px;
  font-size: 1.1rem;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.input-group label {
  font-weight: 600;
  color: #2d3436;
  font-size: 0.95rem;
}

.input-group input {
  padding: 16px;
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
  margin-top: 30px;
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
