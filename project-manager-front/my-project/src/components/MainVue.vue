<template>
    <div class="main">
      <HeaderComponent />
      <component :is="currentMainPage" :user="user" />
    </div>
  </template>
  
  <script>
    import HeaderComponent from './HeaderComponent.vue';
    import MainPage from './MainPageAdmin.vue';
    import MainPageManager from './MainPageManager.vue';
    import MainPageExecutor from './MainPageExecutor.vue';

  
  export default {
    data() {
      return {
        user: null,
      };
    },
    computed: {
      currentMainPage() {
        if (this.user) {
        if (this.user.role === 'Админ') {
          return MainPage;
        } else if (this.user.role === 'Руководитель проекта') {
          return MainPageManager;
        } else if (this.user.role === 'Исполнитель') {
          return MainPageExecutor; // Возвращаем компонент для исполнителя
        }
      }
        return null;
      },
    },
    created() {
      const userData = localStorage.getItem('user');
      if (userData) {
        this.user = JSON.parse(userData);
      } else {
        this.$router.push('/login');
      }
    },
    components: {
      HeaderComponent,
      MainPage,
      MainPageManager,
      MainPageExecutor,
    },
  };
  </script>
  
  <style scoped>
  .main {
    padding: 20px;
  }
  </style>
  