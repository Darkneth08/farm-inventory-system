<template>
  <div class="login-container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h4>Farm Inventory System</h4>
          </div>
          <div class="card-body">
            <form @submit.prevent="handleLogin">
              <div class="mb-3">
                <label>Email</label>
                <input type="email" v-model="form.email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" v-model="form.password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                {{ loading ? 'Logging in...' : 'Login' }}
              </button>
              <div v-if="error" class="alert alert-danger mt-3">
                {{ error }}
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import authService from '../services/auth';

export default {
  setup() {
    const router = useRouter();
    const form = ref({ email: '', password: '' });
    const loading = ref(false);
    const error = ref('');

    const handleLogin = async () => {
      loading.value = true;
      error.value = '';
      
      const result = await authService.login(form.value);
      
      if (result.success) {
        router.push('/');
      } else {
        error.value = result.message;
      }
      
      loading.value = false;
    };

    return { form, loading, error, handleLogin };
  }
};
</script>