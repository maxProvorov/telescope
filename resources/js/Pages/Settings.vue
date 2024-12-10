<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Выбрать настройку
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="container mt-5">
                            <div class="mb-3">
                                <label for="methodSelect" class="form-label">Способ подтверждения</label>
                                <select v-model="selectedMethod" id="methodSelect" class="form-select">
                                    <option v-for="(method, index) in methods" :key="index" :value="method">
                                        {{ method.charAt(0).toUpperCase() + method.slice(1) }}
                                    </option>
                                </select>
                            </div>
                            <button @click="sendCode" class="btn btn-primary mb-3">Сохранить</button>
                            <div v-if="successMessage" class="alert alert-success mt-3">
                                {{ successMessage }}
                            </div>

                            <div v-if="isCodeSent" class="mt-4">
                                <label for="confirmationCode" class="form-label">Введите код подтверждения</label>
                                <input
                                    v-model="confirmationCode"
                                    id="confirmationCode"
                                    type="text"
                                    class="form-control mb-3"
                                    placeholder="Введите код"
                                />
                                <button @click="verifyCode" class="btn btn-success">Подтвердить</button>
                                <div v-if="errorMessage" class="alert alert-danger mt-3 fade-in">
                                    <i class="bi bi-exclamation-circle-fill me-2"></i> {{ errorMessage }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    currentMethod: {
      type: String,
    },
    methods: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedMethod: this.currentMethod,
      confirmationCode: '',
      isCodeSent: false,
      generatedCode: '',
      errorMessage: '',
      successMessage: '',
    };
  },
  methods: {
    async sendCode() {
      this.clearMessages();

      // Генерация случайного кода
      this.generatedCode = Math.floor(1000 + Math.random() * 9000).toString();
      this.isCodeSent = true;

      // Вывод кода через alert (имитация отправки)
      alert(`Код подтверждения через ${this.currentMethod}: ${this.generatedCode}`);
      
    },

    async verifyCode() {
      this.clearMessages();

      // Проверка кода
      if (this.confirmationCode === this.generatedCode) {
        try {
          await axios.patch('/settings', { method: this.selectedMethod });
          
          this.successMessage = 'Код подтверждён! Настройка сохранена.';
          this.isCodeSent = false;
          this.confirmationCode = '';
        } catch (error) {
          this.errorMessage = 'Произошла ошибка при сохранении настройки.';
        }
      } else {
        this.errorMessage = 'Неверный код! Попробуйте ещё раз.';
      }
    },

    clearMessages() {
      this.errorMessage = '';
      this.successMessage = '';
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
}

.fade-in {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}
</style>
